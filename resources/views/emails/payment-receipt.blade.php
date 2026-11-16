<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - Hotel Rose Palace</title>
</head>
<body style="margin: 0; padding: 0; background-color: #EDE4D8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2E1F22; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #EDE4D8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08); border: 1px solid #D8CBB8;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6E2C3A 0%, #4B0600 100%); padding: 36px 32px; text-align: center; color: #FFFFFF;">
                            <span style="display: block; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #E8D3A7; margin-bottom: 8px; font-weight: 700;">✦ Official Payment Receipt &amp; Tax Invoice ✦</span>
                            <h1 style="margin: 0; font-size: 26px; font-family: Georgia, serif; font-weight: normal; letter-spacing: 0.5px; color: #FAF6F0;">Hotel Rose Palace</h1>
                            <p style="margin: 8px 0 0; font-size: 13px; color: rgba(250, 246, 240, 0.85);">Surat, Gujarat &bull; VIP Road, Vesu</p>
                        </td>
                    </tr>

                    <!-- Receipt Banner -->
                    <tr>
                        <td style="background-color: #F7F1E8; padding: 16px 32px; border-bottom: 1px solid #D8CBB8;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <span style="display: inline-block; background-color: #2E7D32; color: #FFFFFF; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 4px;">
                                            &check; Payment Successful
                                        </span>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 12px; color: #5E4B4E;">{{ $payment->captured_at ? $payment->captured_at->format('d M Y, h:i A') : $payment->created_at->format('d M Y, h:i A') }}</span>
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
                                Thank you for your payment. Please find your itemized transaction receipt for booking <strong>#{{ $booking->booking_reference }}</strong> below:
                            </p>

                            <!-- Transaction Identifiers -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6F0; border-radius: 8px; border: 1px solid #E2D5C3; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; width: 140px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Payment ID:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-family: monospace; font-weight: 700; color: #6E2C3A;">
                                        {{ $payment->razorpay_payment_id ?? ('PAY-' . $payment->id) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Order ID:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-family: monospace; color: #2E1F22;">
                                        {{ $payment->razorpay_order_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Payment Method:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #2E1F22;">
                                        {{ strtoupper($payment->method ?? 'Online') }}
                                        @if($payment->card_network) ({{ $payment->card_network }} @if($payment->card_last4)•••• {{ $payment->card_last4 }}@endif)@endif
                                        @if($payment->vpa) ({{ $payment->vpa }})@endif
                                        @if($payment->bank) ({{ $payment->bank }})@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Payment Status:</td>
                                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 700; color: #2E7D32;">
                                        Captured &amp; Verified
                                    </td>
                                </tr>
                            </table>

                            <!-- Itemized Invoice Breakdown -->
                            <h4 style="margin: 0 0 12px; font-size: 14px; color: #6E2C3A; text-transform: uppercase; letter-spacing: 0.5px;">Itemized Invoice Breakdown</h4>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FFFFFF; border-radius: 8px; border: 1px solid #D8CBB8; margin-bottom: 24px;">
                                <thead>
                                    <tr style="background-color: #F7F1E8; border-bottom: 1px solid #D8CBB8;">
                                        <th style="padding: 10px 16px; text-align: left; font-size: 12px; font-weight: 700; color: #6E2C3A; text-transform: uppercase;">Description</th>
                                        <th style="padding: 10px 16px; text-align: right; font-size: 12px; font-weight: 700; color: #6E2C3A; text-transform: uppercase;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #2E1F22;">
                                            <strong>{{ $booking->roomType?->name ?? 'Room Stay' }}</strong><br>
                                            <span style="font-size: 12px; color: #5E4B4E;">
                                                {{ $booking->room_quantity }} Room(s) &times; {{ $booking->nights ?? 1 }} Night(s)<br>
                                                ({{ $booking->check_in_date ? $booking->check_in_date->format('d M Y') : '' }} to {{ $booking->check_out_date ? $booking->check_out_date->format('d M Y') : '' }})
                                            </span>
                                        </td>
                                        <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; text-align: right; font-size: 14px; color: #2E1F22;">
                                            &#8377;{{ number_format($booking->base_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E;">
                                            Goods &amp; Services Tax (GST 12%)
                                        </td>
                                        <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; text-align: right; font-size: 13px; color: #2E1F22;">
                                            &#8377;{{ number_format($booking->tax_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr style="background-color: #FAF6F0;">
                                        <td style="padding: 14px 16px; font-size: 14px; font-weight: 700; color: #6E2C3A;">
                                            Total Amount Paid (INR)
                                        </td>
                                        <td style="padding: 14px 16px; text-align: right; font-size: 18px; font-weight: 700; color: #2E7D32;">
                                            &#8377;{{ number_format($payment->amount, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <p style="margin: 0; font-size: 12px; line-height: 1.6; color: #8C787B; text-align: center;">
                                This electronic receipt is a valid proof of payment for your reservation at Hotel Rose Palace.<br>
                                You can access your full booking history and confirmation receipts from your customer portal anytime.
                            </p>
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
