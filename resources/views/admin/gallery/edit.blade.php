@extends('admin.layouts.app')

@section('title', 'Edit Gallery Image')
@section('page-title', 'Edit Gallery Image')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Gallery Image</h5>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Gallery
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

            <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Image Title</label>
                    <input
                        type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        id="title"
                        name="title"
                        value="{{ old('title', $gallery->title) }}"
                        placeholder="e.g., Hotel Lobby, Deluxe Room View"
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input
                            type="text"
                            class="form-control @error('category') is-invalid @enderror"
                            id="category"
                            name="category"
                            value="{{ old('category', $gallery->category) }}"
                            list="category-options"
                            placeholder="e.g., rooms, facilities, dining"
                        >
                        <datalist id="category-options">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                            <option value="rooms">
                            <option value="facilities">
                            <option value="dining">
                            <option value="exterior">
                            <option value="lobby">
                            <option value="events">
                        </datalist>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input
                            type="number"
                            class="form-control @error('display_order') is-invalid @enderror"
                            id="display_order"
                            name="display_order"
                            value="{{ old('display_order', $gallery->display_order) }}"
                            min="0"
                            placeholder="0"
                        >
                        <small class="text-muted">Lower number = shown first</small>
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alt_text" class="form-label">Alt Text (SEO)</label>
                    <input
                        type="text"
                        class="form-control @error('alt_text') is-invalid @enderror"
                        id="alt_text"
                        name="alt_text"
                        value="{{ old('alt_text', $gallery->alt_text) }}"
                        placeholder="Descriptive text for search engines and accessibility"
                    >
                    <small class="text-muted">Describe the image for better SEO</small>
                    @error('alt_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            <strong>Active</strong> — Visible in the public gallery
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview Sidebar -->
    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-image me-2"></i> Current Image</h5>
            <div class="text-center">
                <img
                    src="{{ Storage::url($gallery->image_path) }}"
                    alt="{{ $gallery->alt_text ?? $gallery->title }}"
                    class="img-fluid rounded"
                    style="max-height: 250px; width: 100%; object-fit: cover;"
                    onerror="this.src='https://via.placeholder.com/400x300?text=Image+Not+Found'"
                >
                <div class="mt-2">
                    <span class="badge bg-{{ $gallery->is_active ? 'success' : 'secondary' }}">
                        {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($gallery->category)
                        <span class="badge bg-info">{{ $gallery->category }}</span>
                    @endif
                </div>
                <small class="text-muted d-block mt-2">
                    Uploaded: {{ $gallery->created_at->format('M d, Y') }}
                </small>
                <small class="text-muted">
                    Order: #{{ $gallery->display_order }}
                </small>
            </div>

            <hr>

            <p class="text-muted small mb-2">To replace this image, delete it and upload a new one.</p>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-upload me-2"></i> Upload New Images
            </a>
        </div>

        <!-- Danger Zone -->
        <div class="table-card mt-3 border border-danger">
            <h5 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Danger Zone</h5>
            <p class="text-muted small">Permanently delete this image from the gallery and storage.</p>
            <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST"
                  onsubmit="return confirm('Delete this image permanently? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm w-100">
                    <i class="fas fa-trash me-2"></i> Delete Image
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
