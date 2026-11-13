@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Booking Status</h5>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Reference Number</h6>
                            <p class="mb-0" style="font-family: monospace; font-size: 1.1em;">
                                <strong>#{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold">Status</h6>
                            <p class="mb-0">
                                @switch($booking->status)
                                    @case('pending_payment')
                                        <span class="badge bg-warning">Awaiting Payment</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-info">Completed</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <hr>

                    @if ($booking->status === 'pending_payment')
                        <div class="alert alert-warning mb-4">
                            <h6 class="alert-heading"><i class="fas fa-clock"></i> Payment Pending</h6>
                            <p class="mb-0">Your booking is temporarily reserved. Please complete payment within 24 hours to confirm your reservation.</p>
                        </div>
                    @elseif ($booking->status === 'confirmed')
                        <div class="alert alert-success mb-4">
                            <h6 class="alert-heading"><i class="fas fa-check-circle"></i> Booking Confirmed</h6>
                            <p class="mb-0">Your booking is confirmed. A detailed itinerary has been sent to your email.</p>
                        </div>
                    @elseif ($booking->status === 'cancelled')
                        <div class="alert alert-danger mb-4">
                            <h6 class="alert-heading"><i class="fas fa-times-circle"></i> Booking Cancelled</h6>
                            <p class="mb-0">This booking has been cancelled.</p>
                        </div>
                    @endif

                    <!-- Booking Details -->
                    <h6 class="mb-3">Booking Details</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Guest Name</small>
                            <p class="mb-0"><strong>{{ $booking->customer_name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Email</small>
                            <p class="mb-0">{{ $booking->customer_email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Check-in</small>
                            <p class="mb-0"><strong>{{ $booking->check_in_date->format('D, M d, Y') }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Check-out</small>
                            <p class="mb-0"><strong>{{ $booking->check_out_date->format('D, M d, Y') }}</strong></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Room Category</small>
                            <p class="mb-0"><strong>{{ $booking->roomType->name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Rooms & Guests</small>
                            <p class="mb-0"><strong>{{ $booking->number_of_rooms }} room(s)</strong> for {{ $booking->total_guests }} guest(s)</p>
                        </div>
                    </div>

                    @if ($booking->allocations->count())
                        <hr>
                        <h6 class="mb-3">Allocated Rooms</h6>
                        
                        @foreach ($booking->allocations as $allocation)
                            @if ($allocation->room_id)
                                <div class="badge bg-light text-dark me-2 mb-2">
                                    Room {{ $allocation->room->room_number }}
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <hr>

                    <!-- Payment Summary -->
                    <h6 class="mb-3">Payment Summary</h6>
                    
                    <div class="bg-light p-3 rounded mb-4">
                        <div class="row text-sm mb-2">
                            <div class="col-6">Subtotal</div>
                            <div class="col-6 text-end">₹{{ number_format($booking->subtotal_amount, 2) }}</div>
                        </div>
                        <div class="row text-sm mb-2">
                            <div class="col-6">GST (12%)</div>
                            <div class="col-6 text-end">₹{{ number_format($booking->tax_amount, 2) }}</div>
                        </div>
                        <div class="row fw-bold text-lg border-top pt-2">
                            <div class="col-6">Total Amount</div>
                            <div class="col-6 text-end">₹{{ number_format($booking->total_amount, 2) }}</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        @if ($booking->status === 'pending_payment')
                            <a href="{{ route('booking.payment', ['booking' => $booking->id]) }}" class="btn btn-success btn-lg fw-semibold">
                                <i class="fas fa-credit-card"></i> Complete Payment
                            </a>
                        @endif
                        
                        <a href="{{ route('booking.search.form') }}" class="btn btn-outline-primary">
                            New Booking
                        </a>
                    </div>
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
