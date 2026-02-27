<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Membership Submission</title>
</head>

<body style="margin:0; padding:0; background:#f5f7f9; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7f9; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:#0f766e; color:#ffffff; padding:20px 30px; font-size:20px; font-weight:bold;">
                            The NGO Forum on Cambodia
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#333; font-size:15px; line-height:1.7;">

                            <p>
                                Dear <strong>{{ $membership->director_name ?? 'Applicant' }}</strong>,
                            </p>

                            <p>
                                @if ($isExistingNgo)
                                    Thank you for reconfirming your membership with <strong>The NGO Forum on
                                        Cambodia</strong>.
                                    We have received your updated information. Our management team will review the
                                    details and contact you
                                    if any additional information is required.
                                @else
                                    Thank you for your interest in becoming a member of <strong>The NGO Forum on
                                        Cambodia</strong>.
                                    We have successfully received your submitted information. Our management team will
                                    carefully review your application
                                    and will contact you once the review process is complete.
                                @endif
                            </p>

                            <p>
                                @if ($isExistingNgo)
                                    We appreciate your continued partnership and engagement with our network. You can
                                    view and update your profile anytime using the button below.
                                @else
                                    We appreciate your interest and engagement with our network.
                                @endif
                            </p>

                            <p style="margin-top:20px;">
                                @if ($isExistingNgo)
                                    <a href="{{ route('newProfile') }}"
                                        style="display:inline-block;padding:12px 18px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;font-weight:bold;"
                                        target="_blank">
                                        View Your Profile
                                    </a>
                                @endif
                            </p>

                            <p style="margin-top:25px;">
                                Kind regards,<br>
                                <strong>The NGO Forum on Cambodia</strong>
                            </p>

                            <hr style="border:none; border-top:1px solid #eee; margin:25px 0;">

                            <p style="font-size:12px; color:#777;">
                                Reference ID: #{{ str_pad($membership->id, 4, '0', STR_PAD_LEFT) }} <br>
                                This is an automated email. Please do not reply directly to this message.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
