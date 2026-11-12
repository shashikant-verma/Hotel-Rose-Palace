@extends('layouts.app')

@section('title', 'Contact Hotel Rose Palace')

@section('content')

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(rgba(26, 35, 50, 0.6), rgba(26, 35, 50, 0.6)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat;">
    <div class="container">
        <div class="hero-content text-center text-white">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px;">Get In Touch</h1>
            <p style="font-size: 24px; color: #d9a9a0;">We're here to help</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <h3 style="color: #1a2332; margin-bottom: 32px;">Contact Information</h3>
                
                <div style="margin-bottom: 32px;">
                    <h6 style="color: #1a2332; font-family: 'Poppins', sans-serif; margin-bottom: 12px;">
                        <i class="fas fa-map-marker-alt" style="color: #c9a961; margin-right: 8px;"></i> Address
                    </h6>
                    <p style="color: #666; margin: 0;">{{ config('hotel.location.address') }}</p>
                </div>

                <div style="margin-bottom: 32px;">
                    <h6 style="color: #1a2332; font-family: 'Poppins', sans-serif; margin-bottom: 12px;">
                        <i class="fas fa-phone" style="color: #c9a961; margin-right: 8px;"></i> Phone
                    </h6>
                    <p style="color: #666; margin-bottom: 8px;">
                        <a href="tel:{{ config('hotel.contact.phone_1') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.phone_1') }}</a>
                    </p>
                    <p style="color: #666; margin: 0;">
                        <a href="tel:{{ config('hotel.contact.phone_2') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.phone_2') }}</a>
                    </p>
                </div>

                <div style="margin-bottom: 32px;">
                    <h6 style="color: #1a2332; font-family: 'Poppins', sans-serif; margin-bottom: 12px;">
                        <i class="fas fa-envelope" style="color: #c9a961; margin-right: 8px;"></i> Email
                    </h6>
                    <p style="color: #666; margin: 0;">
                        <a href="mailto:{{ config('hotel.contact.email') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.email') }}</a>
                    </p>
                </div>

                <div style="margin-bottom: 32px;">
                    <h6 style="color: #1a2332; font-family: 'Poppins', sans-serif; margin-bottom: 12px;">
                        <i class="fab fa-whatsapp" style="color: #c9a961; margin-right: 8px;"></i> WhatsApp
                    </h6>
                    <p style="margin: 0;">
                        <a href="https://wa.me/{{ str_replace([' ', '+'], '', config('hotel.contact.whatsapp_number')) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fab fa-whatsapp"></i> Chat with us
                        </a>
                    </p>
                </div>

                <div style="background-color: #f5f3f0; padding: 24px; border-radius: 8px;">
                    <h6 style="color: #1a2332; font-family: 'Poppins', sans-serif; margin-bottom: 12px;">Hours of Operation</h6>
                    <p style="color: #666; margin-bottom: 4px;"><strong>Monday - Friday:</strong> 9:00 AM - 10:00 PM</p>
                    <p style="color: #666; margin-bottom: 4px;"><strong>Saturday - Sunday:</strong> 8:00 AM - 11:00 PM</p>
                    <p style="color: #666; margin: 0;"><strong>Holidays:</strong> Open</p>
                </div>
            </div>

            <div class="col-md-6 ps-md-4">
                <h3 style="color: #1a2332; margin-bottom: 32px;">Send us a Message</h3>
                
                <form method="POST" action="#" style="background-color: #f5f3f0; padding: 32px; border-radius: 8px;">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="name">Your Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label for="subject">Subject <span class="required">*</span></label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="message">Message <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-control" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="bg-ivory">
    <div class="container">
        <h2 style="color: #1a2332; text-align: center; margin-bottom: 32px;">Find Us On The Map</h2>
        <div style="background-color: #e8e6e3; height: 400px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <p style="color: #999;">Google Maps Integration Coming Soon</p>
        </div>
    </div>
</section>

@endsection
