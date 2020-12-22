<?php

namespace Tests\Feature;

use App\Http\Livewire\ContactForm;
use App\Jobs\SendContactUsForm;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    /** @test  */
    function main_page_contains_contact_form_livewire_component()
    {
        $this->get('/')->assertSeeLivewire('contact-form');
    }

    /** @test */
    public function contact_form_successfully_submits() {
        Queue::fake();

        $form = Livewire::test(ContactForm::class)
            ->set('name', 'Joe McCorison')
            ->set('email', 'joemccorison@gmail.com')
            ->set('phone', '2185254224')
            ->set('message', 'This is a test');

            // bypass bot detection
            sleep(4);

            $form->call('submitForm')
                ->assertSee(__('messages.contact.success_message'));

        Queue::assertPushed(SendContactUsForm::class, function ($job) {
            $contact = $job->contact;
            $hasEmail = $contact['email'] === 'joemccorison@gmail.com';
            $hasName = $contact['name'] === 'Joe McCorison';
            $hasPhone = $contact['phone'] === '2185254224';
            $hasMessage = $contact['message'] === 'This is a test';

            return $hasEmail && $hasName && $hasPhone && $hasMessage;
        });
    }

    /** @test */
    public function contact_form_requires_name_field() {
        Livewire::test(ContactForm::class)
            ->call('submitForm')
            ->assertHasErrors(['name' => 'required']);

    }

    /** @test */
    public function contact_form_requires_a_name() {
        Livewire::test(ContactForm::class)
            ->set('name', 'test')
            ->call('submitForm')
            ->assertHasErrors(['name' => 'min']);

    }

    /** @test */
    public function contact_form_requires_email_field() {
        Livewire::test(ContactForm::class)
            ->call('submitForm')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function contact_form_requires_valid_email() {
        Livewire::test(ContactForm::class)
            ->set('email', 'notvalid')
            ->call('submitForm')
            ->assertHasErrors(['email' => 'email']);

    }

    /** @test */
    public function contact_form_requires_phone_field() {
        Livewire::test(ContactForm::class)
            ->call('submitForm')
            ->assertHasErrors(['phone' => 'required']);

    }

    /** @test */
    public function contact_form_requires_a_valid_phone_number() {
        Livewire::test(ContactForm::class)
            ->set('phone', 'A2185254224')
            ->assertHasErrors(['phone' => 'regex']);
    }

    /** @test */
    public function contact_form_requires_a_message_field() {
        Livewire::test(ContactForm::class)
            ->call('submitForm')
            ->assertHasErrors(['message' => 'required']);;
    }

    /** @test */
    public function contact_form_requires_a_valid_message() {
        Livewire::test(ContactForm::class)
            ->set('message', 'test')
            ->call('submitForm')
            ->assertHasErrors(['message' => 'min']);;
    }

    /** @test */
    public function contact_form_detects_bot_honeypot() {
        Livewire::test(ContactForm::class)
            ->set('name', 'Joe McCorison')
            ->set('email', 'joemccorison@gmail.com')
            ->set('phone', '2185254224')
            ->set('message', 'This is a test')
            ->call('submitForm')
            ->assertSee(__('messages.contact.error_message'));
    }
}
