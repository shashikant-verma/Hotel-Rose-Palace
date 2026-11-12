@extends('layouts.app')

@section('title', 'Hotel Rose Palace - Premium Luxury Hotel in Surat')

@section('content')

<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(rgba(26, 35, 50, 0.6), rgba(26, 35, 50, 0.6)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat;">
    <div class="container">
        <div class="hero-content text-center text-white">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px;">
                {{ config('hotel.name') }}
            </h1>
            <p style="font-size: 24px; color: #d9a9a0; margin-bottom: 32px;">
                Where Elegance Meets Comfort
            </p>
            <a href="{{ route('rooms') }}" class="btn btn-primary btn-lg">
                Explore Our Rooms
            </a>
        </div>
    </div>
</section>

<!-- Welcome Section -->
<section class="bg-ivory">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500" alt="Hotel Lobby" style="border-radius: 8px; width: 100%; height: auto;">
            </div>
            <div class="col-md-6 ps-md-4">
                <h2 style="color: #1a2332;">Welcome to Hotel Rose Palace</h2>
                <p style="font-size: 16px; line-height: 1.8; color: #666;">
                    Nestled in the heart of Surat, Hotel Rose Palace offers an exquisite blend of modern comfort and timeless elegance. Whether you're visiting for business or leisure, our dedicated team ensures an unforgettable experience.
                </p>
                <p style="font-size: 16px; line-height: 1.8; color: #666;">
                    With premium amenities, spacious rooms, and personalized service, we pride ourselves on exceeding your expectations at every turn.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary" style="margin-top: 16px;">
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rooms Section -->
<section>
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #1a2332;">Our Room Categories</h2>
            <p style="color: #999; font-size: 16px;">Choose from our carefully curated selection of rooms</p>
        </div>
        
        <div class="row g-4">
            @forelse($featuredRooms as $room)
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{ $room->featuredImage?->image_url ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500' }}" alt="{{ $room->roomType->name }}" class="card-img" style="height: 280px; object-fit: cover;">
                        <div class="card-body">
                            <h4 class="card-title">{{ $room->roomType->name }}</h4>
                            <p class="card-text">{{ Str::limit($room->roomType->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="card-price" style="font-size: 20px; color: #c9a961;">₹{{ number_format($room->current_price, 0) }}</span>
                                <a href="{{ route('room-detail', $room->roomType->slug) }}" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p style="color: #999;">No rooms available at the moment.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('rooms') }}" class="btn btn-secondary">
                View All Rooms →
            </a>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="bg-navy text-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #ffffff;">World-Class Amenities</h2>
            <p style="color: #f5f3f0; font-size: 16px;">Experience comfort and convenience with our premium facilities</p>
        </div>
        
        <div class="row g-4">
            @forelse($amenities as $amenity)
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div style="font-size: 40px; color: #c9a961; margin-bottom: 16px;">
                            <i class="fas fa-{{ $amenity->icon_class ?? 'star' }}"></i>
                        </div>
                        <h5 style="color: #ffffff; font-family: 'Poppins', sans-serif;">{{ $amenity->name }}</h5>
                        <p style="color: #f5f3f0; font-size: 14px; margin: 0;">{{ $amenity->description }}</p>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p>No amenities to display.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Gallery Preview Section -->
<section class="bg-ivory">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #1a2332;">Gallery Highlights</h2>
            <p style="color: #999; font-size: 16px;">Discover the beauty of Hotel Rose Palace</p>
        </div>
        
        <div class="gallery-grid">
            @forelse($galleryImages as $image)
                <div class="gallery-item">
                    <img src="{{ $image->image_url }}" alt="{{ $image->title ?? 'Gallery' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div class="gallery-overlay">
                        <h4>{{ $image->title ?? 'Gallery Image' }}</h4>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p style="color: #999;">No gallery images to display.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('gallery') }}" class="btn btn-primary">
                View Full Gallery
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section>
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color: #1a2332;">Guest Testimonials</h2>
            <p style="color: #999; font-size: 16px;">What our guests say about their experience</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div style="margin-bottom: 12px; color: #f39c12;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text" style="font-style: italic;">
                            "Hotel Rose Palace exceeded all my expectations. The staff was incredibly attentive and the rooms are absolutely beautiful. Highly recommended!"
                        </p>
                        <p style="font-weight: 600; margin: 0; color: #1a2332;">
                            - Sarah Johnson
                        </p>
                        <p style="font-size: 13px; color: #999; margin: 0;">
                            New York, USA
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div style="margin-bottom: 12px; color: #f39c12;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text" style="font-style: italic;">
                            "A perfect blend of luxury and comfort. The restaurant serves amazing food, and the ambiance is just perfect for a relaxing getaway."
                        </p>
                        <p style="font-weight: 600; margin: 0; color: #1a2332;">
                            - Priya Patel
                        </p>
                        <p style="font-size: 13px; color: #999; margin: 0;">
                            Mumbai, India
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div style="margin-bottom: 12px; color: #f39c12;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text" style="font-style: italic;">
                            "Outstanding service and exceptional hospitality. Every detail was taken care of perfectly. Can't wait to return!"
                        </p>
                        <p style="font-weight: 600; margin: 0; color: #1a2332;">
                            - David Chen
                        </p>
                        <p style="font-size: 13px; color: #999; margin: 0;">
                            Singapore
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="bg-ivory">
    <div class="container">
        <div class="text-center mb-4">
            <h2 style="color: #1a2332;">Our Location</h2>
            <p style="color: #999; font-size: 16px;">Conveniently located in the heart of Surat</p>
        </div>
        
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div style="background-color: #e8e6e3; height: 400px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <p style="color: #999;">Google Maps Integration</p>
                </div>
            </div>
            <div class="col-md-6 ps-md-4">
                <h4 style="color: #1a2332; margin-bottom: 20px;">Hotel Rose Palace</h4>
                <p style="margin-bottom: 16px;">
                    <i class="fas fa-map-marker-alt" style="color: #c9a961; width: 20px;"></i>
                    {{ config('hotel.location.address') }}
                </p>
                <p style="margin-bottom: 16px;">
                    <i class="fas fa-phone" style="color: #c9a961; width: 20px;"></i>
                    <a href="tel:{{ config('hotel.contact.phone_1') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.phone_1') }}</a>
                </p>
                <p style="margin-bottom: 16px;">
                    <i class="fas fa-phone" style="color: #c9a961; width: 20px;"></i>
                    <a href="tel:{{ config('hotel.contact.phone_2') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.phone_2') }}</a>
                </p>
                <p style="margin-bottom: 24px;">
                    <i class="fas fa-envelope" style="color: #c9a961; width: 20px;"></i>
                    <a href="mailto:{{ config('hotel.contact.email') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.email') }}</a>
                </p>
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    Get In Touch
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
