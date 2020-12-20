<?php

namespace App\Http\Livewire;

use App\Jobs\SendContactUsForm;
use App\Models\Inquiry;
use Livewire\Component;

class ContactForm extends Component
{
    const THANKYOU_MESSAGE = "Thank you for getting in touch, we will get back to you as soon as we can.";
    const SPAM_MESSAGE = "Woops! Something went wrong.";

    /** @var @todo move this to a model */
    public $name;
    public $email;
    public $phone;
    public $message;
    public $score_id;
    public $load_time;

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

    /**
     * Set default values
     */
    public function mount() {
        $this->load_time = microtime(true);
    }

    /**
     * Handles form action
     */
    public function submitForm() {
        $contact = $this->validate();

        if ($this->isSpam()) {
            session()->flash('error_message', self::SPAM_MESSAGE);
            return;
        }

        // filter values
        $contact = $this->filter($contact);

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

    /**
     * Catches emitted event from score
     * @param $scoreId
     */
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

    /**
     * @param array $contact
     * @return array|string[]
     */
    private function filter(array $contact): array
    {
        $contact = array_map(function ($value) {
            return strip_tags($value);
        }, $contact);
        return $contact;
    }

    /**
     * @return bool
     */
    private function isSpam(): bool {

        $elapsed = microtime(true) -  $this->load_time;
        if ($elapsed < 3) {
            return true;
        }

        return false;
    }

}
