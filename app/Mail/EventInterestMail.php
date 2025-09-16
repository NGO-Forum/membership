<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventInterestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $name;
    public $email;
    public $messageContent;

    public function __construct($event, $name, $email, $messageContent)
    {
        $this->event = $event;
        $this->name = $name;
        $this->email = $email;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('Event Interest: ' . $this->event->title)
                    ->view('emails.event_interest');
    }
}
