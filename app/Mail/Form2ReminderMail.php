<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Form2ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $membership;

    public function __construct($membership)
    {
        $this->membership = $membership;
    }

    public function build()
    {
        return $this->subject('Reminder: Please Complete Your Membership Form (Phase 2)')
                    ->markdown('emails.form2_reminder')
                    ->with([
                        'user' => $this->membership->user,
                        'formLink' => route('membership.formUpload.id', $this->membership->id),
                    ]);
    }
}