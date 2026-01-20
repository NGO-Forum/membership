<div style="max-width:640px; margin:40px auto; padding:0 20px;">

    <p style="font-size:15px; line-height:1.7;">
        Dear <strong>{{ ucfirst($role) }}</strong>,
    </p>

    <p style="font-size:15px; line-height:1.7;">
        This is to inform you that an assessment report for a new membership
        application has reached your level and is now pending your review and approval.
    </p>

    <p style="font-size:15px; line-height:1.7;">
        Please log in to the system to review the report, make any necessary edits,
        print it if required, and proceed with the subsequent steps in the approval workflow.
    </p>

    <p style="font-size:15px; font-weight:bold; margin-top:24px;">
        Action Required:
    </p>

    <ol style="font-size:15px; line-height:1.7; padding-left:20px;">
        <li>Review, edit, approve, and print a hard copy of the assessment report.</li>
        <li>Submit the approved report to the Executive Director for review and comments.</li>
        <li>Forward the reviewed document to the Board of Directors for their review and approval.</li>
        <li>Submit the final approved document to Mr. <strong>SOM Chettana</strong> for stamping as the final
            endorsement.</li>
        <li>Scan the stamped version and cc it to Vicheth, the Executive Director, Mr. Chettana, and the NGO Membership
            System.</li>
        <li>
            Once all approvals are completed, send an email to the applicant informing them
            of the result, whether positive or negative.
        </li>
    </ol>

    <p style="font-size:15px; line-height:1.7; margin-top:20px;">
        You may access the assessment report at the link below:
    </p>

    <p style="margin:20px 0;">
        <a href="{{ route('reports.index', ['membership' => $report->new_membership_id]) }}"
            style="color:#2563eb; font-weight:600; text-decoration:none;">
            → Review Assessment Report
        </a>
    </p>

    <p style="font-size:15px; line-height:1.7;">
        Should you require any clarification or additional information,
        please contact the system administrator.
    </p>

    <p style="font-size:15px; line-height:1.7; margin-top:30px;">
        Sincerely,<br>
        <strong>NGO Membership System</strong>
    </p>

</div>
