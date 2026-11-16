<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Notice - Hotel Rose Palace</title>
</head>
<body style="margin: 0; padding: 0; background-color: #EDE4D8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2E1F22; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #EDE4D8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08); border: 1px solid #D8CBB8;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6E2C3A 0%, #4B0600 100%); padding: 36px 32px; text-align: center; color: #FFFFFF;">
                            <span style="display: block; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #E8D3A7; margin-bottom: 8px; font-weight: 700;">✦ Payment &amp; Accounts Update ✦</span>
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
                                        @if($refundStatus === 'processed')
                                            <span style="display: inline-block; background-color: #2E7D32; color: #FFFFFF; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 4px;">
                                                &check; Refund Processed
                                            </span>
                                        @elseif(in_array($refundStatus, ['pending', 'initiated']))
                                            <span style="display: inline-block; background-color: #EF6C00; color: #FFFFFF; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 4px;">
                                                &bull; Refund Initiated (Pending)
                                            </span>
                                        @else
                                            <span style="display: inline-block; background-color: #C62828; color: #FFFFFF; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 4px;">
                                                ! Refund Processing Update
                                            </span>
                                        @endif
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 13px; font-weight: 700; color: #6E2C3A;">Booking Ref: {{ $booking->booking_reference }}</span>
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

                            @if($refundStatus === 'processed')
                                <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #5E4B4E;">
                                    We would like to inform you that your refund has been <strong>successfully processed</strong> by our payment gateway. The funds are on their way to your original payment method.
                                </p>
                            @elseif(in_array($refundStatus, ['pending', 'initiated']))
                                <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #5E4B4E;">
                                    Your refund request has been <strong>initiated</strong> with Razorpay and is currently awaiting clearance from your bank. Please note that this refund is currently pending banking settlement.
                                </p>
                            @else
                                <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #5E4B4E;">
                                    We experienced an issue while attempting to automatically process your refund via our online payment gateway. Our finance and reception desk has been notified and will review your transaction manually.
                                </p>
                            @endif

                            <!-- Refund Details -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6F0; border-radius: 8px; border: 1px solid #E2D5C3; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; width: 150px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Booking Reference:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-weight: 700; color: #6E2C3A;">
                                        {{ $booking->booking_reference }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Original Payment ID:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-family: monospace; color: #2E1F22;">
                                        {{ $payment->razorpay_payment_id ?? ('PAY-' . $payment->id) }}
                                    </td>
                                </tr>
                                @if($refundId)
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Refund ID:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-family: monospace; font-weight: 700; color: #6E2C3A;">
                                        {{ $refundId }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Refund Amount:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 16px; font-weight: 700; color: #2E7D32;">
                                        &#8377;{{ number_format($refundAmount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Current Status:</td>
                                    <td style="padding: 10px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; font-weight: 700; color: #2E1F22;">
                                        @if($refundStatus === 'processed')
                                            <span style="color: #2E7D32;">Successfully Processed</span>
                                        @elseif(in_array($refundStatus, ['pending', 'initiated']))
                                            <span style="color: #EF6C00;">Initiated (Pending Bank Settlement)</span>
                                        @else
                                            <span style="color: #C62828;">Gateway Pending / Manual Review</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Timestamp:</td>
                                    <td style="padding: 10px 16px; font-size: 13px; color: #2E1F22;">
                                        {{ $payment->refunded_at ? $payment->refunded_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            </table>

                            @if(in_array($refundStatus, ['processed', 'pending', 'initiated']))
                            <!-- Processing Timeframe Information -->
                            <div style="background-color: #F7F1E8; border-radius: 8px; border: 1px solid #D8CBB8; padding: 18px 20px; margin-bottom: 24px;">
                                <h4 style="margin: 0 0 10px; font-size: 13px; color: #6E2C3A; text-transform: uppercase; letter-spacing: 0.5px;">Bank Settlement Timeframe</h4>
                                <p style="margin: 0; font-size: 13px; color: #5E4B4E; line-height: 1.6;">
                                    Online refunds are credited directly back to the original source (bank account, credit/debit card, or UPI wallet). Depending on your banking institution or card network, please allow <strong>5 to 7 business days</strong> for the credit to appear on your account statement.
                                </p>
                            </div>
                            @endif

                            <p style="margin: 0; font-size: 12px; line-height: 1.6; color: #8C787B; text-align: center;">
                                If you have any questions regarding your refund or need further assistance, please contact our concierge desk directly with your booking reference.
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
