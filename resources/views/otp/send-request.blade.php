@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="h3 mb-4 text-center">Verify Your Mobile</h1>
                    <p class="text-muted text-center mb-4">
                        We'll send you a verification code to confirm your mobile number
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Error</h4>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('otp.send') }}" method="POST" id="otpSendForm">
                        @csrf

                        <div class="mb-4">
                            <label for="mobile" class="form-label fw-semibold">Mobile Number</label>
                            <input 
                                type="tel" 
                                name="mobile" 
                                id="mobile"
                                class="form-control form-control-lg @error('mobile') is-invalid @enderror"
                                placeholder="+91 9XXXXXXXXX"
                                value="{{ old('mobile') }}"
                                required
                                pattern="^\+?[0-9]{10,15}$"
                                title="Enter a valid mobile number (10-15 digits)"
                                autocomplete="tel"
                            >
                            @error('mobile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted d-block mt-2">
                                Include country code (e.g., +91 for India)
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="purpose" class="form-label fw-semibold">I want to:</label>
                            <select name="purpose" id="purpose" class="form-select form-select-lg @error('purpose') is-invalid @enderror" required>
                                <option value="">Select an option</option>
                                <option value="booking" @selected(old('purpose', request('purpose')) === 'booking')>
                                    Book a room
                                </option>
                                <option value="manage_bookings" @selected(old('purpose', request('purpose')) === 'manage_bookings')>
                                    Manage my bookings
                                </option>
                            </select>
                            @error('purpose')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                            Send Verification Code
                        </button>
                    </form>

                    <hr class="my-4">

                    <p class="text-center text-muted small">
                        By continuing, you agree to our
                        <a href="{{ route('terms') }}" class="text-decoration-none">Terms of Service</a> and
                        <a href="{{ route('privacy') }}" class="text-decoration-none">Privacy Policy</a>
                    </p>
                </div>
            </div>

            <div class="mt-3 text-center">
                <small class="text-muted">
                    Already verified? 
                    <a href="{{ route('otp.verify.form') }}" class="text-decoration-none">Enter code</a>
                </small>
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
    
    .form-control-lg, .form-select-lg {
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 16px;
        border: 1px solid #dee2e6;
    }
    
    .form-control-lg:focus, .form-select-lg:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .btn-lg {
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 16px;
    }
</style>
@endsection
