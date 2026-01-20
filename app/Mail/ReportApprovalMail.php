<?php

namespace App\Mail;

use App\Models\AssessmentReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $role;

    public function __construct(AssessmentReport $report, string $role)
    {
        $this->report = $report;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject('Assessment Report For Membership NGOForum')
            ->view('emails.report-approval');
    }
}
