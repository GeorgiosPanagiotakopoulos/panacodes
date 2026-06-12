<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactTest extends TestCase
{
    private function validContactData(array $overrides = []): array
    {
        return array_replace([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone_number' => '+30 6900000000',
            'message' => 'Hello, I would like to contact you.',
        ], $overrides);
    }

    public function test_contact_page_loads(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSeeText('Contact me');
    }

    public function test_contact_form_sends_email_to_configured_recipient(): void
    {
        Mail::fake();

        config(['mail.contact_recipient' => 'owner@example.com']);

        $this->post(route('contact.store'), $this->validContactData())
            ->assertRedirect()
            ->assertSessionHas('success', 'Message sent successfully!');

        Mail::assertSent(ContactMessage::class, function (ContactMessage $mail) {
            return $mail->hasTo('owner@example.com')
                && $mail->data['name'] === 'John Doe'
                && $mail->data['email'] === 'john@example.com'
                && $mail->data['phone_number'] === '+30 6900000000'
                && $mail->data['message'] === 'Hello, I would like to contact you.';
        });
    }

    public function test_contact_email_has_correct_subject_and_reply_to(): void
    {
        $mail = new ContactMessage($this->validContactData([
            'email' => 'visitor@example.com',
        ]));

        $envelope = $mail->envelope();

        $this->assertSame('New contact form message', $envelope->subject);
        $this->assertSame('visitor@example.com', $envelope->replyTo[0]->address);
    }

    public function test_phone_number_is_optional(): void
    {
        Mail::fake();

        config(['mail.contact_recipient' => 'owner@example.com']);

        $this->post(route('contact.store'), $this->validContactData([
            'phone_number' => null,
        ]))->assertRedirect()
            ->assertSessionHas('success', 'Message sent successfully!');

        Mail::assertSent(ContactMessage::class, function (ContactMessage $mail) {
            return $mail->hasTo('owner@example.com')
                && $mail->data['phone_number'] === null;
        });
    }

    public function test_name_is_required(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), $this->validContactData([
                'name' => '',
            ]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('name');

        Mail::assertNothingSent();
    }

    public function test_email_is_required(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), $this->validContactData([
                'email' => '',
            ]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('email');

        Mail::assertNothingSent();
    }

    public function test_email_must_be_valid(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), $this->validContactData([
                'email' => 'not-an-email',
            ]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('email');

        Mail::assertNothingSent();
    }

    public function test_message_is_required(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), $this->validContactData([
                'message' => '',
            ]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('message');

        Mail::assertNothingSent();
    }

    public function test_message_cannot_be_longer_than_5000_characters(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), $this->validContactData([
                'message' => str_repeat('a', 5001),
            ]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('message');

        Mail::assertNothingSent();
    }

    public function test_phone_number_cannot_be_longer_than_30_characters(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), $this->validContactData([
                'phone_number' => str_repeat('1', 31),
            ]))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('phone_number');

        Mail::assertNothingSent();
    }
}
