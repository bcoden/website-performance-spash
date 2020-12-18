<?php

namespace App\Http\Livewire;

use App\Jobs\SendContactUsForm;
use Livewire\Component;

class ContactForm extends Component
{
    /** @var @todo move this to a model */
    public $name;
    public $email;
    public $phone;
    public $message;

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

        // add mail to the queue
        SendContactUsForm::dispatch($contact);

        // clean up form
        $this->resetForm();

        // flash success message
        session()->flash('success_message', trans('We have received your message and we will get back to you very soon.'));
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

    private function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
    }
}
