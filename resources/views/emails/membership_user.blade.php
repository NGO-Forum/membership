<p style="color:#000;font-family:Arial, sans-serif;">Dear {{ $membership->director_name ?? 'Member' }},</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Thank you for completing Phase 2 of the NGOF membership confirmation process. We have successfully received your uploaded documents and information, which are now under review by our team.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Please rest assured that your submission will remain strictly confidential and will be used solely for NGOF’s internal purposes. If our Membership Committee requires any additional details, we will contact you directly.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    You will soon receive an automated email providing you with access to your membership profile.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Please click the link below to access your membership profile:
</p>
<p>
    <a href="{{ $membershipProfileUrl ?? '#' }}" target="_blank" 
       style="display:inline-block;padding:10px 20px;background-color:#3490dc;color:#ffffff;text-decoration:none;border-radius:5px;">
       Access Your Membership Profile
    </a>
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    If you have any questions or need assistance, please feel free to contact us at 
    @foreach ($admins as $adminEmail)
        <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>@if (!$loop->last), @endif
    @endforeach.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    We greatly appreciate your cooperation and look forward to our continued collaboration.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Best regards,<br>
    NGOF Team<br>
    Led by CHAN Vicheth<br>
    Program Manager<br>
    NGO Forum on Cambodia
</p>
