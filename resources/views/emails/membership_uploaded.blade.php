<p>Dear Admin,</p>

<p>
We would like to inform you that a new NGO membership application has been
<strong>successfully submitted</strong> and is now ready for assessment.
</p>

<p>
<strong>Organization Name:</strong> {{ $membership->org_name_en }}<br>
<strong>Membership Type:</strong> {{ $membership->membership_type }}
</p>

<p>
Please log in to the NGO Membership System to review the application details
and proceed with generating the assessment report.
</p>

<p style="margin: 20px 0;">
    <a href="{{ route('admin.newMembership') }}"
       style="display:inline-block;
              padding:10px 16px;
              background-color:#2563eb;
              color:#ffffff;
              text-decoration:none;
              border-radius:4px;
              font-weight:600;">
        👉 Review & Generate Assessment Report
    </a>
</p>

<p>
If you require any additional information, please contact the system administrator.
</p>

<p>
Thank you for your cooperation.<br>
<strong>NGO Forum Membership System</strong>
</p>
