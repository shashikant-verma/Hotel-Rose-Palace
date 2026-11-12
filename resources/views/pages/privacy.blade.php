@extends('layouts.app')

@section('title', 'Privacy Policy - Hotel Rose Palace')

@section('content')

<section style="padding: 60px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 style="color: #1a2332; margin-bottom: 32px;">Privacy Policy</h1>

                <p style="color: #666; margin-bottom: 20px;">
                    Last updated: November 12, 2026
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">1. Introduction</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    Hotel Rose Palace ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">2. Information We Collect</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    We may collect information about you in a variety of ways. The information we may collect on the site includes:
                </p>
                <ul style="color: #666; margin-bottom: 20px; padding-left: 20px;">
                    <li>Name and email address</li>
                    <li>Phone number</li>
                    <li>Mailing address</li>
                    <li>Payment information</li>
                    <li>Travel preferences</li>
                </ul>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">3. Use of Your Information</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the site to:
                </p>
                <ul style="color: #666; margin-bottom: 20px; padding-left: 20px;">
                    <li>Process your bookings and reservations</li>
                    <li>Send periodic emails regarding your booking</li>
                    <li>Improve customer service</li>
                    <li>Generate analytics about site usage</li>
                </ul>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">4. Disclosure of Your Information</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    We do not sell, trade, or rent your personal identification information to others. We may share information with third parties only for the purposes outlined in this privacy policy.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">5. Security of Your Information</h4>
                <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">
                    We use administrative, technical, and physical security measures to protect your personal information.
                </p>

                <h4 style="color: #1a2332; margin-top: 32px; margin-bottom: 16px;">6. Contact Us</h4>
                <p style="color: #666; line-height: 1.8;">
                    If you have any questions about this Privacy Policy, please contact us at {{ config('hotel.contact.email') }}.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
