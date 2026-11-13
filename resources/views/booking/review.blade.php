@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Booking Progress -->
            <div class="mb-4">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" style="width: 100%;" role="progressbar"></div>
                </div>
                <small class="text-muted d-block mt-2">Step 3 of 3: Review & Proceed to Payment</small>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Booking Details Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-check-circle text-success"></i> Booking Confirmed
                    </h5>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Reference Number</h6>
                            <p class="mb-0" style="font-family: monospace; font-size: 1.1em;">
                                <strong>#{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Booking Status</h6>
                            <p class="mb-0">
                                <span class="badge bg-warning">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Guest Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Guest Name</h6>
                            <p class="mb-0"><strong>{{ $booking->customer_name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Email</h6>
                            <p class="mb-0">{{ $booking->customer_email }}</p>
                        </div>
                    </div>

                    <!-- Stay Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Check-in</h6>
                            <p class="mb-0"><strong>{{ $booking->check_in_date->format('D, M d, Y') }}</strong></p>
                            <small class="text-muted">From 2:00 PM</small>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Check-out</h6>
                            <p class="mb-0"><strong>{{ $booking->check_out_date->format('D, M d, Y') }}</strong></p>
                            <small class="text-muted">Until 12:00 PM</small>
                        </div>
                    </div>

                    <!-- Room Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Room Category</h6>
                            <p class="mb-0"><strong>{{ $booking->roomType->name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Quantity & Guests</h6>
                            <p class="mb-0"><strong>{{ $booking->number_of_rooms }} room(s)</strong> for {{ $booking->total_guests }} guest(s)</p>
                        </div>
                    </div>

                    @if ($booking->special_requests)
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted small fw-bold">Special Requests</h6>
                            <p class="mb-0 text-muted">{{ $booking->special_requests }}</p>
                        </div>
                    @endif

                    <hr>

                    <!-- Price Summary -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3">Payment Summary</h6>
                        <div class="row text-sm mb-2">
                            <div class="col-6">Subtotal</div>
                            <div class="col-6 text-end">₹{{ number_format($booking->subtotal_amount, 2) }}</div>
                        </div>
                        <div class="row text-sm mb-2">
                            <div class="col-6">GST (12%)</div>
                            <div class="col-6 text-end">₹{{ number_format($booking->tax_amount, 2) }}</div>
                        </div>
                        <div class="row fw-bold text-lg border-top pt-2">
                            <div class="col-6">Total Amount Due</div>
                            <div class="col-6 text-end">₹{{ number_format($booking->total_amount, 2) }}</div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Note:</strong> Your booking is temporarily reserved. Payment must be completed to confirm your reservation.
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('booking.payment', ['booking' => $booking->id]) }}" class="btn btn-success btn-lg fw-semibold">
                            <i class="fas fa-credit-card"></i> Proceed to Payment
                        </a>
                        <a href="{{ route('booking.search.form') }}" class="btn btn-outline-secondary">
                            New Booking
                        </a>
                    </div>
                </div>
            </div>

            <!-- Important Information Card -->
            <div class="card border-warning shadow-sm">
                <div class="card-body p-4">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-exclamation-triangle text-warning"></i> Important Information
                    </h6>
                    <ul class="mb-0 small">
                        <li><strong>Cancellation:</strong> Free cancellation until 24 hours before check-in. 50% refund for cancellations within 24 hours.</li>
                        <li><strong>Check-in Time:</strong> 2:00 PM. Early check-in available upon request (subject to availability).</li>
                        <li><strong>Check-out Time:</strong> 12:00 PM. Late checkout available for an additional fee.</li>
                        <li><strong>Payment:</strong> A confirmation email will be sent with payment details.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border: none;
        border-radius: 12px;
    }
    
    .card.border-warning {
        border: 1px solid #ffc107 !important;
    }
    
    .btn-lg {
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 16px;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-lg {
        font-size: 1.1rem;
    }
</style>

<script>
function number_format(number, decimals = 0) {
    return Number(number).toLocaleString('en-IN', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}
</script>
@endsection
