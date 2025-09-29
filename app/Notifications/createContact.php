<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class createContact extends Notification
{
    use Queueable;
    private $contact_id;
    private $email;
    private $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contact_id,$email,$subject)
    {
        $this->contact_id = $contact_id;
        $this->email = $email;
        $this->subject = $subject;

    }


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'contact_id' => $this->contact_id,
            'email' => $this->email,
            'subject' => $this->subject,
        ];
    }
}
