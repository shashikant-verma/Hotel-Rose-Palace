<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancellation Confirmation - Hotel Rose Palace</title>
</head>
<body style="margin: 0; padding: 0; background-color: #EDE4D8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2E1F22; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #EDE4D8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08); border: 1px solid #D8CBB8;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6E2C3A 0%, #4B0600 100%); padding: 36px 32px; text-align: center; color: #FFFFFF;">
                            <span style="display: block; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #E8D3A7; margin-bottom: 8px; font-weight: 700;">✦ Reservation Notice ✦</span>
                            <h1 style="margin: 0; font-size: 26px; font-family: Georgia, serif; font-weight: normal; letter-spacing: 0.5px; color: #FAF6F0;">Hotel Rose Palace</h1>
                            <p style="margin: 8px 0 0; font-size: 13px; color: rgba(250, 246, 240, 0.85);">Surat, Gujarat &bull; VIP Road, Vesu</p>
                        </td>
                    </tr>

                    <!-- Status Ribbon -->
                    <tr>
                        <td style="background-color: #F7F1E8; padding: 16px 32px; border-bottom: 1px solid #D8CBB8;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <span style="display: inline-block; background-color: #C62828; color: #FFFFFF; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 4px;">
                                            Reservation Cancelled
                                        </span>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 13px; font-weight: 700; color: #6E2C3A;">Ref: {{ $booking->booking_reference }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.6; color: #2E1F22;">
                                Dear <strong>{{ $booking->customer_name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #5E4B4E;">
                                This email confirms that your reservation at Hotel Rose Palace has been cancelled. Below is a summary of the cancelled reservation and applicable refund status:
                            </p>

                            <!-- Cancellation Summary -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6F0; border-radius: 8px; border: 1px solid #E2D5C3; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; width: 150px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Booking Reference:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-weight: 700; color: #6E2C3A;">
                                        {{ $booking->booking_reference }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Cancelled On:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #2E1F22;">
                                        {{ $booking->cancelled_at ? $booking->cancelled_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Original Dates:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #2E1F22;">
                                        {{ $booking->check_in_date ? $booking->check_in_date->format('d M Y') : '' }} to {{ $booking->check_out_date ? $booking->check_out_date->format('d M Y') : '' }} ({{ $booking->nights ?? 1 }} night{{ ($booking->nights ?? 1) > 1 ? 's' : '' }})
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Room Details:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #2E1F22;">
                                        {{ $booking->roomType?->name ?? 'Standard Room' }} ({{ $booking->room_quantity }} room{{ $booking->room_quantity > 1 ? 's' : '' }})
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Reason:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #2E1F22;">
                                        {{ $booking->cancellation_reason ?: 'Customer requested cancellation' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Refund Status:</td>
                                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 700; color: #6E2C3A;">
                                        @if(($booking->eligible_refund_percentage ?? 0) > 0)
                                            Eligible for {{ $booking->eligible_refund_percentage }}% Refund (&#8377;{{ number_format($booking->eligible_refund_amount ?? 0, 2) }})
                                        @else
                                            Non-refundable (0% refund as per policy)
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Cancellation Policy Terms -->
                            <div style="background-color: #F7F1E8; border-radius: 8px; border: 1px solid #D8CBB8; padding: 18px 20px; margin-bottom: 24px;">
                                <h4 style="margin: 0 0 10px; font-size: 13px; color: #6E2C3A; text-transform: uppercase; letter-spacing: 0.5px;">Hotel Rose Palace Cancellation Policy</h4>
                                <ul style="margin: 0; padding-left: 18px; font-size: 12px; color: #5E4B4E; line-height: 1.6;">
                                    <li><strong>48+ hours prior to check-in:</strong> 100% full refund.</li>
                                    <li><strong>24 to 48 hours prior to check-in:</strong> 50% partial refund.</li>
                                    <li><strong>Less than 24 hours prior to check-in:</strong> Non-refundable.</li>
                                    <li>Approved refunds are credited back to the original payment source within 5 to 7 business days.</li>
                                </ul>
                            </div>

                            <p style="margin: 0 0 24px; font-size: 13px; line-height: 1.6; color: #5E4B4E; text-align: center;">
                                We are sorry you won't be staying with us this time. We hope to welcome you to Hotel Rose Palace in the future.
                            </p>

                            <!-- CTA Buttons -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/') }}" style="display: inline-block; background: #6E2C3A; color: #FFFFFF; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; font-weight: 600; letter-spacing: 0.5px;">
                                            Book a Future Stay &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F7F1E8; padding: 24px 32px; text-align: center; border-top: 1px solid #D8CBB8; font-size: 12px; color: #5E4B4E; line-height: 1.6;">
                            <strong>Hotel Rose Palace</strong><br>
                            {{ config('hotel.location.address', '4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007') }}<br>
                            Phone: {{ config('hotel.contact.phone_1', '+91 88667 71900') }} &bull; WhatsApp: {{ config('hotel.contact.whatsapp_number', '+91 88667 71900') }}<br>
                            Email: <a href="mailto:{{ config('hotel.contact.email', 'Hotelrosepalacesurat@gmail.com') }}" style="color: #6E2C3A;">{{ config('hotel.contact.email', 'Hotelrosepalacesurat@gmail.com') }}</a><br>
                            <span style="font-size: 11px; color: #8C787B; margin-top: 8px; display: block;">&copy; {{ date('Y') }} Hotel Rose Palace. All rights reserved.</span>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
