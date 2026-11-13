@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Booking Progress -->
            <div class="mb-4">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" style="width: 66%;" role="progressbar"></div>
                </div>
                <small class="text-muted d-block mt-2">Step 2 of 3: Enter Booking Details</small>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">Booking Summary</h5>
                    
                    <div class="row text-sm mb-3">
                        <div class="col-6">
                            <small class="text-muted">Check-in</small>
                            <p class="mb-0"><strong>{{ $checkIn->format('D, M d, Y') }}</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Check-out</small>
                            <p class="mb-0"><strong>{{ $checkOut->format('D, M d, Y') }}</strong></p>
                        </div>
                    </div>

                    <div class="row text-sm mb-3">
                        <div class="col-6">
                            <small class="text-muted">Room Category</small>
                            <p class="mb-0"><strong>{{ $roomType->name }}</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Quantity</small>
                            <p class="mb-0"><strong>{{ $quantity }} Room(s)</strong></p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row text-sm">
                        <div class="col-6">
                            <small class="text-muted">Nights</small>
                            <p class="mb-0"><strong>{{ $nights }}</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Max Guests/Room</small>
                            <p class="mb-0"><strong>{{ $roomType->max_occupancy }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Guest Information</h5>

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">Please correct the errors:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('booking.store') }}" method="POST" class="needs-validation">
                        @csrf

                        <!-- Hidden fields for booking details -->
                        <input type="hidden" name="check_in" value="{{ $checkIn->format('Y-m-d') }}">
                        <input type="hidden" name="check_out" value="{{ $checkOut->format('Y-m-d') }}">
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                        <input type="hidden" name="quantity" value="{{ $quantity }}">

                        <div class="mb-4">
                            <label for="customer_name" class="form-label fw-semibold">Guest Name *</label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg @error('customer_name') is-invalid @enderror"
                                id="customer_name"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                placeholder="Full name of primary guest"
                                required
                            >
                            @error('customer_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="customer_email" class="form-label fw-semibold">Email Address *</label>
                            <input 
                                type="email" 
                                class="form-control form-control-lg @error('customer_email') is-invalid @enderror"
                                id="customer_email"
                                name="customer_email"
                                value="{{ old('customer_email') }}"
                                placeholder="your@email.com"
                                required
                            >
                            @error('customer_email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Confirmation will be sent here</small>
                        </div>

                        <div class="mb-4">
                            <label for="mobile" class="form-label fw-semibold">Mobile Number</label>
                            <input 
                                type="tel" 
                                class="form-control form-control-lg"
                                id="mobile"
                                value="{{ $customerMobile ? '****' . substr($customerMobile, -4) : 'Not verified' }}"
                                disabled
                            >
                            <small class="form-text text-muted">Verified for this booking</small>
                        </div>

                        <div class="mb-4">
                            <label for="total_guests" class="form-label fw-semibold">Total Number of Guests *</label>
                            <input 
                                type="number" 
                                class="form-control form-control-lg @error('total_guests') is-invalid @enderror"
                                id="total_guests"
                                name="total_guests"
                                value="{{ old('total_guests', 1) }}"
                                min="1"
                                max="{{ $roomType->max_occupancy * $quantity }}"
                                placeholder="1"
                                required
                            >
                            @error('total_guests')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Maximum {{ $roomType->max_occupancy * $quantity }} guests for {{ $quantity }} room(s)
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="special_requests" class="form-label fw-semibold">Special Requests (Optional)</label>
                            <textarea 
                                class="form-control @error('special_requests') is-invalid @enderror"
                                id="special_requests"
                                name="special_requests"
                                rows="3"
                                placeholder="Any special requirements? (e.g., ground floor, high floor, late checkout)"
                            >{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Price Summary -->
                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="mb-2">Price Breakdown</h6>
                            <div class="row text-sm mb-2">
                                <div class="col-6">₹{{ number_format($pricePerNight, 0) }} × {{ $nights }} nights × {{ $quantity }} room(s)</div>
                                <div class="col-6 text-end">₹{{ number_format($subtotal, 2) }}</div>
                            </div>
                            <div class="row text-sm mb-2">
                                <div class="col-6">GST (12%)</div>
                                <div class="col-6 text-end">₹{{ number_format($tax, 2) }}</div>
                            </div>
                            <div class="row fw-bold text-lg">
                                <div class="col-6">Total Amount</div>
                                <div class="col-6 text-end">₹{{ number_format($grandTotal, 2) }}</div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                id="termsCheck"
                                required
                            >
                            <label class="form-check-label" for="termsCheck">
                                I agree to the 
                                <a href="{{ route('terms') }}" target="_blank" class="text-decoration-none">Terms & Conditions</a> and 
                                <a href="{{ route('cancellation') }}" target="_blank" class="text-decoration-none">Cancellation Policy</a>
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="fas fa-arrow-right"></i> Continue to Payment
                            </button>
                            <a href="{{ route('booking.search.form') }}" class="btn btn-outline-secondary">
                                Back to Search
                            </a>
                        </div>
                    </form>
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
    
    .form-control-lg {
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 16px;
        border: 1px solid #dee2e6;
    }
    
    .form-control-lg:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
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
