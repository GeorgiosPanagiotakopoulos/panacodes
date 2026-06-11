<?php

namespace Tests\Feature;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\Step;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    private function validIdeaData(array $overrides = []): array
    {
        return array_replace([
            'title' => 'Build an idea tracker',
            'description' => 'A simple app for tracking project ideas.',
            'status' => IdeaStatus::PENDING->value,
            'links' => ['https://example.com'],
            'steps' => ['Plan database', 'Build UI'],
        ], $overrides);
    }

    public function test_guest_cannot_view_ideas_index(): void
    {
        $this->get(route('ideas.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_create_an_idea(): void
    {
        $this->post(route('idea.store'), $this->validIdeaData())
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('ideas', 0);
    }

    public function test_guest_cannot_view_single_idea(): void
    {
        $idea = Idea::factory()->create();

        $this->get(route('idea.show', $idea))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_update_an_idea(): void
    {
        $idea = Idea::factory()->create();

        $this->patch(route('idea.update', $idea), $this->validIdeaData([
            'title' => 'Updated title',
        ]))->assertRedirect(route('login'));

        $this->assertDatabaseMissing('ideas', [
            'id' => $idea->id,
            'title' => 'Updated title',
        ]);
    }

    public function test_guest_cannot_delete_an_idea(): void
    {
        $idea = Idea::factory()->create();

        $this->delete(route('idea.destroy', $idea))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
        ]);
    }

    public function test_authenticated_user_can_view_only_their_own_ideas_on_index(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Idea::factory()->for($user)->create([
            'title' => 'My visible idea',
        ]);

        Idea::factory()->for($otherUser)->create([
            'title' => 'Someone else idea',
        ]);

        $this->actingAs($user)
            ->get(route('ideas.index'))
            ->assertOk()
            ->assertSeeText('My visible idea')
            ->assertDontSeeText('Someone else idea');
    }

    public function test_authenticated_user_can_filter_ideas_by_status(): void
    {
        $user = User::factory()->create();

        Idea::factory()->for($user)->create([
            'title' => 'Pending idea',
            'status' => IdeaStatus::PENDING->value,
        ]);

        Idea::factory()->for($user)->create([
            'title' => 'Completed idea',
            'status' => IdeaStatus::COMPLETED->value,
        ]);

        $this->actingAs($user)
            ->get(route('ideas.index', ['status' => IdeaStatus::COMPLETED->value]))
            ->assertOk()
            ->assertSeeText('Completed idea')
            ->assertDontSeeText('Pending idea');
    }

    public function test_authenticated_user_can_create_an_idea(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('idea.store'), $this->validIdeaData())
            ->assertRedirect(route('ideas.index'))
            ->assertSessionHas('success', 'Idea created!');

        $idea = Idea::first();

        $this->assertNotNull($idea);
        $this->assertTrue($idea->user->is($user));
        $this->assertSame('Build an idea tracker', $idea->title);
        $this->assertSame(IdeaStatus::PENDING, $idea->status);
        $this->assertSame(['https://example.com'], $idea->links->getArrayCopy());

        $this->assertDatabaseHas('steps', [
            'idea_id' => $idea->id,
            'description' => 'Plan database',
        ]);

        $this->assertDatabaseHas('steps', [
            'idea_id' => $idea->id,
            'description' => 'Build UI',
        ]);
    }

    public function test_empty_steps_are_ignored_when_creating_an_idea(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('idea.store'), $this->validIdeaData([
                'steps' => ['First real step', '', null, 'Second real step'],
            ]))
            ->assertRedirect(route('ideas.index'));

        $idea = Idea::first();

        $this->assertCount(2, $idea->steps);
        $this->assertSame(
            ['First real step', 'Second real step'],
            $idea->steps->pluck('description')->all()
        );
    }

    public function test_authenticated_user_can_create_an_idea_with_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('idea.store'), $this->validIdeaData([
                'image' => UploadedFile::fake()->image('idea.jpg'),
            ]))
            ->assertRedirect(route('ideas.index'));

        $idea = Idea::first();

        $this->assertNotNull($idea->image_path);
        Storage::disk('public')->assertExists($idea->image_path);
    }

    public function test_title_is_required_when_creating_an_idea(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('ideas.index'))
            ->post(route('idea.store'), $this->validIdeaData([
                'title' => '',
            ]))
            ->assertRedirect(route('ideas.index'))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('ideas', 0);
    }

    public function test_status_must_be_valid_when_creating_an_idea(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('ideas.index'))
            ->post(route('idea.store'), $this->validIdeaData([
                'status' => 'invalid-status',
            ]))
            ->assertRedirect(route('ideas.index'))
            ->assertSessionHasErrors('status');

        $this->assertDatabaseCount('ideas', 0);
    }

    public function test_links_must_be_valid_urls(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('ideas.index'))
            ->post(route('idea.store'), $this->validIdeaData([
                'links' => ['not-a-url'],
            ]))
            ->assertRedirect(route('ideas.index'))
            ->assertSessionHasErrors('links.0');

        $this->assertDatabaseCount('ideas', 0);
    }

    public function test_image_must_be_an_image_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('ideas.index'))
            ->post(route('idea.store'), $this->validIdeaData([
                'image' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
            ]))
            ->assertRedirect(route('ideas.index'))
            ->assertSessionHasErrors('image');

        $this->assertDatabaseCount('ideas', 0);
    }

    public function test_owner_can_view_their_idea(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create([
            'title' => 'Visible idea',
            'description' => 'Visible description',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertOk()
            ->assertSeeText('Visible idea')
            ->assertSeeText('Visible description');
    }

    public function test_non_owner_cannot_view_someone_elses_idea(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $idea = Idea::factory()->for($otherUser)->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertForbidden();
    }

    public function test_owner_can_update_an_idea(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create([
            'title' => 'Old title',
            'status' => IdeaStatus::PENDING->value,
        ]);

        $this->actingAs($user)
            ->patch(route('idea.update', $idea), $this->validIdeaData([
                'title' => 'Updated title',
                'description' => 'Updated description',
                'status' => IdeaStatus::IN_PROGRESS->value,
                'links' => ['https://laravel.com'],
                'steps' => ['Updated step'],
            ]))
            ->assertRedirect(route('ideas.index'))
            ->assertSessionHas('success', 'Idea updated!');

        $idea->refresh();

        $this->assertSame('Updated title', $idea->title);
        $this->assertSame('Updated description', $idea->description);
        $this->assertSame(IdeaStatus::IN_PROGRESS, $idea->status);
        $this->assertSame(['https://laravel.com'], $idea->links->getArrayCopy());

        $this->assertDatabaseHas('steps', [
            'idea_id' => $idea->id,
            'description' => 'Updated step',
        ]);
    }

    public function test_updating_an_idea_replaces_existing_steps(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create();

        Step::factory()->for($idea)->create([
            'description' => 'Old step',
        ]);

        $this->actingAs($user)
            ->patch(route('idea.update', $idea), $this->validIdeaData([
                'steps' => ['New step one', 'New step two'],
            ]))
            ->assertRedirect(route('ideas.index'));

        $this->assertDatabaseMissing('steps', [
            'idea_id' => $idea->id,
            'description' => 'Old step',
        ]);

        $this->assertDatabaseHas('steps', [
            'idea_id' => $idea->id,
            'description' => 'New step one',
        ]);

        $this->assertDatabaseHas('steps', [
            'idea_id' => $idea->id,
            'description' => 'New step two',
        ]);
    }

    public function test_owner_can_remove_all_steps_when_updating_an_idea(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create();

        Step::factory()->for($idea)->create();

        $this->actingAs($user)
            ->patch(route('idea.update', $idea), $this->validIdeaData([
                'steps' => [],
            ]))
            ->assertRedirect(route('ideas.index'));

        $this->assertFalse($idea->fresh()->steps()->exists());
    }

    public function test_non_owner_cannot_update_someone_elses_idea(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $idea = Idea::factory()->for($otherUser)->create([
            'title' => 'Original title',
        ]);

        $this->actingAs($user)
            ->patch(route('idea.update', $idea), $this->validIdeaData([
                'title' => 'Hacked title',
            ]))
            ->assertForbidden();

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'title' => 'Original title',
        ]);
    }

    public function test_owner_can_delete_an_idea(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('idea.destroy', $idea))
            ->assertRedirect(route('ideas.index'));

        $this->assertDatabaseMissing('ideas', [
            'id' => $idea->id,
        ]);
    }

    public function test_deleting_an_idea_also_deletes_its_steps(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create();

        $step = Step::factory()->for($idea)->create();

        $this->actingAs($user)
            ->delete(route('idea.destroy', $idea))
            ->assertRedirect(route('ideas.index'));

        $this->assertDatabaseMissing('steps', [
            'id' => $step->id,
        ]);
    }

    public function test_non_owner_cannot_delete_someone_elses_idea(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $idea = Idea::factory()->for($otherUser)->create();

        $this->actingAs($user)
            ->delete(route('idea.destroy', $idea))
            ->assertForbidden();

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
        ]);
    }

    public function test_owner_can_remove_idea_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Storage::disk('public')->put('ideas/test.jpg', 'fake-image-content');

        $idea = Idea::factory()->for($user)->create([
            'image_path' => 'ideas/test.jpg',
        ]);

        $this->actingAs($user)
            ->delete(route('idea.image.destroy', $idea))
            ->assertRedirect();

        Storage::disk('public')->assertMissing('ideas/test.jpg');

        $this->assertNull($idea->fresh()->image_path);
    }

    public function test_non_owner_cannot_remove_someone_elses_idea_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Storage::disk('public')->put('ideas/test.jpg', 'fake-image-content');

        $idea = Idea::factory()->for($otherUser)->create([
            'image_path' => 'ideas/test.jpg',
        ]);

        $this->actingAs($user)
            ->delete(route('idea.image.destroy', $idea))
            ->assertForbidden();

        Storage::disk('public')->assertExists('ideas/test.jpg');

        $this->assertSame('ideas/test.jpg', $idea->fresh()->image_path);
    }

    public function test_owner_can_toggle_a_step_completion(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create();

        $step = Step::factory()->for($idea)->create([
            'completed' => false,
        ]);

        $this->actingAs($user)
            ->patch(route('step.update', $step))
            ->assertRedirect();

        $this->assertTrue((bool) $step->fresh()->completed);
    }

    public function test_toggling_a_step_twice_returns_it_to_original_state(): void
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->for($user)->create();

        $step = Step::factory()->for($idea)->create([
            'completed' => false,
        ]);

        $this->actingAs($user)->patch(route('step.update', $step));
        $this->actingAs($user)->patch(route('step.update', $step));

        $this->assertFalse((bool) $step->fresh()->completed);
    }

    public function test_non_owner_cannot_toggle_someone_elses_step(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $idea = Idea::factory()->for($otherUser)->create();

        $step = Step::factory()->for($idea)->create([
            'completed' => false,
        ]);

        $this->actingAs($user)
            ->patch(route('step.update', $step))
            ->assertForbidden();

        $this->assertFalse((bool) $step->fresh()->completed);
    }
}