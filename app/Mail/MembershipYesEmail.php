<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipYesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $membership;
    public $deadline;
    public $admins;

    public function __construct($membership, $deadline, $admins = [])
    {
        $this->membership = $membership;
        $this->deadline = $deadline;
        $this->admins = $admins;
    }

    public function build()
    {
        return $this->subject('Membership Confirmation (Phase 1) and Next Steps')
                    ->view('emails.membership_yes')
                    ->with([
                        'nextFormUrl' => route('membership.formUpload', $this->membership->id),
                    ]);
    }
}