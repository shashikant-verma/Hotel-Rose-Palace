@extends('admin.layouts.app')

@section('title', 'Website Settings')
@section('page-title', 'Website Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')

    <!-- Hotel Information -->
    <div class="table-card mb-4">
        <h5><i class="fas fa-hotel me-2"></i> Hotel Information</h5>
        <p class="text-muted">Manage your hotel's basic information</p>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Hotel Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="settings[hotel_name]" 
                    value="{{ $settings['hotel_name'] }}"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Hotel Tagline</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="settings[hotel_tagline]" 
                    value="{{ $settings['hotel_tagline'] }}"
                >
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Hotel Description</label>
                <textarea 
                    class="form-control" 
                    name="settings[hotel_description]" 
                    rows="3"
                >{{ $settings['hotel_description'] }}</textarea>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Address</label>
                <textarea 
                    class="form-control" 
                    name="settings[hotel_address]" 
                    rows="2"
                >{{ $settings['hotel_address'] }}</textarea>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="table-card mb-4">
        <h5><i class="fas fa-phone me-2"></i> Contact Information</h5>
        <p class="text-muted">Update contact details displayed on website</p>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Primary Phone</label>
                <input 
                    type="tel" 
                    class="form-control" 
                    name="settings[contact_phone]" 
                    value="{{ $settings['contact_phone'] }}"
                >
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">WhatsApp Number</label>
                <input 
                    type="tel" 
                    class="form-control" 
                    name="settings[whatsapp_number]" 
                    value="{{ $settings['whatsapp_number'] }}"
                    required
                >
                <small class="text-muted">Used for enquiry WhatsApp integration</small>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Email Address</label>
                <input 
                    type="email" 
                    class="form-control" 
                    name="settings[contact_email]" 
                    value="{{ $settings['contact_email'] }}"
                >
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div class="table-card mb-4">
        <h5><i class="fas fa-share-alt me-2"></i> Social Media Links</h5>
        <p class="text-muted">Add your social media profile links</p>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fab fa-facebook me-2"></i> Facebook URL</label>
                <input 
                    type="url" 
                    class="form-control" 
                    name="settings[social_facebook]" 
                    value="{{ $settings['social_facebook'] }}"
                    placeholder="https://facebook.com/yourpage"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fab fa-instagram me-2"></i> Instagram URL</label>
                <input 
                    type="url" 
                    class="form-control" 
                    name="settings[social_instagram]" 
                    value="{{ $settings['social_instagram'] }}"
                    placeholder="https://instagram.com/yourprofile"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fab fa-twitter me-2"></i> Twitter URL</label>
                <input 
                    type="url" 
                    class="form-control" 
                    name="settings[social_twitter]" 
                    value="{{ $settings['social_twitter'] }}"
                    placeholder="https://twitter.com/yourprofile"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fab fa-youtube me-2"></i> YouTube URL</label>
                <input 
                    type="url" 
                    class="form-control" 
                    name="settings[social_youtube]" 
                    value="{{ $settings['social_youtube'] }}"
                    placeholder="https://youtube.com/yourchannel"
                >
            </div>
        </div>
    </div>

    <!-- Business Hours -->
    <div class="table-card mb-4">
        <h5><i class="fas fa-clock me-2"></i> Business Hours</h5>
        <p class="text-muted">Set check-in and check-out times</p>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Check-in Time</label>
                <input 
                    type="time" 
                    class="form-control" 
                    name="settings[checkin_time]" 
                    value="{{ $settings['checkin_time'] }}"
                >
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Check-out Time</label>
                <input 
                    type="time" 
                    class="form-control" 
                    name="settings[checkout_time]" 
                    value="{{ $settings['checkout_time'] }}"
                >
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Reception Hours</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="settings[reception_hours]" 
                    value="{{ $settings['reception_hours'] }}"
                    placeholder="24/7"
                >
            </div>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="table-card mb-4">
        <h5><i class="fas fa-search me-2"></i> SEO Settings</h5>
        <p class="text-muted">Optimize your website for search engines</p>

        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Meta Title</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="settings[meta_title]" 
                    value="{{ $settings['meta_title'] }}"
                    maxlength="60"
                >
                <small class="text-muted">Recommended: 50-60 characters</small>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Meta Description</label>
                <textarea 
                    class="form-control" 
                    name="settings[meta_description]" 
                    rows="2"
                    maxlength="160"
                >{{ $settings['meta_description'] }}</textarea>
                <small class="text-muted">Recommended: 150-160 characters</small>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Meta Keywords</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="settings[meta_keywords]" 
                    value="{{ $settings['meta_keywords'] }}"
                >
                <small class="text-muted">Comma-separated keywords</small>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="table-card">
        <div class="d-flex gap-2 justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i> Save All Settings
            </button>
        </div>
    </div>
</form>

<!-- Quick Links -->
<div class="row mt-4 g-3">
    <div class="col-md-4">
        <div class="table-card text-center">
            <i class="fas fa-images fa-3x text-primary mb-3"></i>
            <h6>Gallery Management</h6>
            <p class="text-muted small">Upload and manage hotel images</p>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-primary">
                Manage Gallery
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card text-center">
            <i class="fas fa-list-check fa-3x text-success mb-3"></i>
            <h6>Amenities Management</h6>
            <p class="text-muted small">Add and edit hotel amenities</p>
            <a href="{{ route('admin.amenities.index') }}" class="btn btn-outline-success">
                Manage Amenities
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card text-center">
            <i class="fas fa-layer-group fa-3x text-info mb-3"></i>
            <h6>Room Types</h6>
            <p class="text-muted small">Manage room categories</p>
            <a href="{{ route('admin.room-types.index') }}" class="btn btn-outline-info">
                Manage Room Types
            </a>
        </div>
    </div>
</div>
@endsection
