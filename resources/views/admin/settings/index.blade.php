@extends('layouts.admin')

@section('page_title', 'Website Settings')

@section('content')

<div class="admin-card">
    <h5><i class="fas fa-cog"></i> Website Configuration</h5>
    
    <form method="POST" action="#" style="margin-top: 20px;">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control" 
                           value="{{ config('hotel.contact.whatsapp_number') }}" placeholder="+91 9876543210">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="hotel_email" class="form-label">Hotel Email</label>
                    <input type="email" id="hotel_email" name="hotel_email" class="form-control" 
                           value="{{ config('hotel.contact.email') }}" placeholder="info@hotel.com">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone_1" class="form-label">Primary Phone</label>
                    <input type="text" id="phone_1" name="phone_1" class="form-control" 
                           value="{{ config('hotel.contact.phone_1') }}" placeholder="+91 9876543210">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone_2" class="form-label">Secondary Phone</label>
                    <input type="text" id="phone_2" name="phone_2" class="form-control" 
                           value="{{ config('hotel.contact.phone_2') }}" placeholder="+91 9876543210">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Hotel Address</label>
            <textarea id="address" name="address" class="form-control" rows="3" placeholder="Enter hotel address">{{ config('hotel.location.address') }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </form>
</div>

<div class="admin-card">
    <h5><i class="fas fa-info-circle"></i> Current Configuration</h5>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
        <div>
            <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Hotel Name</p>
            <p style="margin: 0; font-weight: 600;">{{ config('hotel.name') }}</p>
        </div>
        <div>
            <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">City</p>
            <p style="margin: 0;">{{ config('hotel.location.city') }}, {{ config('hotel.location.state') }}</p>
        </div>
        <div>
            <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Pincode</p>
            <p style="margin: 0;">{{ config('hotel.location.pincode') }}</p>
        </div>
        <div>
            <p style="color: #999; font-size: 12px; margin: 0 0 5px 0;">Primary Email</p>
            <p style="margin: 0;">{{ config('hotel.contact.email') }}</p>
        </div>
    </div>
</div>

@endsection
