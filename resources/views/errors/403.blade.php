@extends('layouts.app')

@section('title', '403 - Access Denied')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="error-page">
                <div class="error-code mb-4">
                    <h1 class="display-1 fw-bold text-warning">403</h1>
                </div>
                
                <div class="error-message mb-4">
                    <h2 class="h3 mb-3">Access Denied</h2>
                    <p class="text-muted mb-4">
                        You don't have permission to access this page.
                    </p>
                </div>

                <div class="error-actions">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2 mb-2">
                        <i class="fas fa-home me-2"></i> Go to Homepage
                    </a>
                    @guest
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-primary btn-lg mb-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Admin Login
                    </a>
                    @endguest
                </div>

                <div class="mt-5">
                    <p class="text-muted">
                        <small>Need help? <a href="{{ route('contact') }}">Contact Us</a></small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 60px 20px;
}

.error-code h1 {
    font-size: 10rem;
    line-height: 1;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .error-code h1 {
        font-size: 6rem;
    }
}
</style>
@endsection
