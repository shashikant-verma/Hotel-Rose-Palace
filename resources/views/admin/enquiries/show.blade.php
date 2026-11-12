@extends('admin.layouts.app')

@section('title', 'Enquiry Details')
@section('page-title', 'Enquiry Details - ' . $enquiry->reference_id)

@section('content')
<div class="row g-4">
    <!-- Enquiry Information -->
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-info-circle me-2"></i> Enquiry Information</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Reference ID:</strong>
                    <p class="text-muted">{{ $enquiry->reference_id }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>
                        @php
                            $statusColors = [
                                'new' => 'primary',
                                'contacted' => 'info',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'secondary'
                            ];
                            $color = $statusColors[$enquiry->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ ucfirst($enquiry->status) }}</span>
                    </p>
                </div>
            </div>

            <hr>

            <h6>Guest Details</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <p class="text-muted">{{ $enquiry->guest_name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    <p class="text-muted">{{ $enquiry->guest_email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Phone:</strong>
                    <p class="text-muted">{{ $enquiry->guest_phone }}</p>
                </div>
            </div>

            <hr>

            <h6>Booking Details</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Room Type:</strong>
                    <p class="text-muted">{{ $enquiry->roomType->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Check-in Date:</strong>
                    <p class="text-muted">{{ $enquiry->check_in_date->format('M d, Y') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Check-out Date:</strong>
                    <p class="text-muted">{{ $enquiry->check_out_date->format('M d, Y') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Number of Nights:</strong>
                    <p class="text-muted">{{ $enquiry->check_in_date->diffInDays($enquiry->check_out_date) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Adults:</strong>
                    <p class="text-muted">{{ $enquiry->adults }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Children:</strong>
                    <p class="text-muted">{{ $enquiry->children }}</p>
                </div>
            </div>

            @if($enquiry->special_requests)
                <hr>
                <h6>Special Requests</h6>
                <p class="text-muted">{{ $enquiry->special_requests }}</p>
            @endif
        </div>
    </div>

    <!-- Actions & Timeline -->
    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-tools me-2"></i> Actions</h5>
            
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('hotel.whatsapp_number', '')) }}?text=Regarding%20{{ $enquiry->reference_id }}" 
               target="_blank" 
               class="btn btn-success w-100 mb-2">
                <i class="fab fa-whatsapp me-2"></i> Contact on WhatsApp
            </a>

            <a href="mailto:{{ $enquiry->guest_email }}" class="btn btn-primary w-100 mb-2">
                <i class="fas fa-envelope me-2"></i> Send Email
            </a>

            <a href="tel:{{ $enquiry->guest_phone }}" class="btn btn-info w-100 mb-2">
                <i class="fas fa-phone me-2"></i> Call Guest
            </a>
        </div>

        <div class="table-card mt-4">
            <h5><i class="fas fa-clock me-2"></i> Timeline</h5>
            
            <div class="mb-3">
                <strong>Created:</strong>
                <p class="text-muted">{{ $enquiry->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <strong>Last Updated:</strong>
                <p class="text-muted">{{ $enquiry->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary w-100 mt-3">
            <i class="fas fa-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>
@endsection
