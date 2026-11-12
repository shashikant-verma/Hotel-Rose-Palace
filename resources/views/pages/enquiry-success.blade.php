@extends('layouts.app')

@section('title', 'Enquiry Submitted - Hotel Rose Palace')

@section('content')

<!-- Success Section -->
<section style="padding: 80px 0; background: linear-gradient(135deg, #1a2332 0%, #2a3a52 100%); color: white; text-align: center; min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Success Icon -->
                <div style="font-size: 80px; margin-bottom: 24px; color: #c9a961;">
                    <i class="fas fa-check-circle"></i>
                </div>

                <!-- Success Message -->
                <h1 style="font-size: 48px; margin-bottom: 16px; font-weight: 700;">Enquiry Submitted!</h1>
                <p style="font-size: 20px; margin-bottom: 32px; color: #e8e8e8;">Your enquiry has been received successfully</p>

                <!-- Reference ID -->
                <div style="background-color: rgba(255,255,255,0.1); padding: 24px; border-radius: 8px; margin-bottom: 32px; border-left: 4px solid #c9a961;">
                    <p style="font-size: 14px; color: #bbb; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Your Enquiry Reference</p>
                    <p style="font-size: 32px; font-weight: 700; color: #c9a961; font-family: 'Courier New', monospace; margin: 0;">{{ $enquiry->reference_id }}</p>
                </div>

                <!-- Enquiry Details -->
                <div style="background-color: rgba(255,255,255,0.05); padding: 24px; border-radius: 8px; margin-bottom: 32px; text-align: left;">
                    <h4 style="color: #c9a961; margin-bottom: 16px; text-align: center;">Enquiry Details</h4>
                    
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 16px;">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Room Type</p>
                            <p style="font-size: 16px; color: white; margin: 0;">{{ $enquiry->roomType->name }}</p>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 16px;">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Guest Name</p>
                            <p style="font-size: 16px; color: white; margin: 0;">{{ $enquiry->customer_name }}</p>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 16px;">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Check-in Date</p>
                            <p style="font-size: 16px; color: white; margin: 0;">{{ $enquiry->check_in_date->format('d M, Y') }}</p>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 16px;">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Check-out Date</p>
                            <p style="font-size: 16px; color: white; margin: 0;">{{ $enquiry->check_out_date->format('d M, Y') }}</p>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 16px;">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Guests</p>
                            <p style="font-size: 16px; color: white; margin: 0;">{{ $enquiry->num_adults }} {{ $enquiry->num_adults > 1 ? 'Adults' : 'Adult' }}{{ $enquiry->num_children > 0 ? ', ' . $enquiry->num_children . ' ' . ($enquiry->num_children > 1 ? 'Children' : 'Child') : '' }}</p>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 16px;">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Contact Number</p>
                            <p style="font-size: 16px; color: white; margin: 0;">{{ $enquiry->customer_phone }}</p>
                        </div>
                    </div>

                    @if($enquiry->special_requests)
                        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
                            <p style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 4px;">Special Requests</p>
                            <p style="font-size: 14px; color: #e8e8e8; margin: 0; line-height: 1.6;">{{ $enquiry->special_requests }}</p>
                        </div>
                    @endif
                </div>

                <!-- What's Next Section -->
                <div style="background-color: rgba(201, 169, 97, 0.1); padding: 24px; border-radius: 8px; margin-bottom: 32px; border-left: 4px solid #c9a961;">
                    <h5 style="color: #c9a961; margin-bottom: 12px;">What Happens Next?</h5>
                    <p style="color: #e8e8e8; margin: 0; font-size: 14px; line-height: 1.8;">
                        Our team will review your enquiry and contact you shortly via WhatsApp at <strong>{{ $whatsappNumber }}</strong> to confirm availability and discuss your booking. Please keep your reference ID handy for your records.
                    </p>
                </div>

                <!-- WhatsApp CTA Button -->
                <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success btn-lg" style="background-color: #25d366; border-color: #25d366; padding: 16px 40px; font-size: 16px; margin-bottom: 16px; display: inline-block;">
                    <i class="fab fa-whatsapp" style="margin-right: 8px;"></i>
                    Continue on WhatsApp
                </a>

                <!-- Back Button -->
                <div>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg" style="padding: 16px 40px; font-size: 16px;">
                        <i class="fas fa-home" style="margin-right: 8px;"></i>
                        Back to Home
                    </a>
                </div>

                <!-- Disclaimer -->
                <p style="color: #999; font-size: 12px; margin-top: 48px;">
                    <i class="fas fa-lock" style="margin-right: 4px;"></i>
                    Your information is secure and will be used only for your booking enquiry.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
