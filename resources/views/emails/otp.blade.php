<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code - Hotel Rose Palace</title>
</head>
<body style="margin: 0; padding: 0; background-color: #EDE4D8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2E1F22; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #EDE4D8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 520px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08); border: 1px solid #D8CBB8;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6E2C3A 0%, #4B0600 100%); padding: 32px 28px; text-align: center; color: #FFFFFF;">
                            <h1 style="margin: 0; font-size: 24px; font-family: Georgia, serif; font-weight: normal; letter-spacing: 0.5px; color: #FAF6F0;">Hotel Rose Palace</h1>
                            <p style="margin: 8px 0 0; font-size: 12px; color: rgba(250, 246, 240, 0.85);">Surat, Gujarat &bull; VIP Road, Vesu</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px 28px;">
                            <p style="margin: 0 0 8px; font-size: 15px; line-height: 1.6; color: #2E1F22;">
                                Dear Guest,
                            </p>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #2E1F22;">
                                @if($purpose === 'manage_bookings')
                                    Use the following code to access and manage your bookings:
                                @else
                                    Use the following code to verify your email and proceed with your booking:
                                @endif
                            </p>

                            <!-- OTP Code Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #FAF6F0; border: 2px solid #6E2C3A; border-radius: 10px; padding: 20px 32px; display: inline-block;">
                                            <span style="font-size: 36px; font-weight: 700; letter-spacing: 10px; color: #6E2C3A; font-family: 'Courier New', monospace;">{{ $otp }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 8px; font-size: 13px; line-height: 1.6; color: #5E4B4E; text-align: center;">
                                This code is valid for <strong style="color: #6E2C3A;">{{ $expiryMinutes }} minutes</strong>.
                            </p>
                            <p style="margin: 0 0 24px; font-size: 13px; line-height: 1.6; color: #5E4B4E; text-align: center;">
                                If you did not request this code, please ignore this email.
                            </p>

                            <hr style="border: none; border-top: 1px solid #E2D5C3; margin: 24px 0;">

                            <p style="margin: 0; font-size: 12px; line-height: 1.6; color: #8C787B; text-align: center;">
                                For your security, never share this code with anyone.<br>
                                Hotel Rose Palace staff will never ask you for this code.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F7F1E8; padding: 18px 28px; text-align: center; border-top: 1px solid #D8CBB8; font-size: 11px; color: #5E4B4E; line-height: 1.5;">
                            &copy; {{ date('Y') }} Hotel Rose Palace, Surat. All rights reserved.<br>
                            This is an automated email. Please do not reply directly.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
