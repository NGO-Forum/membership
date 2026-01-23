<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }}</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:600px; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#16a34a; padding:20px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:22px;">
                                New Event Created
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:24px; color:#374151; font-size:14px; line-height:1.6;">

                            <h2 style="margin-top:0; color:#111827;">
                                Topic Name: {{ $event->title }}
                            </h2>

                            <p>
                                Dear <strong>{{ $event->organizer ?? 'Organizer' }}</strong>,
                            </p>

                            <p>
                                A new event has been successfully created in the NGOForum system.
                                Below are the event details:
                            </p>

                            <!-- Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:16px 0;">
                                <tr>
                                    <td style="padding:6px 0;"><strong>📅 Date:</strong></td>
                                    <td style="padding:6px 0;">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('l, d M Y') }}
                                        →
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('l, d M Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;"><strong>⏰ Time:</strong></td>
                                    <td style="padding:6px 0;">
                                        {{ $event->start_time }} – {{ $event->end_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;"><strong>📍 Location:</strong></td>
                                    <td style="padding:6px 0;">
                                        {{ $event->location ?? 'N/A' }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Button -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ $event->registration_link }}"
                                    style="
                                   display:inline-block;
                                   background:#16a34a;
                                   color:#ffffff;
                                   text-decoration:none;
                                   padding:12px 24px;
                                   border-radius:6px;
                                   font-weight:bold;
                                   font-size:14px;
                               ">
                                    🔗 View & Register
                                </a>
                            </div>

                            <p style="font-size:14px; color:#6b7280;">
                                If the button does not work, copy and paste this link into your browser:
                                <br>
                                <a href="{{ $event->registration_link }}" style="color:#2563eb;">
                                    {{ $event->registration_link }}
                                </a>
                            </p>

                            <hr style="border:none; border-top:1px solid #e5e7eb; margin:24px 0;">

                            <p>
                                Best regards,<br>
                                <strong>NGOForum System</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb; padding:14px; text-align:center; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} NGOForum. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
