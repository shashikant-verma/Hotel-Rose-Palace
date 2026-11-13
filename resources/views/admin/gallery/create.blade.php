@extends('admin.layouts.app')

@section('title', 'Upload Gallery Images')
@section('page-title', 'Upload Gallery Images')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-upload me-2"></i> Upload Images</h5>

            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="images" class="form-label">Select Images <span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        class="form-control @error('images') is-invalid @enderror" 
                        id="images" 
                        name="images[]" 
                        multiple 
                        accept="image/*"
                        required
                    >
                    <small class="text-muted">Max 20 images, 5MB each. Formats: JPG, PNG, WEBP</small>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title (Optional)</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="title" 
                        name="title" 
                        placeholder="e.g., Hotel Exterior, Deluxe Room"
                    >
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category (Optional)</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="category" 
                        name="category" 
                        list="categories"
                        value="{{ old('category', request('category')) }}"
                        placeholder="e.g., rooms, facilities, dining"
                    >
                    <datalist id="categories">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                        <option value="rooms">
                        <option value="facilities">
                        <option value="dining">
                        <option value="exterior">
                    </datalist>
                </div>

                <div class="mb-3">
                    <label for="alt_text" class="form-label">Alt Text (Optional)</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="alt_text" 
                        name="alt_text" 
                        placeholder="Descriptive text for SEO"
                    >
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="is_active" 
                            name="is_active" 
                            value="1"
                            checked
                        >
                        <label class="form-check-label" for="is_active">
                            Active (visible on website)
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i> Upload Images
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-info-circle me-2"></i> Tips</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Use high-quality images (min 1200px width)
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Optimize images before upload for faster loading
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Add descriptive alt text for SEO
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Categorize images for better organization
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
