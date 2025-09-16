<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipDeclinedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('User Declined Membership')
                    ->view('emails.membership_declined')
                    ->with([
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'ngo' => $this->user->ngo ?? 'N/A',
                    ]);
    }
}
