@extends('admin.layouts.app')

@section('title', 'Gallery Management')
@section('page-title', 'Gallery Management')

@section('content')
<div class="table-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-images me-2"></i> Gallery Images</h5>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-upload me-2"></i> Upload Images
        </a>
    </div>
</div>

@if($images->count() > 0)
    <!-- Bulk Actions Form -->
    <form method="POST" id="bulk-form">
        @csrf
        <div class="table-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <input type="checkbox" id="select-all" class="form-check-input me-2">
                    <label for="select-all">Select All</label>
                </div>
                <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                    <i class="fas fa-trash me-2"></i> Delete Selected
                </button>
            </div>

            <!-- Image Grid -->
            <div class="row g-3">
                @foreach($images as $image)
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="card image-card">
                            <div class="image-wrapper">
                                <img src="{{ Storage::url($image->image_path) }}" class="card-img-top" alt="{{ $image->alt_text }}">
                                <div class="image-overlay">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input image-checkbox" 
                                        name="image_ids[]" 
                                        value="{{ $image->id }}"
                                    >
                                </div>
                            </div>
                            <div class="card-body p-2">
                                @if($image->title)
                                    <h6 class="card-title mb-1" style="font-size: 14px;">{{ Str::limit($image->title, 20) }}</h6>
                                @endif
                                @if($image->category)
                                    <span class="badge bg-info badge-sm">{{ $image->category }}</span>
                                @endif
                                <span class="badge bg-{{ $image->is_active ? 'success' : 'secondary' }} badge-sm">
                                    {{ $image->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <div class="mt-2 d-flex gap-1">
                                    <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.toggle-status', $image) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $image->is_active ? 'warning' : 'success' }}">
                                            <i class="fas fa-{{ $image->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this image?');">
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
        </div>
    </form>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $images->links() }}
    </div>
@else
    <div class="table-card">
        <div class="text-center py-5 text-muted">
            <i class="fas fa-images fa-3x mb-3"></i>
            <p>No images in gallery yet</p>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-upload me-2"></i> Upload First Images
            </a>
        </div>
    </div>
@endif

<style>
.image-card {
    transition: transform 0.2s;
}

.image-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.image-wrapper {
    position: relative;
    padding-top: 75%; /* 4:3 aspect ratio */
    overflow: hidden;
}

.image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}

.image-overlay .form-check-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.badge-sm {
    font-size: 10px;
    padding: 3px 6px;
}
</style>

@endsection

@push('scripts')
<script>
// Select all checkboxes
document.getElementById('select-all')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.image-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Bulk delete
function bulkDelete() {
    const checkboxes = document.querySelectorAll('.image-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Please select at least one image');
        return false;
    }

    if (confirm(`Are you sure you want to delete ${checkboxes.length} image(s)? This cannot be undone.`)) {
        const form = document.getElementById('bulk-form');
        form.action = '{{ route("admin.gallery.bulk-delete") }}';
        form.submit();
    }
}
</script>
@endpush
