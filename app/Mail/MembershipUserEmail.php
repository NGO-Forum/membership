<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $admins;
    public $membership;

    public function __construct($application, $admins, $membership)
    {
        $this->application = $application;
        $this->membership = $application->membership; // relationship
        $this->admins = $admins;
    }

    public function build()
    {
        return $this->subject('Confirmation of Your NGOF Membership Submission – Phase 2')
                    ->view('emails.membership_user')
                    ->with([
                        'membership' => $this->membership, // ✅ now Blade has $membership
                        'membershipProfileUrl' => route('profile'),
                        'admins' => $this->admins
                    ]);
    }

}
