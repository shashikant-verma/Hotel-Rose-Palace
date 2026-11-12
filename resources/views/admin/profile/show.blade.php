@extends('admin.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="row g-4">
    <!-- Profile Information -->
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-user-edit me-2"></i> Update Profile Information</h5>
            
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Update Profile
                </button>
            </form>
        </div>

        <!-- Change Password -->
        <div class="table-card mt-4">
            <h5><i class="fas fa-lock me-2"></i> Change Password</h5>
            
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('current_password') is-invalid @enderror" 
                        id="current_password" 
                        name="current_password"
                    >
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('new_password') is-invalid @enderror" 
                        id="new_password" 
                        name="new_password"
                        placeholder="Minimum 8 characters"
                    >
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="new_password_confirmation" 
                        name="new_password_confirmation"
                        placeholder="Re-enter new password"
                    >
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key me-2"></i> Change Password
                </button>
            </form>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-info-circle me-2"></i> Account Details</h5>
            
            <div class="mb-3">
                <strong>User ID:</strong>
                <p class="text-muted">{{ $user->id }}</p>
            </div>

            <div class="mb-3">
                <strong>Role:</strong>
                <p><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></p>
            </div>

            <div class="mb-3">
                <strong>Status:</strong>
                <p>
                    @if($user->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </p>
            </div>

            <div class="mb-3">
                <strong>Account Created:</strong>
                <p class="text-muted">{{ $user->created_at->format('M d, Y') }}</p>
            </div>

            <div class="mb-3">
                <strong>Last Login:</strong>
                <p class="text-muted">
                    {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
