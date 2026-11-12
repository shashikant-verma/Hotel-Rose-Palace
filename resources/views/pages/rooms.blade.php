@extends('layouts.app')

@section('title', 'Our Rooms & Suites - Hotel Rose Palace')

@section('content')

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(rgba(26, 35, 50, 0.6), rgba(26, 35, 50, 0.6)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat;">
    <div class="container">
        <div class="hero-content text-center text-white">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px;">
                Our Rooms & Suites
            </h1>
            <p style="font-size: 24px; color: #d9a9a0;">
                Comfort redefined in luxury
            </p>
        </div>
    </div>
</section>

<!-- Rooms Section -->
<section>
    <div class="container">
        @forelse($roomTypes as $roomType)
            <div class="row align-items-center mb-5" style="border-bottom: 1px solid #e8e6e3; padding-bottom: 48px;">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600" alt="{{ $roomType->name }}" style="border-radius: 8px; width: 100%;">
                </div>
                <div class="col-md-6 ps-md-4">
                    <h3 style="color: #1a2332; margin-bottom: 16px;">{{ $roomType->name }}</h3>
                    <p style="font-size: 16px; line-height: 1.8; color: #666; margin-bottom: 20px;">
                        {{ $roomType->description }}
                    </p>

                    <div style="margin-bottom: 20px;">
                        <h6 style="color: #1a2332; margin-bottom: 12px; font-family: 'Poppins', sans-serif;">Room Features:</h6>
                        <ul style="list-style: none; padding: 0;">
                            @foreach($roomType->amenities as $amenity)
                                <li style="margin-bottom: 8px; color: #666;">
                                    <i class="fas fa-check" style="color: #c9a961; margin-right: 8px;"></i>
                                    {{ $amenity->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-6">
                            <div style="background-color: #f5f3f0; padding: 16px; border-radius: 4px; text-align: center;">
                                <p style="color: #999; font-size: 12px; margin: 0;">STARTING FROM</p>
                                <p style="color: #c9a961; font-size: 28px; font-weight: 700; margin: 8px 0 0 0;">₹{{ number_format($roomType->base_price, 0) }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background-color: #f5f3f0; padding: 16px; border-radius: 4px; text-align: center;">
                                <p style="color: #999; font-size: 12px; margin: 0;">MAX GUESTS</p>
                                <p style="color: #1a2332; font-size: 28px; font-weight: 700; margin: 8px 0 0 0;">{{ $roomType->max_occupancy }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('room-detail', $roomType->slug) }}" class="btn btn-primary">
                        View Details & Book
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <p style="color: #999;">No rooms available at the moment.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Amenities Section -->
<section class="bg-ivory">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #1a2332;">All Room Categories Include</h2>
            <p style="color: #999; font-size: 16px;">Standard amenities across all room types</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-wifi" style="font-size: 40px; color: #c9a961; margin-bottom: 16px;"></i>
                    <h5 style="color: #1a2332; margin-bottom: 8px;">Free Wi-Fi</h5>
                    <p style="color: #666; font-size: 14px;">High-speed internet throughout</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-wind" style="font-size: 40px; color: #c9a961; margin-bottom: 16px;"></i>
                    <h5 style="color: #1a2332; margin-bottom: 8px;">Air Conditioning</h5>
                    <p style="color: #666; font-size: 14px;">Climate-controlled comfort</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-tv" style="font-size: 40px; color: #c9a961; margin-bottom: 16px;"></i>
                    <h5 style="color: #1a2332; margin-bottom: 8px;">Entertainment</h5>
                    <p style="color: #666; font-size: 14px;">Flat-screen TV with cable</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-navy text-center text-white" style="padding: 60px 0;">
    <div class="container">
        <h2 style="color: #ffffff; margin-bottom: 24px;">Ready to Book?</h2>
        <p style="font-size: 18px; color: #f5f3f0; margin-bottom: 32px;">
            Contact us via WhatsApp to check availability and confirm your reservation.
        </p>
        <a href="https://wa.me/{{ str_replace([' ', '+'], '', config('hotel.contact.whatsapp_number')) }}" target="_blank" class="btn btn-primary btn-lg">
            <i class="fab fa-whatsapp"></i> Enquire on WhatsApp
        </a>
    </div>
</section>

@endsection
