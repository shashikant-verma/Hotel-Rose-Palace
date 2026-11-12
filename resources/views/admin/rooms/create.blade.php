@extends('admin.layouts.app')

@section('title', 'Create Room')
@section('page-title', 'Create New Room')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-plus-circle me-2"></i> Room Information</h5>

            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf

                <!-- Room Type -->
                <div class="mb-3">
                    <label for="room_type_id" class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select 
                        class="form-select @error('room_type_id') is-invalid @enderror" 
                        id="room_type_id" 
                        name="room_type_id" 
                        required
                    >
                        <option value="">Select room type...</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} (₹{{ number_format($type->base_price) }})
                            </option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Room Number and Floor -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="room_number" class="form-label">Room Number <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control @error('room_number') is-invalid @enderror" 
                            id="room_number" 
                            name="room_number" 
                            value="{{ old('room_number') }}" 
                            placeholder="e.g., 101, 202, A-301"
                            required
                        >
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="floor" class="form-label">Floor Number <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('floor') is-invalid @enderror" 
                            id="floor" 
                            name="floor" 
                            value="{{ old('floor', 1) }}" 
                            min="0" 
                            max="50"
                            required
                        >
                        @error('floor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Current Price -->
                <div class="mb-3">
                    <label for="current_price" class="form-label">Current Price (₹)</label>
                    <input 
                        type="number" 
                        class="form-control @error('current_price') is-invalid @enderror" 
                        id="current_price" 
                        name="current_price" 
                        value="{{ old('current_price') }}" 
                        min="0" 
                        step="0.01"
                        placeholder="Leave empty to use room type base price"
                    >
                    <small class="text-muted">If empty, will use the room type's base price</small>
                    @error('current_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select 
                        class="form-select @error('status') is-invalid @enderror" 
                        id="status" 
                        name="status" 
                        required
                    >
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Availability -->
                <div class="mb-4">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="is_available" 
                            name="is_available" 
                            value="1"
                            {{ old('is_available', true) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_available">
                            Available for booking
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Create Room
                    </button>
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-info-circle me-2"></i> Quick Tips</h5>
            
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <strong>Room Number:</strong> Use unique identifiers like floor + number (e.g., 101, 202)
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <strong>Room Type:</strong> Select the category this room belongs to
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <strong>Price:</strong> Leave empty to use room type base price, or set custom price
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <strong>Status:</strong> Available, Occupied, Maintenance, or Reserved
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <strong>Images:</strong> Add room images after creating the room
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
