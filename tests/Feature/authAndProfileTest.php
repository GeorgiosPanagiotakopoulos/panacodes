<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_register_page(): void
    {
        $this->get(route('register'))
            ->assertOk();
    }

    public function test_user_can_register(): void
    {
        $this->post('/register', [
            'name' => 'Georgios Panagiotakopoulos',
            'email' => 'georgios@example.com',
            'password' => 'password123',
        ])
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Registration complete!');

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'Georgios Panagiotakopoulos',
            'email' => 'georgios@example.com',
        ]);
    }

    public function test_register_requires_valid_data(): void
    {
        $this->post('/register', [
            'name' => 'ab',
            'email' => 'not-an-email',
            'password' => 'short',
        ])
            ->assertSessionHasErrors(['name', 'email', 'password']);

        $this->assertGuest();
    }

    public function test_registered_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'georgios@example.com',
        ]);

        $this->post('/register', [
            'name' => 'Another User',
            'email' => 'georgios@example.com',
            'password' => 'password123',
        ])
            ->assertSessionHasErrors('email');
    }

    public function test_guest_can_view_login_page(): void
    {
        $this->get(route('login'))
            ->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'georgios@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->post('/login', [
            'email' => 'georgios@example.com',
            'password' => 'password123',
        ])
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'georgios@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->from('/login')
            ->post('/login', [
                'email' => 'georgios@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_guest_cannot_view_profile_edit_page(): void
    {
        $this->get(route('profile.edit'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_profile_edit_page(): void
    {
        $user = User::factory()->create([
            'name' => 'Georgios',
            'email' => 'georgios@example.com',
        ]);

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertSee('Georgios')
            ->assertSee('georgios@example.com');
    }

    public function test_authenticated_user_can_update_profile_name_and_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => 'New Name',
                'email' => 'new@example.com',
                'password' => '',
            ])
            ->assertRedirect('/profile')
            ->assertSessionHas('success', 'Profile Update!');

        $user->refresh();

        $this->assertSame('New Name', $user->name);
        $this->assertSame('new@example.com', $user->email);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_authenticated_user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'new-password123',
            ])
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password123', $user->fresh()->password));
    }

    public function test_profile_update_requires_valid_data(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from('/profile')
            ->patch(route('profile.update'), [
                'name' => 'ab',
                'email' => 'not-an-email',
                'password' => 'short',
            ])
            ->assertRedirect('/profile')
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_profile_email_must_be_unique_except_for_current_user(): void
    {
        User::factory()->create([
            'email' => 'taken@example.com',
        ]);

        $user = User::factory()->create([
            'email' => 'current@example.com',
        ]);

        $this->actingAs($user)
            ->from('/profile')
            ->patch(route('profile.update'), [
                'name' => 'Current User',
                'email' => 'taken@example.com',
                'password' => '',
            ])
            ->assertRedirect('/profile')
            ->assertSessionHasErrors('email');
    }
}