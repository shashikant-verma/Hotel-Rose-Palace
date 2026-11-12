@extends('admin.layouts.app')

@section('title', 'Edit Room Type')
@section('page-title', 'Edit Room Type: ' . $roomType->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-edit me-2"></i> Room Type Information</h5>

            <form action="{{ route('admin.room-types.update', $roomType) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Room Type Name <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $roomType->name) }}" 
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
                        required
                    >{{ old('description', $roomType->description) }}</textarea>
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
                            value="{{ old('base_price', $roomType->base_price) }}" 
                            min="0" 
                            step="0.01"
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
                            value="{{ old('size_sqft', $roomType->size_sqft) }}" 
                            min="1"
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
                            value="{{ old('max_occupancy', $roomType->max_occupancy) }}" 
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
                            value="{{ old('max_adults', $roomType->max_adults) }}" 
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
                            value="{{ old('max_children', $roomType->max_children) }}" 
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
                            {{ old('is_active', $roomType->is_active) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Active (visible to customers)
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update Room Type
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
                                    form="room-type-form"
                                    {{ in_array($amenity->id, old('amenities', $selectedAmenities)) ? 'checked' : '' }}
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

        <!-- Room Count -->
        <div class="table-card mt-3">
            <h5><i class="fas fa-bed me-2"></i> Rooms</h5>
            <p class="mb-0">
                <strong>{{ $roomType->rooms->count() }}</strong> rooms assigned to this room type
            </p>
            @if($roomType->rooms->count() > 0)
                <a href="{{ route('admin.rooms.index') }}?room_type={{ $roomType->id }}" class="btn btn-sm btn-outline-primary mt-2">
                    View Rooms
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Link checkboxes to the form
document.querySelectorAll('input[name="amenities[]"]').forEach(input => {
    input.setAttribute('form', 'room-type-form');
});

// Add form ID to the main form
document.querySelector('form').setAttribute('id', 'room-type-form');
</script>
@endpush
