<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $membership;

    public function __construct($membership)
    {
        $this->membership = $membership;
    }

    public function build()
    {
        return $this->subject('New Membership Confirmed')
                    ->view('emails.membership_admin');
    }
}
