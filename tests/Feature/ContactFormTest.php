<?php

namespace Tests\Feature;

use App\Http\Livewire\ContactForm;
use App\Mail\ContactUsForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
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
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'Joe McCorison')
            ->set('email', 'joemccorison@gmail.com')
            ->set('phone', '2185254224')
            ->set('message', 'This is a test')
            ->call('submitForm')
            ->assertSee('We have received your message and we will get back to you very soon.');

        Mail::assertSent(function(ContactUsForm $mail) {
            $mail->build();

            return $mail->hasTo('joemccorison@gmail.com') &&
                $mail->hasFrom('joemccorison@gmail.com') &&
                $mail->subject === 'Thank you for your interest';
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
}
