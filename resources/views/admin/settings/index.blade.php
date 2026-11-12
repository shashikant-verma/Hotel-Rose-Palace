@extends('admin.layouts.app')

@section('title', 'Website Settings')
@section('page-title', 'Website Settings')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="table-card">
            <h5><i class="fas fa-cog me-2"></i> Hotel Information</h5>
            <p class="text-muted">Manage your hotel's basic information and contact details</p>
            
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" value="Hotel Rose Palace" placeholder="Enter hotel name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control" value="info@hotelrosepalace.com" placeholder="Enter email">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" value="+91 1234567890" placeholder="Enter phone">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="tel" class="form-control" value="+91 1234567890" placeholder="Enter WhatsApp number">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="3" placeholder="Enter full address">4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Settings
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="table-card">
            <h5><i class="fas fa-images me-2"></i> Gallery Management</h5>
            <p class="text-muted">Manage hotel gallery images</p>
            
            <button class="btn btn-success">
                <i class="fas fa-upload me-2"></i> Upload Images
            </button>
        </div>
    </div>

    <div class="col-md-6">
        <div class="table-card">
            <h5><i class="fas fa-list me-2"></i> Amenities Management</h5>
            <p class="text-muted">Manage hotel amenities and facilities</p>
            
            <button class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Add Amenity
            </button>
        </div>
    </div>
</div>
@endsection
