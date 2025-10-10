<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOverdueListMail extends Mailable
{
    use Queueable, SerializesModels;

    public $overdueMemberships;

    public function __construct($overdueMemberships)
    {
        $this->overdueMemberships = $overdueMemberships;
    }

    public function build()
    {
        return $this->subject('Overdue Membership Applications Form (Phase 2))')
                    ->markdown('emails.admin_overdue_list');
    }
}