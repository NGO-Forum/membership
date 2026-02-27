<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Membership Submitted</title>
</head>

<body style="margin:0;padding:0;background:#f5f7f9;font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;background:#f5f7f9;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.05);">
                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;color:#333;font-size:15px;line-height:1.7;">

                            <p>Dear Admin,</p>

                            <p>
                                A membership has been successfully submitted and is ready for review.
                                Please find the details below:
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;font-size:14px;">
                                <tr>
                                    <td style="padding:6px 0;color:#777;">Organization / NGO</td>
                                    <td style="padding:6px 0;font-weight:bold;">
                                        {{ $membership->org_name_en ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;color:#777;">Director</td>
                                    <td style="padding:6px 0;font-weight:bold;">
                                        {{ $membership->director_name ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;color:#777;">Email</td>
                                    <td style="padding:6px 0;font-weight:bold;">
                                        {{ $membership->director_email ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;color:#777;">Reference ID</td>
                                    <td style="padding:6px 0;font-weight:bold;">
                                        #{{ str_pad($membership->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                </tr>
                            </table>

                            <p>Please review the membership and generate the assessment report.</p>

                            <!-- Buttons -->
                            <p style="margin-top:20px;">

                                <a href="{{ route('admin.newShowMembership', $membership->id) }}"
                                    style="display:inline-block;padding:10px 14px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;margin-right:8px;"
                                    target="_blank">
                                    View Membership
                                </a>

                            </p>

                            <p style="margin-top:25px;">
                                Kind regards,<br>
                                <strong>The NGO Forum on Cambodia</strong>
                            </p>

                            <hr style="border:none;border-top:1px solid #eee;margin:25px 0;">

                            <p style="font-size:12px;color:#777;">
                                This is an automated notification from NGOF Membership System.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
