@extends('layouts.app')

@section('title', 'Cancellation Policy - Hotel Rose Palace')

@section('content')

<section style="padding: 60px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 style="color: #1a2332; margin-bottom: 32px;">Cancellation Policy</h1>

                <p style="color: #666; margin-bottom: 20px;">
                    Last updated: November 12, 2026
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">1. Cancellation Terms</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    Hotel Rose Palace offers flexible cancellation policies. The specific cancellation terms will depend on your booking rate and room type. Please review your booking confirmation for the applicable cancellation policy.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">2. Refund Policy</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    Refunds will be processed according to the cancellation policy applicable to your booking. Processing time for refunds may take 5-10 business days after cancellation.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">3. Modification of Bookings</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    You may modify your booking by contacting our reservations team. Modifications are subject to availability and applicable rate changes. Contact us via WhatsApp or email to request changes to your booking.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">4. How to Cancel</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    To cancel your booking, please contact us through one of the following channels:
                </p>
                <ul style="color: #666; margin-bottom: 20px; padding-left: 20px;">
                    <li><strong>WhatsApp:</strong> <a href="https://wa.me/{{ str_replace([' ', '+'], '', config('hotel.contact.whatsapp_number')) }}" target="_blank" style="color: #c9a961; text-decoration: none;">Contact us</a></li>
                    <li><strong>Email:</strong> <a href="mailto:{{ config('hotel.contact.email') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.email') }}</a></li>
                    <li><strong>Phone:</strong> <a href="tel:{{ config('hotel.contact.phone_1') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.phone_1') }}</a></li>
                </ul>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">5. No-Show Policy</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    If you do not arrive for your reserved dates and have not cancelled in advance, the room charge may be forfeited according to the cancellation policy.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">6. Special Circumstances</h4>
                <p style="color: #666; line-height: 1.8;">
                    Hotel Rose Palace understands that unforeseen circumstances may arise. We encourage you to contact us directly to discuss your situation. We will do our best to work with you on a case-by-case basis.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
