<?php

namespace App\Jobs;


use App\Mail\AdminNotification;
use App\Mail\ContactUsForm;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactUsForm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->contact['email'] ?? null;
        $name = $this->contact['name'] ?? null;

        // send mail to user
        if ($email && $name) {
            $user = new User([
                'name' => $name,
                'email' => $email
            ]);
            Mail::to($user->email)->send(new ContactUsForm($user));
        }

        // send notification to admin
        $admin = new User(['email' => config('app.admin.email'), 'name' => config('app.admin.name') ]);
        Mail::to($admin->email)->send(new AdminNotification(
            AdminNotification::NOTIFICATION_CONTACT_RECIEVED, $admin)
        );
    }
}
