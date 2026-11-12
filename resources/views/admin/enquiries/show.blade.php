@extends('layouts.admin')

@section('page_title', 'Enquiry: ' . $enquiry->reference_id)

@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <h5><i class="fas fa-user"></i> Guest Information</h5>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Guest Name</p>
                    <p style="margin: 0; font-weight: 600;">{{ $enquiry->customer_name }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Phone Number</p>
                    <p style="margin: 0; font-weight: 600;">
                        <a href="https://wa.me/{{ str_replace([' ', '+'], '', $enquiry->customer_phone) }}" target="_blank" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> {{ $enquiry->customer_phone }}
                        </a>
                    </p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Email</p>
                    <p style="margin: 0;">{{ $enquiry->customer_email ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Reference ID</p>
                    <p style="margin: 0; font-weight: 700; color: var(--gold);">{{ $enquiry->reference_id }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <h5><i class="fas fa-calendar"></i> Booking Details</h5>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Room Type</p>
                    <p style="margin: 0; font-weight: 600;">{{ $enquiry->roomType->name }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Number of Nights</p>
                    <p style="margin: 0; font-weight: 600;">{{ $enquiry->check_out_date->diffInDays($enquiry->check_in_date) }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Check-in Date</p>
                    <p style="margin: 0; font-weight: 600;">{{ $enquiry->check_in_date->format('d M, Y (l)') }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Check-out Date</p>
                    <p style="margin: 0; font-weight: 600;">{{ $enquiry->check_out_date->format('d M, Y (l)') }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Adults</p>
                    <p style="margin: 0;">{{ $enquiry->num_adults }}</p>
                </div>
                <div>
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Children</p>
                    <p style="margin: 0;">{{ $enquiry->num_children }}</p>
                </div>
            </div>

            @if($enquiry->special_requests)
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                    <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Special Requests</p>
                    <p style="margin: 0;">{{ $enquiry->special_requests }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <h5><i class="fas fa-info-circle"></i> Status</h5>
            
            <div style="margin-top: 20px;">
                <p style="color: #999; font-size: 12px; margin: 0 0 10px 0;">Current Status</p>
                <span class="badge bg-primary" style="font-size: 14px; padding: 8px 12px;">
                    {{ str_replace('_', ' ', ucfirst($enquiry->status)) }}
                </span>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                <p style="color: #999; font-size: 12px; margin: 0 0 10px 0;">Timeline</p>
                <div style="font-size: 12px;">
                    <div style="margin-bottom: 10px;">
                        <p style="margin: 0; color: #999;">Created</p>
                        <p style="margin: 0;">{{ $enquiry->created_at->format('d M, Y H:i') }}</p>
                    </div>
                    @if($enquiry->contacted_at)
                        <div style="margin-bottom: 10px;">
                            <p style="margin: 0; color: #999;">Contacted</p>
                            <p style="margin: 0;">{{ $enquiry->contacted_at->format('d M, Y H:i') }}</p>
                        </div>
                    @endif
                    @if($enquiry->confirmed_at)
                        <div>
                            <p style="margin: 0; color: #999;">Confirmed</p>
                            <p style="margin: 0;">{{ $enquiry->confirmed_at->format('d M, Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div style="margin-top: 20px;">
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-arrow-left"></i> Back to Enquiries
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
