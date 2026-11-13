@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="h3 mb-2 text-center">Enter Verification Code</h1>
                    <p class="text-muted text-center mb-1">
                        We sent a code to <strong id="mobileMasked">{{ $mobile ? substr($mobile, -4) : '' }}</strong>
                    </p>
                    <p class="text-muted text-center mb-4 small">
                        The code expires in <span id="expiryTimer">5:00</span>
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
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

                    <form action="{{ route('otp.verify') }}" method="POST" id="otpVerifyForm">
                        @csrf

                        <input type="hidden" name="mobile" value="{{ $mobile }}">
                        <input type="hidden" name="purpose" value="{{ $purpose }}">

                        <div class="mb-4">
                            <label for="otp" class="form-label fw-semibold">6-Digit Code</label>
                            <input 
                                type="text" 
                                name="otp" 
                                id="otp"
                                class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                                placeholder="000000"
                                value="{{ old('otp') }}"
                                required
                                inputmode="numeric"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                title="Enter 6 digits"
                                autocomplete="one-time-code"
                            >
                            @error('otp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted d-block mt-2">
                                Enter the 6-digit code from the SMS
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                            Verify Code
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-3 small text-muted">Didn't receive the code?</p>
                        
                        <button 
                            type="button" 
                            class="btn btn-outline-secondary btn-sm w-100"
                            id="resendBtn"
                            onclick="resendOtp()"
                        >
                            <span id="resendText">Resend Code</span>
                            <span id="resendTimer" style="display: none;"></span>
                        </button>
                        
                        <p class="mt-3 small text-muted">
                            <a href="{{ route('otp.send.form') }}" class="text-decoration-none">
                                Use a different number
                            </a>
                        </p>
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
    
    #otp {
        font-size: 32px;
        letter-spacing: 12px;
        font-weight: bold;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }
    
    #otp:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .form-control-lg {
        padding: 12px 16px;
        font-size: 16px;
    }
    
    .btn-lg {
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 16px;
    }
    
    #resendBtn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    #expiryTimer {
        font-weight: bold;
        color: #dc3545;
    }
</style>

<script>
    // Auto-focus OTP input
    document.addEventListener('DOMContentLoaded', function() {
        const otpInput = document.getElementById('otp');
        if (otpInput) {
            otpInput.focus();
        }
        
        // Start expiry timer
        startExpiryTimer();
        
        // Allow only numbers in OTP field
        otpInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    });
    
    // Expiry timer (5 minutes)
    function startExpiryTimer() {
        let timeLeft = 300; // 5 minutes in seconds
        const timerElement = document.getElementById('expiryTimer');
        
        const interval = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(interval);
                document.getElementById('otpVerifyForm').innerHTML = `
                    <div class="alert alert-danger">
                        <h5>Code Expired</h5>
                        <p>The verification code has expired. Please request a new code.</p>
                        <a href="{{ route('otp.send.form') }}" class="btn btn-primary btn-sm">Request New Code</a>
                    </div>
                `;
            }
            timeLeft--;
        }, 1000);
    }
    
    // Resend OTP with throttling
    let resendCountdown = 0;
    
    function resendOtp() {
        if (resendCountdown > 0) {
            return;
        }
        
        const mobile = document.querySelector('input[name="mobile"]').value;
        const purpose = document.querySelector('input[name="purpose"]').value;
        const resendBtn = document.getElementById('resendBtn');
        const resendText = document.getElementById('resendText');
        const resendTimer = document.getElementById('resendTimer');
        
        // Show loading state
        resendBtn.disabled = true;
        resendText.textContent = 'Sending...';
        
        // Make AJAX request
        fetch('{{ route("otp.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                mobile: mobile,
                purpose: purpose
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.role = 'alert';
                alert.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.card-body').insertBefore(alert, document.querySelector('form').nextSibling);
                
                // Start countdown
                resendCountdown = 60;
                resendTimer.style.display = 'inline';
                resendText.style.display = 'none';
                updateResendTimer();
            } else {
                // Show error message
                alert('Error: ' + (data.message || 'Failed to resend OTP'));
                resendBtn.disabled = false;
                resendText.textContent = 'Resend Code';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            resendBtn.disabled = false;
            resendText.textContent = 'Resend Code';
        });
    }
    
    function updateResendTimer() {
        const resendBtn = document.getElementById('resendBtn');
        const resendText = document.getElementById('resendText');
        const resendTimer = document.getElementById('resendTimer');
        
        if (resendCountdown > 0) {
            resendTimer.textContent = `Try again in ${resendCountdown}s`;
            resendCountdown--;
            setTimeout(updateResendTimer, 1000);
        } else {
            resendBtn.disabled = false;
            resendTimer.style.display = 'none';
            resendText.style.display = 'inline';
            resendText.textContent = 'Resend Code';
        }
    }
</script>
@endsection
