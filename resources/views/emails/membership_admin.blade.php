<p style="color:#000;font-family:Arial, sans-serif;">Dear Admin,</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    A new membership has been successfully confirmed. Please find the details below:
</p>

<ul style="color:#000;font-family:Arial, sans-serif;">
    <li><strong>Organization / NGO:</strong> {{ $membership->ngo_name ?? 'N/A' }}</li>
    <li><strong>Name:</strong> {{ $membership->director_name ?? 'N/A' }}</li>
    <li><strong>Email:</strong> {{ $membership->director_email ?? 'N/A' }}</li>
</ul>

<p style="color:#000;font-family:Arial, sans-serif;">
    Please review the membership and take any necessary actions.  
    <a href="{{ route('admin.dashboard') }}" 
       style="color:#3490dc;text-decoration:none;" target="_blank">View Membership</a>
</p>

<p style="color:#000;font-family:Arial, sans-serif;">Thank you,</p>
<p style="color:#000;font-family:Arial, sans-serif;">NGOF Team</p>
