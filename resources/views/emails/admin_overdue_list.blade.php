<p style="color:#000;font-family:Arial, sans-serif;">Dear Admin,</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    The following NGOs have <strong>not completed Form (Phase 2)</strong> of their membership application within the required 15-day period:
</p>

@foreach ($overdueMemberships as $membership)
    <p style="color:#000;font-family:Arial, sans-serif;">
        Name NGO: <strong>{{ $membership->ngo_name }}</strong>
    </p>
@endforeach

<p style="color:#000;font-family:Arial, sans-serif;">
    Please follow up with these organizations to ensure their applications are completed promptly.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">Thank you,</p>
<p style="color:#000;font-family:Arial, sans-serif;">NGOF Team</p>
