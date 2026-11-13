@extends('admin.layouts.app')

@section('title', 'Edit Amenity')
@section('page-title', 'Edit Amenity')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Amenity</h5>
                <a href="{{ route('admin.amenities.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.amenities.update', $amenity) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Amenity Name <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name', $amenity->name) }}"
                            placeholder="e.g., Free Wi-Fi, Swimming Pool"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            class="form-control @error('category') is-invalid @enderror"
                            id="category"
                            name="category"
                            value="{{ old('category', $amenity->category) }}"
                            list="category-options"
                            placeholder="e.g., connectivity, services, comfort"
                            required
                        >
                        <datalist id="category-options">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                            <option value="connectivity">
                            <option value="services">
                            <option value="comfort">
                            <option value="entertainment">
                            <option value="facilities">
                        </datalist>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="icon_class" class="form-label">Icon Class <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i id="icon-preview-icon" class="{{ $amenity->icon_class }}"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control @error('icon_class') is-invalid @enderror"
                            id="icon_class"
                            name="icon_class"
                            value="{{ old('icon_class', $amenity->icon_class) }}"
                            placeholder="e.g., fas fa-wifi"
                            required
                            oninput="updateIconPreview(this.value)"
                        >
                        @error('icon_class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">
                        Use <a href="https://fontawesome.com/icons" target="_blank">Font Awesome 6</a> icon class.
                    </small>
                </div>

                <!-- Quick Icon Picker -->
                <div class="mb-3">
                    <label class="form-label">Quick Select Icons</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach([
                            'fas fa-wifi' => 'Wi-Fi',
                            'fas fa-parking' => 'Parking',
                            'fas fa-concierge-bell' => 'Concierge',
                            'fas fa-utensils' => 'Restaurant',
                            'fas fa-swimming-pool' => 'Pool',
                            'fas fa-dumbbell' => 'Gym',
                            'fas fa-spa' => 'Spa',
                            'fas fa-snowflake' => 'AC',
                            'fas fa-tv' => 'TV',
                            'fas fa-tshirt' => 'Laundry',
                            'fas fa-shield-alt' => 'Security',
                            'fas fa-coffee' => 'Coffee',
                            'fas fa-car' => 'Car Service',
                            'fas fa-baby' => 'Kids',
                            'fas fa-paw' => 'Pet Friendly',
                        ] as $icon => $label)
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-secondary icon-btn"
                                onclick="selectIcon('{{ $icon }}')"
                                title="{{ $label }}"
                            >
                                <i class="{{ $icon }}"></i> {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        class="form-control @error('description') is-invalid @enderror"
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Brief description of this amenity..."
                        maxlength="500"
                    >{{ old('description', $amenity->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Max 500 characters</small>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $amenity->is_active) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            <strong>Active</strong> — Visible on the website
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.amenities.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-md-4">
        <!-- Current State -->
        <div class="table-card mb-3">
            <h5><i class="fas fa-eye me-2"></i> Current Preview</h5>
            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                <div style="width:50px;height:50px;background:rgba(212,175,55,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i id="preview-icon" class="{{ $amenity->icon_class }}" style="color:#d4af37;font-size:20px;"></i>
                </div>
                <div>
                    <div id="preview-name" style="font-weight:600;color:#1a2332;">{{ $amenity->name }}</div>
                    <div id="preview-category" style="font-size:12px;color:#888;">{{ ucfirst($amenity->category) }}</div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="table-card border border-danger">
            <h5 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Danger Zone</h5>
            <p class="text-muted small">Permanently delete this amenity. This action cannot be undone.</p>
            @if($amenity->roomTypes()->count() > 0)
                <div class="alert alert-warning small">
                    <i class="fas fa-info-circle me-1"></i>
                    This amenity is assigned to {{ $amenity->roomTypes()->count() }} room type(s). Remove assignments first.
                </div>
            @else
                <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this amenity? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="fas fa-trash me-2"></i> Delete Amenity
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateIconPreview(iconClass) {
    document.getElementById('icon-preview-icon').className = iconClass;
    document.getElementById('preview-icon').className = iconClass;
}

function selectIcon(iconClass) {
    document.getElementById('icon_class').value = iconClass;
    updateIconPreview(iconClass);
}

document.getElementById('name')?.addEventListener('input', function() {
    document.getElementById('preview-name').textContent = this.value || 'Amenity Name';
});

document.getElementById('category')?.addEventListener('input', function() {
    document.getElementById('preview-category').textContent = this.value || 'Category';
});
</script>
@endpush
