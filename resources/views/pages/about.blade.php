@extends('layouts.app')

@section('title', 'About Hotel Rose Palace - Our Story & Values')

@section('content')

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(rgba(26, 35, 50, 0.6), rgba(26, 35, 50, 0.6)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat;">
    <div class="container">
        <div class="hero-content text-center text-white">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px;">
                About Us
            </h1>
            <p style="font-size: 24px; color: #d9a9a0;">
                Our Story, Our Values, Our Commitment
            </p>
        </div>
    </div>
</section>

<!-- About Section -->
<section>
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600" alt="Hotel Lobby" style="border-radius: 8px; width: 100%;">
            </div>
            <div class="col-md-6 ps-md-4">
                <h2 style="color: #1a2332; margin-bottom: 24px;">Our Story</h2>
                <p style="font-size: 16px; line-height: 1.8; color: #666; margin-bottom: 16px;">
                    Hotel Rose Palace was established with a vision to redefine hospitality in Surat. From our humble beginnings to becoming one of the most sought-after luxury hotels in the region, we have remained committed to excellence.
                </p>
                <p style="font-size: 16px; line-height: 1.8; color: #666; margin-bottom: 16px;">
                    Our name, "Rose Palace," symbolizes elegance, beauty, and grace – qualities we strive to deliver in every aspect of our service. Each room, each meal, and each interaction with our staff is designed to create an unforgettable experience.
                </p>
                <p style="font-size: 16px; line-height: 1.8; color: #666;">
                    Today, Hotel Rose Palace stands as a testament to our dedication to providing world-class hospitality with a personal touch.
                </p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=600" alt="Modern Amenities" style="border-radius: 8px; width: 100%;">
            </div>
            <div class="col-md-6 order-md-1 pe-md-4">
                <h2 style="color: #1a2332; margin-bottom: 24px;">Our Mission</h2>
                <p style="font-size: 16px; line-height: 1.8; color: #666; margin-bottom: 16px;">
                    Our mission is to provide exceptional hospitality that exceeds expectations. We believe in creating memorable experiences where guests feel valued, comfortable, and perfectly at home.
                </p>
                <p style="font-size: 16px; line-height: 1.8; color: #666;">
                    We are dedicated to maintaining the highest standards of service, comfort, and quality in everything we do.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="bg-ivory">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #1a2332;">Our Core Values</h2>
            <p style="color: #999; font-size: 16px;">What guides us in everything we do</p>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center p-4">
                    <div style="font-size: 50px; color: #c9a961; margin-bottom: 16px;">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 style="color: #1a2332; margin-bottom: 12px; font-family: 'Poppins', sans-serif;">Hospitality</h5>
                    <p style="color: #666; font-size: 14px;">
                        We treat every guest like family, ensuring their comfort and satisfaction.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center p-4">
                    <div style="font-size: 50px; color: #c9a961; margin-bottom: 16px;">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 style="color: #1a2332; margin-bottom: 12px; font-family: 'Poppins', sans-serif;">Excellence</h5>
                    <p style="color: #666; font-size: 14px;">
                        We pursue excellence in every detail, from design to service.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center p-4">
                    <div style="font-size: 50px; color: #c9a961; margin-bottom: 16px;">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5 style="color: #1a2332; margin-bottom: 12px; font-family: 'Poppins', sans-serif;">Integrity</h5>
                    <p style="color: #666; font-size: 14px;">
                        We conduct our business with honesty and transparency.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center p-4">
                    <div style="font-size: 50px; color: #c9a961; margin-bottom: 16px;">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5 style="color: #1a2332; margin-bottom: 12px; font-family: 'Poppins', sans-serif;">Sustainability</h5>
                    <p style="color: #666; font-size: 14px;">
                        We care for the environment and community we serve.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section>
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #1a2332;">Our Facilities & Services</h2>
            <p style="color: #999; font-size: 16px;">Premium amenities for your comfort and convenience</p>
        </div>

        <div class="row g-4">
            @forelse($amenities as $amenity)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <div style="font-size: 40px; color: #c9a961; margin-bottom: 16px;">
                                <i class="fas fa-{{ $amenity->icon_class ?? 'star' }}"></i>
                            </div>
                            <h5 style="color: #1a2332; margin-bottom: 12px; font-family: 'Poppins', sans-serif;">{{ $amenity->name }}</h5>
                            <p style="color: #666; font-size: 14px; margin: 0;">
                                {{ $amenity->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p style="color: #999;">No amenities to display.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-navy text-center text-white" style="padding: 60px 0;">
    <div class="container">
        <h2 style="color: #ffffff; margin-bottom: 24px;">Experience the Difference</h2>
        <p style="font-size: 18px; color: #f5f3f0; margin-bottom: 32px;">
            Discover why Hotel Rose Palace is the preferred choice for discerning travelers.
        </p>
        <a href="{{ route('rooms') }}" class="btn btn-primary btn-lg">
            Book Your Stay Today
        </a>
    </div>
</section>

@endsection
