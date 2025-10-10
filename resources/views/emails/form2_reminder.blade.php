<p style="color:#000;font-family:Arial, sans-serif;">Dear {{ $user->name ?? 'Member' }},</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    We hope this message finds you well.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Our records indicate that you have <strong>not yet completed Form (Phase 2)</strong> of your membership application.<br>
    Please complete it <strong>as soon as possible</strong> to avoid delays in processing your membership.
</p>

<p>
    <a href="{{ $formLink ?? '#' }}" target="_blank" 
       style="display:inline-block;padding:10px 20px;background-color:#3490dc;color:#ffffff;text-decoration:none;border-radius:5px;"
       aria-label="Complete Phase 2 Form">
       Complete Form (Phase 2)
    </a>
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Thank you for your attention to this matter.
</p>

<p style="color:#000;font-family:Arial, sans-serif;">
    Best regards,<br>
    NGOF Team<br>
    Led by CHAN Vicheth<br>
    Program Manager<br>
    NGO Forum on Cambodia
</p>
