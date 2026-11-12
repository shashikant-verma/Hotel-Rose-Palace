@extends('layouts.app')

@section('title', 'Hotel Rose Palace - Luxury Accommodation in Surat')
@section('meta_description', 'Experience luxury at Hotel Rose Palace, Surat. 50+ rooms, 24/7 dining, 4.8★ rating. Book now via WhatsApp.')

@section('content')
<style>
    :root {
        --color-sandstone: #EDE4D8;
        --color-champagne: #F7F1E8;
        --color-beige: #E2D5C3;
        --color-border: #D8CBB8;
        --color-burgundy: #6E2C3A;
        --color-brass: #B88A44;
        --color-charcoal: #2E1F22;
        --color-mauve: #5E4B4E;
    }

    .hero-section {
        background: linear-gradient(rgba(110, 44, 58, 0.5), rgba(110, 44, 58, 0.5)), 
                    url('https://images.unsplash.com/photo-1631049307038-da0ec89d4d0a?w=1200') center/cover;
        height: 650px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--color-champagne);
        position: relative;
    }

    .hero-content h1 {
        font-size: 56px;
        margin-bottom: 16px;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    }

    .hero-content p {
        font-size: 24px;
        margin-bottom: 32px;
        color: var(--color-brass);
        text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
    }

    /* Floating Booking Bar */
    .floating-booking {
        background: rgba(247, 241, 232, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid var(--color-border);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        max-width: 600px;
        margin-bottom: 40px;
        position: relative;
        z-index: 10;
    }

    .booking-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap: 16px;
        align-items: flex-end;
    }

    .booking-field {
        display: flex;
        flex-direction: column;
    }

    .booking-field label {
        color: var(--color-charcoal);
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .booking-field input,
    .booking-field select {
        padding: 12px;
        border: 1px solid var(--color-border);
        border-radius: 6px;
        background: white;
        color: var(--color-charcoal);
        font-size: 14px;
    }

    .btn-check-availability {
        background: var(--color-burgundy);
        color: white;
        padding: 12px 28px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-check-availability:hover {
        background: #5a2430;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(110, 44, 58, 0.3);
    }

    /* Welcome Section */
    .welcome-section {
        background: var(--color-sandstone);
        padding: 80px 0;
    }

    .welcome-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .welcome-image {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .welcome-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .welcome-text h2 {
        font-size: 42px;
        margin-bottom: 24px;
        color: var(--color-burgundy);
        position: relative;
        padding-bottom: 20px;
    }

    .welcome-text h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--color-brass);
        border-radius: 2px;
    }

    .welcome-text p {
        color: var(--color-charcoal);
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 24px;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 40px;
    }

    .stat-box {
        background: var(--color-champagne);
        padding: 24px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid var(--color-border);
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: var(--color-burgundy);
        margin-bottom: 8px;
    }

    .stat-label {
        color: var(--color-mauve);
        font-size: 14px;
        font-weight: 600;
    }

    /* Room Categories Section */
    .rooms-section {
        background: var(--color-sandstone);
        padding: 80px 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title h2 {
        font-size: 42px;
        color: var(--color-burgundy);
        margin-bottom: 16px;
        position: relative;
        padding-bottom: 20px;
        display: inline-block;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--color-brass);
        border-radius: 2px;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }

    .room-card {
        background: var(--color-champagne);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        border: 1px solid var(--color-border);
        transition: all 0.3s ease;
    }

    .room-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    .room-image-container {
        position: relative;
        overflow: hidden;
        height: 280px;
    }

    .room-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .room-card:hover .room-image-container img {
        transform: scale(1.08);
    }

    .room-price-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: var(--color-brass);
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 16px;
    }

    .room-details {
        padding: 24px;
    }

    .room-name {
        font-size: 22px;
        font-weight: 700;
        color: var(--color-burgundy);
        margin-bottom: 12px;
    }

    .room-description {
        color: var(--color-mauve);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .room-amenities {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .amenity-badge {
        background: var(--color-beige);
        color: var(--color-charcoal);
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-book-room {
        width: 100%;
        background: var(--color-burgundy);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-book-room:hover {
        background: #5a2430;
    }

    /* Amenities Section */
    .amenities-section {
        background: var(--color-beige);
        padding: 80px 0;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }

    .amenity-card {
        background: var(--color-champagne);
        border: 2px solid var(--color-border);
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .amenity-card:hover {
        border-color: var(--color-brass);
        box-shadow: 0 8px 24px rgba(184, 138, 68, 0.15);
        transform: translateY(-4px);
    }

    .amenity-icon {
        font-size: 48px;
        color: var(--color-brass);
        margin-bottom: 16px;
    }

    .amenity-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-burgundy);
        margin-bottom: 12px;
    }

    .amenity-description {
        color: var(--color-mauve);
        font-size: 13px;
        line-height: 1.6;
    }

    /* Experiences Section */
    .experiences-section {
        background: var(--color-sandstone);
        padding: 80px 0;
    }

    .experiences-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }

    .experience-card {
        background: var(--color-champagne);
        border: 1px solid var(--color-border);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .experience-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    .experience-header {
        background: var(--color-brass);
        color: white;
        padding: 24px;
        text-align: center;
    }

    .experience-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .experience-body {
        padding: 24px;
        flex-grow: 1;
    }

    .experience-description {
        color: var(--color-mauve);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .btn-enquire {
        width: 100%;
        background: var(--color-burgundy);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-enquire:hover {
        background: #5a2430;
    }

    /* Gallery Section */
    .gallery-section {
        background: var(--color-sandstone);
        padding: 80px 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 60px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        aspect-ratio: 1;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.08);
    }

    /* Testimonials Section */
    .testimonials-section {
        background: var(--color-beige);
        padding: 80px 0;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
    }

    .testimonial-card {
        background: var(--color-champagne);
        padding: 32px;
        border-radius: 12px;
        border: 1px solid var(--color-border);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .testimonial-rating {
        color: var(--color-brass);
        font-size: 18px;
        margin-bottom: 12px;
        letter-spacing: 2px;
    }

    .testimonial-text {
        color: var(--color-charcoal);
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 16px;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--color-brass);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .author-info {
        flex-grow: 1;
    }

    .author-name {
        font-weight: 700;
        color: var(--color-burgundy);
        font-size: 14px;
    }

    .author-title {
        color: var(--color-mauve);
        font-size: 12px;
    }

    /* Location Section */
    .location-section {
        padding: 80px 0;
        background: var(--color-sandstone);
    }

    .location-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .location-info h2 {
        font-size: 36px;
        color: var(--color-burgundy);
        margin-bottom: 24px;
    }

    .location-details {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 32px;
    }

    .location-item {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .location-icon {
        font-size: 24px;
        color: var(--color-brass);
        min-width: 32px;
    }

    .location-text {
        color: var(--color-charcoal);
        font-size: 15px;
        line-height: 1.6;
    }

    .map-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border: none;
    }

    @media (max-width: 768px) {
        .booking-row {
            grid-template-columns: 1fr 1fr;
        }

        .welcome-content {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .location-container {
            grid-template-columns: 1fr;
        }

        .hero-content h1 {
            font-size: 36px;
        }

        .hero-content p {
            font-size: 18px;
        }

        .section-title h2 {
            font-size: 28px;
        }
    }
</style>

<!-- Hero Section with Booking Bar -->
<div class="hero-section">
    <div class="hero-content">
        <h1>Hotel Rose Palace</h1>
        <p>Where Luxury Meets Comfort</p>
        
        <!-- Floating Booking Bar -->
        <form method="POST" action="{{ route('enquiry.store') }}" class="floating-booking">
            @csrf
            <div class="booking-row">
                <div class="booking-field">
                    <label>Check-in</label>
                    <input type="date" name="check_in_date" required>
                </div>
                <div class="booking-field">
                    <label>Check-out</label>
                    <input type="date" name="check_out_date" required>
                </div>
                <div class="booking-field">
                    <label>Guests</label>
                    <select name="number_of_guests" required>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4+</option>
                    </select>
                </div>
                <button type="button" class="btn-check-availability" onclick="scrollToRooms()">
                    Check Availability
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Welcome Section -->
<section class="welcome-section">
    <div class="container">
        <div class="welcome-content">
            <div class="welcome-image">
                <img src="https://images.unsplash.com/photo-1631049307038-da0ec89d4d0a?w=600" alt="Hotel Rose Palace Interior">
            </div>
            <div class="welcome-text">
                <h2>Welcome to Hotel Rose Palace</h2>
                <p>Experience unparalleled luxury and hospitality at Hotel Rose Palace, located in the heart of Surat's premier business district. Our meticulously designed suites and world-class amenities ensure your stay is nothing short of exceptional.</p>
                <p>Whether you're visiting for business or leisure, our dedicated team is committed to delivering personalized service and unforgettable moments.</p>
                
                <div class="stats-container">
                    <div class="stat-box">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Luxury Rooms</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Dining Available</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">4.8★</div>
                        <div class="stat-label">Guest Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Room Categories Section -->
<section class="rooms-section" id="rooms-section">
    <div class="container">
        <div class="section-title">
            <h2>Our Room Categories</h2>
        </div>
        
        <div class="rooms-grid">
            @forelse($rooms as $room)
                <div class="room-card">
                    <div class="room-image-container">
                        @if($room->images->count() > 0)
                            <img src="{{ asset('storage/' . $room->images->first()->image_path) }}" alt="{{ $room->roomType->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1631049307038-da0ec89d4d0a?w=500" alt="{{ $room->roomType->name }}">
                        @endif
                        <div class="room-price-badge">₹{{ $room->roomType->base_price }}/night</div>
                    </div>
                    <div class="room-details">
                        <div class="room-name">{{ $room->roomType->name }}</div>
                        <div class="room-description">{{ $room->roomType->description ?? 'Premium accommodation with world-class amenities.' }}</div>
                        
                        <div class="room-amenities">
                            @if($room->roomType->amenities->count() > 0)
                                @foreach($room->roomType->amenities->take(3) as $amenity)
                                    <span class="amenity-badge">{{ $amenity->name }}</span>
                                @endforeach
                            @else
                                <span class="amenity-badge">WiFi</span>
                                <span class="amenity-badge">AC</span>
                                <span class="amenity-badge">TV</span>
                            @endif
                        </div>
                        
                        <a href="https://wa.me/918866771900?text=Hello%20Hotel%20Rose%20Palace%2C%20I%20would%20like%20to%20book%20{{ urlencode($room->roomType->name) }}" target="_blank" class="btn-book-room">
                            <i class="fab fa-whatsapp"></i> Book via WhatsApp
                        </a>
                    </div>
                </div>
            @empty
                <!-- Default Showcase Rooms -->
                @php
                    $defaultRooms = [
                        [
                            'name' => 'Deluxe Room',
                            'description' => 'Spacious room with premium bedding, modern amenities, and city views.',
                            'price' => '₹4,999',
                            'amenities' => ['WiFi', 'AC', 'Flat-screen TV']
                        ],
                        [
                            'name' => 'Executive Suite',
                            'description' => 'Luxurious suite featuring separate living area, premium bathroom, and personalized service.',
                            'price' => '₹7,999',
                            'amenities' => ['WiFi', 'Jacuzzi', 'Work Desk']
                        ],
                        [
                            'name' => 'Royal Penthouse',
                            'description' => 'Our flagship suite with panoramic views, private terrace, and VIP concierge service.',
                            'price' => '₹12,999',
                            'amenities' => ['WiFi', 'Wine Bar', 'Terrace']
                        ]
                    ];
                @endphp
                
                @foreach($defaultRooms as $room)
                    <div class="room-card">
                        <div class="room-image-container">
                            <img src="https://images.unsplash.com/photo-1631049307038-da0ec89d4d0a?w=500" alt="{{ $room['name'] }}">
                            <div class="room-price-badge">{{ $room['price'] }}</div>
                        </div>
                        <div class="room-details">
                            <div class="room-name">{{ $room['name'] }}</div>
                            <div class="room-description">{{ $room['description'] }}</div>
                            
                            <div class="room-amenities">
                                @foreach($room['amenities'] as $amenity)
                                    <span class="amenity-badge">{{ $amenity }}</span>
                                @endforeach
                            </div>
                            
                            <a href="https://wa.me/918866771900?text=Hello%20Hotel%20Rose%20Palace%2C%20I%20would%20like%20to%20book%20{{ urlencode($room['name']) }}" target="_blank" class="btn-book-room">
                                <i class="fab fa-whatsapp"></i> Book via WhatsApp
                            </a>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Amenities Section -->
<section class="amenities-section">
    <div class="container">
        <div class="section-title">
            <h2>World-Class Amenities</h2>
        </div>
        
        <div class="amenities-grid">
            @forelse($amenities as $amenity)
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <i class="{{ $amenity->icon_class }}"></i>
                    </div>
                    <div class="amenity-name">{{ $amenity->name }}</div>
                    <div class="amenity-description">{{ $amenity->description ?? 'Premium facility available for all guests.' }}</div>
                </div>
            @empty
                <!-- Default Amenities -->
                @php
                    $defaultAmenities = [
                        ['icon' => 'fas fa-wifi', 'name' => 'High-Speed WiFi', 'desc' => 'Premium internet in all rooms and public areas'],
                        ['icon' => 'fas fa-utensils', 'name' => '24/7 Dining', 'desc' => 'Multi-cuisine restaurant and room service'],
                        ['icon' => 'fas fa-dumbbell', 'name' => 'Fitness Center', 'desc' => 'State-of-the-art gym and yoga studio'],
                        ['icon' => 'fas fa-spa', 'name' => 'Spa & Wellness', 'desc' => 'Rejuvenating treatments and therapies'],
                        ['icon' => 'fas fa-parking', 'name' => 'Valet Parking', 'desc' => 'Secure covered parking facility'],
                        ['icon' => 'fas fa-briefcase', 'name' => 'Business Center', 'desc' => 'Fully equipped for meetings and events'],
                        ['icon' => 'fas fa-swimming-pool', 'name' => 'Swimming Pool', 'desc' => 'Olympic-sized pool with cabanas'],
                        ['icon' => 'fas fa-concierge-bell', 'name' => '24/7 Concierge', 'desc' => 'Personalized assistance anytime'],
                        ['icon' => 'fas fa-wheelchair', 'name' => 'Accessibility', 'desc' => 'Wheelchair-friendly facilities']
                    ];
                @endphp
                
                @foreach($defaultAmenities as $amenity)
                    <div class="amenity-card">
                        <div class="amenity-icon">
                            <i class="{{ $amenity['icon'] }}"></i>
                        </div>
                        <div class="amenity-name">{{ $amenity['name'] }}</div>
                        <div class="amenity-description">{{ $amenity['desc'] }}</div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Experiences Section -->
<section class="experiences-section">
    <div class="container">
        <div class="section-title">
            <h2>Curated Experiences & Offers</h2>
        </div>
        
        <div class="experiences-grid">
            <div class="experience-card">
                <div class="experience-header">
                    <div class="experience-title">Corporate Stays</div>
                </div>
                <div class="experience-body">
                    <div class="experience-description">
                        Tailored packages for business travelers featuring dedicated workspace, meeting rooms, and flexible check-in times.
                    </div>
                    <a href="https://wa.me/918866771900?text=Hello%20Hotel%20Rose%20Palace%2C%20I%20am%20interested%20in%20Corporate%20Stays%20package" target="_blank" class="btn-enquire">
                        <i class="fab fa-whatsapp"></i> Enquire Now
                    </a>
                </div>
            </div>

            <div class="experience-card">
                <div class="experience-header">
                    <div class="experience-title">Banquet & Events</div>
                </div>
                <div class="experience-body">
                    <div class="experience-description">
                        Elegantly appointed banquet halls for weddings, conferences, and celebrations with professional event planning.
                    </div>
                    <a href="https://wa.me/918866771900?text=Hello%20Hotel%20Rose%20Palace%2C%20I%20would%20like%20to%20plan%20an%20event" target="_blank" class="btn-enquire">
                        <i class="fab fa-whatsapp"></i> Plan Your Event
                    </a>
                </div>
            </div>

            <div class="experience-card">
                <div class="experience-header">
                    <div class="experience-title">Weekend Packages</div>
                </div>
                <div class="experience-body">
                    <div class="experience-description">
                        Relaxing getaway packages including spa credits, dining vouchers, and exclusive access to our premium facilities.
                    </div>
                    <a href="https://wa.me/918866771900?text=Hello%20Hotel%20Rose%20Palace%2C%20Tell%20me%20about%20Weekend%20Packages" target="_blank" class="btn-enquire">
                        <i class="fab fa-whatsapp"></i> Explore Deals
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <div class="section-title">
            <h2>Gallery</h2>
        </div>
        
        <div class="gallery-grid">
            @php
                $galleryImages = [
                    'https://images.unsplash.com/photo-1631049307038-da0ec89d4d0a?w=600',
                    'https://images.unsplash.com/photo-1570129477492-45a003537e1f?w=600',
                    'https://images.unsplash.com/photo-1564183957991-0ff1b645de72?w=600',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600',
                    'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=600',
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600'
                ];
            @endphp
            
            @foreach($galleryImages as $image)
                <div class="gallery-item">
                    <img src="{{ $image }}" alt="Hotel Rose Palace">
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-title">
            <h2>What Our Guests Say</h2>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">★★★★★</div>
                <div class="testimonial-text">
                    "Exceptional service, luxurious rooms, and outstanding hospitality. Hotel Rose Palace exceeded all expectations!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">AK</div>
                    <div class="author-info">
                        <div class="author-name">Anil Kumar</div>
                        <div class="author-title">Business Traveler</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">★★★★★</div>
                <div class="testimonial-text">
                    "Perfect venue for our wedding celebration! Every detail was handled beautifully. Highly recommended for special events."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">PM</div>
                    <div class="author-info">
                        <div class="author-name">Priya Mishra</div>
                        <div class="author-title">Event Planner</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">★★★★★</div>
                <div class="testimonial-text">
                    "The spa experience was incredible, and the dining options are world-class. Truly a home away from home!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">SJ</div>
                    <div class="author-info">
                        <div class="author-name">Sneha Joshi</div>
                        <div class="author-title">Leisure Guest</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location & Map Section -->
<section class="location-section">
    <div class="container">
        <div class="location-container">
            <div class="location-info">
                <h2>Visit Us</h2>
                
                <div class="location-details">
                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="location-text">
                            <strong>Address:</strong><br>
                            4th Floor, Atlanta Business Hub<br>
                            VIP Road, Vesu<br>
                            Surat, Gujarat 395007
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="location-text">
                            <strong>Phone:</strong><br>
                            +91 88667-71900<br>
                            +91 88667-19929
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="location-text">
                            <strong>Email:</strong><br>
                            hotelrosepalacesurat@gmail.com
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="location-text">
                            <strong>Follow Us:</strong><br>
                            <a href="https://instagram.com/hotelrosepalace9" target="_blank">@hotelrosepalace9</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.4895850892247!2d72.8192068!3d21.1725871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04da33333333d%3A0x1234567890abcdef!2sAtlanta%20Business%20Hub%2C%20VIP%20Road%2C%20Vesu%2C%20Surat!5e0!3m2!1sen!2sin!4v1699000000000" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<script>
    function scrollToRooms() {
        document.getElementById('rooms-section').scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endsection
