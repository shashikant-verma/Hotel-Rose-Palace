<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Hotel Rose Palace</title>
</head>
<body style="margin: 0; padding: 0; background-color: #EDE4D8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2E1F22; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #EDE4D8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08); border: 1px solid #D8CBB8;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6E2C3A 0%, #4B0600 100%); padding: 36px 32px; text-align: center; color: #FFFFFF;">
                            <span style="display: block; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #E8D3A7; margin-bottom: 8px; font-weight: 700;">✦ Official Reservation Confirmation ✦</span>
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
                                        <span style="display: inline-block; background-color: #2E7D32; color: #FFFFFF; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px; border-radius: 4px;">
                                            &check; Confirmed &amp; Paid
                                        </span>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 13px; font-weight: 700; color: #6E2C3A;">Ref: {{ $booking->booking_reference }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.6; color: #2E1F22;">
                                Dear <strong>{{ $booking->customer_name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #5E4B4E;">
                                We are delighted to confirm your upcoming reservation at Hotel Rose Palace. Your payment has been successfully verified and your room is reserved.
                            </p>

                            <!-- Reservation Summary Grid -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6F0; border-radius: 8px; border: 1px solid #E2D5C3; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; width: 140px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Check-in:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; font-weight: 700; color: #2E1F22;">
                                        {{ $booking->check_in_date ? $booking->check_in_date->format('l, d M Y') : 'N/A' }} <span style="font-size: 12px; font-weight: normal; color: #8C787B;">(from 2:00 PM)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Check-out:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; font-weight: 700; color: #2E1F22;">
                                        {{ $booking->check_out_date ? $booking->check_out_date->format('l, d M Y') : 'N/A' }} <span style="font-size: 12px; font-weight: normal; color: #8C787B;">(until 11:00 AM)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Duration:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; color: #2E1F22;">
                                        {{ $booking->nights ?? 1 }} Night(s)
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Room Category:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; font-weight: 700; color: #6E2C3A;">
                                        {{ $booking->roomType?->name ?? 'Standard Room' }} ({{ $booking->room_quantity }} Room{{ $booking->room_quantity > 1 ? 's' : '' }})
                                    </td>
                                </tr>
                                @php
                                    $allocatedRooms = $booking->roomAllocations->pluck('room.room_number')->filter()->join(', ');
                                @endphp
                                @if(!empty($allocatedRooms))
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Assigned Room(s):</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; font-weight: 700; color: #2E1F22;">
                                        Room {{ $allocatedRooms }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 13px; color: #5E4B4E; font-weight: 600;">Guests:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #E2D5C3; font-size: 14px; color: #2E1F22;">
                                        {{ $booking->num_adults }} Adult(s)@if($booking->num_children > 0), {{ $booking->num_children }} Child(ren)@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #5E4B4E; font-weight: 600;">Total Paid:</td>
                                    <td style="padding: 12px 16px; font-size: 16px; font-weight: 700; color: #2E7D32;">
                                        &#8377;{{ number_format($booking->total_amount, 2) }} <span style="font-size: 11px; font-weight: normal; color: #5E4B4E;">(incl. GST)</span>
                                    </td>
                                </tr>
                            </table>

                            @if($booking->special_requests)
                            <div style="background-color: #FAF6F0; border-left: 3px solid #6E2C3A; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 13px; color: #5E4B4E;">
                                <strong>Special Requests noted:</strong><br>
                                {{ $booking->special_requests }}
                            </div>
                            @endif

                            <!-- Check-in Guidance -->
                            <div style="background-color: #F7F1E8; border-radius: 8px; border: 1px solid #D8CBB8; padding: 18px 20px; margin-bottom: 24px;">
                                <h4 style="margin: 0 0 10px; font-size: 14px; color: #6E2C3A; text-transform: uppercase; letter-spacing: 0.5px;">Important Check-In Information</h4>
                                <ul style="margin: 0; padding-left: 18px; font-size: 13px; color: #5E4B4E; line-height: 1.6;">
                                    <li>Please present valid government-issued photo ID (Aadhaar, Passport, Voter ID, Driving License) for all adult guests upon arrival.</li>
                                    <li>Standard check-in starts at 2:00 PM. Early check-in is subject to room availability upon arrival.</li>
                                    <li>Our reception desk is staffed 24/7 for late arrivals.</li>
                                    <li>Complimentary high-speed Wi-Fi and valet parking are available throughout your stay.</li>
                                </ul>
                            </div>

                            <!-- CTA Buttons -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 10px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/my-bookings/' . $booking->id) }}" style="display: inline-block; background: #6E2C3A; color: #FFFFFF; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; font-weight: 600; letter-spacing: 0.5px;">
                                            View Reservation Details &rarr;
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
