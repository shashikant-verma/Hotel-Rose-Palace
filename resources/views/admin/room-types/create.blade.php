@extends('admin.layouts.app')

@section('title', 'Create Room Type')
@section('page-title', 'Create New Room Type')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-plus-circle me-2"></i> Room Type Information</h5>

            <form action="{{ route('admin.room-types.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Room Type Name <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="e.g., Deluxe Suite, Executive Room"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea 
                        class="form-control @error('description') is-invalid @enderror" 
                        id="description" 
                        name="description" 
                        rows="4" 
                        placeholder="Describe the room type features and highlights..."
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pricing -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="base_price" class="form-label">Base Price (₹) <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('base_price') is-invalid @enderror" 
                            id="base_price" 
                            name="base_price" 
                            value="{{ old('base_price') }}" 
                            min="0" 
                            step="0.01"
                            placeholder="2500"
                            required
                        >
                        @error('base_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="size_sqft" class="form-label">Room Size (sq ft) <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('size_sqft') is-invalid @enderror" 
                            id="size_sqft" 
                            name="size_sqft" 
                            value="{{ old('size_sqft') }}" 
                            min="1"
                            placeholder="350"
                            required
                        >
                        @error('size_sqft')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Occupancy -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="max_occupancy" class="form-label">Max Occupancy <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('max_occupancy') is-invalid @enderror" 
                            id="max_occupancy" 
                            name="max_occupancy" 
                            value="{{ old('max_occupancy', 2) }}" 
                            min="1" 
                            max="10"
                            required
                        >
                        @error('max_occupancy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="max_adults" class="form-label">Max Adults <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('max_adults') is-invalid @enderror" 
                            id="max_adults" 
                            name="max_adults" 
                            value="{{ old('max_adults', 2) }}" 
                            min="1" 
                            max="10"
                            required
                        >
                        @error('max_adults')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="max_children" class="form-label">Max Children <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control @error('max_children') is-invalid @enderror" 
                            id="max_children" 
                            name="max_children" 
                            value="{{ old('max_children', 2) }}" 
                            min="0" 
                            max="10"
                            required
                        >
                        @error('max_children')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="is_active" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Active (visible to customers)
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Create Room Type
                    </button>
                    <a href="{{ route('admin.room-types.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Amenities Selection -->
        <div class="table-card">
            <h5><i class="fas fa-list-check me-2"></i> Select Amenities</h5>
            <p class="text-muted small">Choose amenities for this room type</p>

            @if($amenities->count() > 0)
                @foreach($amenities as $category => $categoryAmenities)
                    <div class="mb-3">
                        <strong class="text-primary">{{ ucfirst($category) }}</strong>
                        @foreach($categoryAmenities as $amenity)
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="amenities[]" 
                                    value="{{ $amenity->id }}" 
                                    id="amenity_{{ $amenity->id }}"
                                    {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                    <i class="{{ $amenity->icon_class }} me-1"></i> {{ $amenity->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <p class="text-muted">No amenities available</p>
            @endif
        </div>
    </div>
</div>
@endsection
