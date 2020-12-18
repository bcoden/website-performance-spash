<?php

namespace App\Http\Livewire;

use App\Jobs\SendContactUsForm;
use App\Models\Inquiry;
use Livewire\Component;

class ContactForm extends Component
{
    const THANKYOU_MESSAGE = "Thank you for getting in touch, we will get back to you as soon as we can.";
    /** @var @todo move this to a model */
    public $name;
    public $email;
    public $phone;
    public $message;
    public $score_id;

    protected $listeners = ['newScore'];

    /**
     * Validation Rules
     * @var string[]
     */
    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'phone' => 'required|regex:/^\(?[0-9]{3}\)?\s?[0-9]{3}[\s-]?[0-9]{4}$/',
        'message' => 'required|min:5'
    ];

    public function submitForm() {
        $contact = $this->validate();

        // check to see if we have a website

        // save to the db
        (new Inquiry([
            "fullname" => $contact['name'],
            "email" => $contact['email'],
            "phone" => $contact['phone'],
            "message" => $contact['message'],
            "score_id" => $this->score_id ?? 0
        ]))->save();

        // add mail to the queue
        SendContactUsForm::dispatch($contact);

        // clean up form
        $this->resetForm();

        // flash success message
        session()->flash('success_message', self::THANKYOU_MESSAGE);
    }

    /**
     * Realtime validation
     * @param $propertyName
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * View Render
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.contact-form');
    }

    public function newScore($scoreId): void {
        $this->score_id = $scoreId;
    }

    /**
     * Resets form values
     */
    private function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
    }


}
