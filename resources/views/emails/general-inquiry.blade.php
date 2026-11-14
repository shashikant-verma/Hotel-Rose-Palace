<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Guest Inquiry - Hotel Rose Palace</title>
</head>
<body style="margin: 0; padding: 0; background-color: #EDE4D8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2E1F22; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #EDE4D8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08); border: 1px solid #D8CBB8;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6E2C3A 0%, #4B0600 100%); padding: 36px 32px; text-align: center; color: #FFFFFF;">
                            <span style="display: block; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #E8D3A7; margin-bottom: 8px; font-weight: 700;">✦ Concierge &amp; Reservations Desk ✦</span>
                            <h1 style="margin: 0; font-size: 26px; font-family: Georgia, serif; font-weight: normal; letter-spacing: 0.5px; color: #FAF6F0;">Hotel Rose Palace</h1>
                            <p style="margin: 8px 0 0; font-size: 13px; color: rgba(250, 246, 240, 0.85);">Surat, Gujarat &bull; VIP Road, Vesu</p>
                        </td>
                    </tr>

                    <!-- Notification Banner -->
                    <tr>
                        <td style="background-color: #F7F1E8; padding: 16px 32px; border-bottom: 1px solid #D8CBB8;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <span style="font-size: 13px; font-weight: 700; color: #6E2C3A; text-transform: uppercase; letter-spacing: 1px;">New Website Inquiry</span>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 12px; color: #5E4B4E;">{{ $inquiry->created_at ? $inquiry->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Inquiry Details Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 20px; font-size: 15px; line-height: 1.6; color: #2E1F22;">
                                A new inquiry has been submitted through the Hotel Rose Palace website contact form. Details are summarized below:
                            </p>

                            <!-- Data Grid -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6F0; border-radius: 8px; border: 1px solid #E2D5C3; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; width: 140px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Guest Name:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; font-weight: 700; color: #2E1F22;">{{ $inquiry->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Email Address:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; color: #2E1F22;">
                                        <a href="mailto:{{ $inquiry->email }}" style="color: #6E2C3A; text-decoration: underline;">{{ $inquiry->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Phone / WhatsApp:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; color: #2E1F22;">
                                        @if($inquiry->phone)
                                            <a href="tel:{{ $inquiry->phone }}" style="color: #6E2C3A; text-decoration: none; font-weight: 600;">{{ $inquiry->phone }}</a>
                                        @else
                                            <span style="color: #8C787B; font-style: italic;">Not provided</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Subject:</td>
                                    <td style="padding: 12px 16px; font-size: 14px; color: #6E2C3A; font-weight: 700;">
                                        {{ $inquiry->subject ?: 'General Question' }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Message Box -->
                            <div style="margin-bottom: 24px;">
                                <span style="display: block; font-size: 13px; font-weight: 700; color: #5E4B4E; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Message / Special Requirements:</span>
                                <div style="background-color: #FFFFFF; border: 1.5px solid #D8CBB8; border-left: 4px solid #6E2C3A; border-radius: 6px; padding: 16px 20px; font-size: 14px; line-height: 1.7; color: #2E1F22; white-space: pre-line;">
{{ $inquiry->message }}
                                </div>
                            </div>

                            <!-- Action CTA -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/admin/contact-messages') }}" style="display: inline-block; background: #6E2C3A; color: #FFFFFF; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; font-weight: 600; letter-spacing: 0.5px;">
                                            Open in Admin Panel &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F7F1E8; padding: 20px 32px; text-align: center; border-top: 1px solid #D8CBB8; font-size: 12px; color: #5E4B4E; line-height: 1.5;">
                            This is an automated notification from <strong>Hotel Rose Palace Concierge System</strong>.<br>
                            To respond to the guest directly, reply to this email or contact them via their phone number.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
