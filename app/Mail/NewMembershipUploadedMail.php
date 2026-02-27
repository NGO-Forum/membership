<?php

namespace App\Mail;

use App\Models\NewMembership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMembershipUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public NewMembership $membership;

    public function __construct(NewMembership $membership)
    {
        $this->membership = $membership;
    }

    public function build()
    {
        return $this
            ->subject('Membership Form Submitted')
            ->view('emails.membership_admin');
    }
}
