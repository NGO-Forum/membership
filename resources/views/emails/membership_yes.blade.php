<p style="color:#000;font-family:Arial, sans-serif;">Dear {{ $membership->director_name ?? 'Member' }},</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Thank you for confirming your continued membership with NGOF.  
    We’re pleased to let you know that you have successfully completed <strong>Phase 1</strong> of the confirmation process.  
    Your information will remain confidential and will be used solely for NGOF purposes.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    To help us update our records and membership database, please complete the next form by
    <strong>{{ $deadline->format('F j, Y') }}</strong> (within 15 days).
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Please continue to Phase 2 using the link below:
</p>
<p>
    <a href="{{ $nextFormUrl ?? '#' }}" target="_blank"
       style="display:inline-block;padding:10px 20px;background-color:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
       Continue to Phase 2
    </a>
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    <strong>IMPORTANT NOTE:</strong>  
    If you have any questions or need assistance, please contact us at
    @foreach ($admins as $adminEmail)
        <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>@if (!$loop->last), @endif
    @endforeach
    or via Telegram at <strong>+855 12 953 650</strong>.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    We appreciate your prompt attention to this matter and thank you for your continued collaboration.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Best regards,<br>
    NGOF Team<br>
    Led by CHAN Vicheth<br>
    Program Manager<br>
    NGO Forum on Cambodia
</p>
