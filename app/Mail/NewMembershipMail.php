<?php

namespace App\Mail;

use App\Models\NewMembership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMembershipMail extends Mailable
{
    use Queueable, SerializesModels;

    public NewMembership $membership;
    public bool $isExistingNgo;

    public function __construct(NewMembership $membership, bool $isExistingNgo = false)
    {
        $this->membership = $membership;
        $this->isExistingNgo = $isExistingNgo;
    }

    public function build()
    {
        return $this
            ->subject($this->isExistingNgo ? 'Membership Reconfirmation' : 'New Membership Submission Form')
            ->view('emails.membership')
            ->with([
                'membership' => $this->membership,
                'isExistingNgo' => $this->isExistingNgo,
            ]);
    }
}