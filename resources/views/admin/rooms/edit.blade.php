@extends('admin.layouts.app')

@section('title', 'Edit Room')
@section('page-title', 'Edit Room: ' . $room->room_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Room Information -->
        <div class="table-card mb-4">
            <h5><i class="fas fa-edit me-2"></i> Room Information</h5>

            <form action="{{ route('admin.rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Room Type -->
                <div class="mb-3">
                    <label for="room_type_id" class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select 
                        class="form-select @error('room_type_id') is-invalid @enderror" 
                        id="room_type_id" 
                        name="room_type_id" 
                        required
                    >
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
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
                            value="{{ old('room_number', $room->room_number) }}" 
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
                            value="{{ old('floor', $room->floor) }}" 
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
                    <label for="current_price" class="form-label">Current Price (₹) <span class="text-danger">*</span></label>
                    <input 
                        type="number" 
                        class="form-control @error('current_price') is-invalid @enderror" 
                        id="current_price" 
                        name="current_price" 
                        value="{{ old('current_price', $room->current_price) }}" 
                        min="0" 
                        step="0.01"
                        required
                    >
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
                        <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        <option value="reserved" {{ old('status', $room->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
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
                            {{ old('is_available', $room->is_available) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_available">
                            Available for booking
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update Room
                    </button>
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </form>
        </div>

        <!-- Room Images -->
        <div class="table-card">
            <h5><i class="fas fa-images me-2"></i> Room Images</h5>

            <!-- Upload Form -->
            <form action="{{ route('admin.rooms.upload-images', $room) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="images" class="form-label">Upload Images</label>
                    <input 
                        type="file" 
                        class="form-control @error('images') is-invalid @enderror" 
                        id="images" 
                        name="images[]" 
                        multiple 
                        accept="image/*"
                    >
                    <small class="text-muted">Max 10 images, 2MB each. Formats: JPG, PNG, WEBP</small>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload me-2"></i> Upload Images
                </button>
            </form>

            <!-- Existing Images -->
            @if($room->images->count() > 0)
                <div class="row g-3">
                    @foreach($room->images as $image)
                        <div class="col-md-4">
                            <div class="card">
                                <img src="{{ Storage::url($image->image_path) }}" class="card-img-top" alt="Room image" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if($image->is_featured)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @else
                                            <form action="{{ route('admin.rooms.set-featured', $image) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    <i class="far fa-star"></i> Set Featured
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.rooms.delete-image', $image) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this image?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-images fa-2x mb-2"></i>
                    <p>No images uploaded yet</p>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-info-circle me-2"></i> Room Details</h5>
            
            <div class="mb-3">
                <strong>Created:</strong>
                <p class="text-muted">{{ $room->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <strong>Last Updated:</strong>
                <p class="text-muted">{{ $room->updated_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <strong>Total Images:</strong>
                <p class="text-muted">{{ $room->images->count() }} uploaded</p>
            </div>
        </div>
    </div>
</div>
@endsection
