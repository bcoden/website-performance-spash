<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $notificationType;

    const NOTIFICATION_CONTACT_RECIEVED = 1;

    private static $_notificationTemplates = [
        self::NOTIFICATION_CONTACT_RECIEVED => 'emails.admin.contact.received'
    ];

    private static $_subjectTemplates = [
        self::NOTIFICATION_CONTACT_RECIEVED => 'New website inquiry'
    ];
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $notificationType, User $user)
    {
        $this->notificationType = $notificationType;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // get the template if exists send the notification
        $template = self::$_notificationTemplates[$this->notificationType] ?? null;
        $subject = self::$_subjectTemplates[$this->notificationType] ?? 'Admin Notification';
        if ($template) {
            return $this->from(config('mail.from'))
                ->subject(__($subject))
                ->view($template);
        }
    }
}
