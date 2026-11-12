@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="error-page">
                <div class="error-code mb-4">
                    <h1 class="display-1 fw-bold text-danger">500</h1>
                </div>
                
                <div class="error-message mb-4">
                    <h2 class="h3 mb-3">Internal Server Error</h2>
                    <p class="text-muted mb-4">
                        Something went wrong on our end. We're working to fix the issue. 
                        Please try again later.
                    </p>
                </div>

                <div class="error-actions">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2 mb-2">
                        <i class="fas fa-home me-2"></i> Go to Homepage
                    </a>
                    <button onclick="location.reload()" class="btn btn-outline-primary btn-lg mb-2">
                        <i class="fas fa-redo me-2"></i> Try Again
                    </button>
                </div>

                <div class="mt-5">
                    <p class="text-muted">
                        <small>If the problem persists, please <a href="{{ route('contact') }}">contact us</a></small>
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
