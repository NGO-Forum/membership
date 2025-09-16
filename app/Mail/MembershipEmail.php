<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MembershipEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $membership;

    public function __construct($application, $membership)
    {
        $this->application = $application;
        $this->membership = $membership;
    }

    public function build()
    {
        return $this->subject('New Membership Application Submitted')
                    ->view('emails.membership_email')
                    ->with([
                        'application' => $this->application,
                        'membership' => $this->membership,
                    ]);
    }
}