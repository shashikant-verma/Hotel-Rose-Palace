@extends('layouts.app')

@section('title', 'Hotel Rose Palace - Premium Luxury Hotel in Surat')

@section('content')

<!-- Hero Section -->
<section class="hero bg-sandstone-base" style="background: linear-gradient(rgba(110, 44, 58, 0.5), rgba(110, 44, 58, 0.5)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat; min-height: 600px; display: flex; align-items: center; padding: 60px 0; position: relative;">
    <div class="container">
        <div class="hero-content text-center" style="color: var(--color-champagne);">
            <span style="color: var(--color-brass-gold); font-family: var(--font-ui); font-weight: 600; font-size: 16px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 16px;">Luxury Hospitality in Surat</span>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px; color: var(--color-champagne);">
                {{ config('hotel.name') }}
            </h1>
            <p style="font-size: 24px; color: var(--color-brass-gold); margin-bottom: 32px;">
                Where Elegance Meets Comfort
            </p>
            <a href="{{ route('rooms') }}" class="btn btn-primary btn-lg">
                Explore Our Rooms
            </a>
        </div>
    </div>

    <!-- Floating Quick Availability Bar -->
    <div style="position: absolute; bottom: -100px; left: 50%; transform: translateX(-50%); width: calc(100% - 40px); max-width: 950px; z-index: 100;">
        <div style="background: linear-gradient(135deg, rgba(247,241,232,0.98), rgba(250,246,240,0.98)); border-radius: 20px; padding: 28px 32px; box-shadow: 0 15px 50px rgba(46, 31, 34, 0.25); border: 1px solid rgba(184, 138, 68, 0.4); backdrop-filter: blur(10px);">
            <h4 style="text-align: center; color: #2E1F22; margin-bottom: 20px; font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700;">Check Availability</h4>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; align-items: flex-end;">
                <!-- Check-in Date -->
                <div>
                    <label style="display: block; font-weight: 700; color: #2E1F22; margin-bottom: 8px; font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Check-in</label>
                    <input type="date" style="width: 100%; padding: 12px 14px; background: #FFFFFF; border: 1.5px solid #D8CBB8; border-radius: 8px; font-family: var(--font-ui); color: #2E1F22; transition: all 0.3s ease; font-size: 14px;" onfocus="this.style.borderColor = '#6E2C3A'; this.style.boxShadow = '0 0 0 3px rgba(110, 44, 58, 0.1)';" onblur="this.style.borderColor = '#D8CBB8'; this.style.boxShadow = 'none';">
                </div>
                
                <!-- Check-out Date -->
                <div>
                    <label style="display: block; font-weight: 700; color: #2E1F22; margin-bottom: 8px; font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Check-out</label>
                    <input type="date" style="width: 100%; padding: 12px 14px; background: #FFFFFF; border: 1.5px solid #D8CBB8; border-radius: 8px; font-family: var(--font-ui); color: #2E1F22; transition: all 0.3s ease; font-size: 14px;" onfocus="this.style.borderColor = '#6E2C3A'; this.style.boxShadow = '0 0 0 3px rgba(110, 44, 58, 0.1)';" onblur="this.style.borderColor = '#D8CBB8'; this.style.boxShadow = 'none';">
                </div>
                
                <!-- Guests -->
                <div>
                    <label style="display: block; font-weight: 700; color: #2E1F22; margin-bottom: 8px; font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Guests</label>
                    <select style="width: 100%; padding: 12px 14px; background: #FFFFFF; border: 1.5px solid #D8CBB8; border-radius: 8px; font-family: var(--font-ui); color: #2E1F22; cursor: pointer; transition: all 0.3s ease; font-size: 14px;">
                        <option>1 Guest</option>
                        <option>2 Guests</option>
                        <option>3 Guests</option>
                        <option>4 Guests</option>
                        <option>5+ Guests</option>
                    </select>
                </div>
                
                <!-- Check Availability Button -->
                <div>
                    <button style="width: 100%; padding: 12px 24px; background: linear-gradient(135deg, #6E2C3A, #58222E); color: #F7F1E8; border: none; border-radius: 8px; font-weight: 700; font-family: var(--font-ui); font-size: 14px; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(110, 44, 58, 0.2);" onmouseover="this.style.transform = 'translateY(-2px)'; this.style.boxShadow = '0 8px 25px rgba(110, 44, 58, 0.35)';" onmouseout="this.style.transform = 'translateY(0)'; this.style.boxShadow = '0 4px 15px rgba(110, 44, 58, 0.2)';">
                        Check Availability
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Spacer for floating bar -->
<div style="height: 60px;"></div>

<!-- Welcome Section -->
<section style="background-color: var(--color-sandstone-base); padding: 60px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;">
            <div style="margin-bottom: 24px;">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500" alt="Hotel Lobby" style="border-radius: 8px; width: 100%; height: auto; box-shadow: var(--shadow-lg);">
            </div>
            <div>
                <span style="color: var(--color-brass-gold); font-family: var(--font-ui); font-weight: 600; font-size: 14px; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 16px;">Welcome</span>
                <h2 style="color: var(--color-charcoal-deep); margin-bottom: 24px;">Welcome to Hotel Rose Palace</h2>
                <p style="font-size: 16px; line-height: 1.8; color: var(--color-mauve-grey); margin-bottom: 16px;">
                    Nestled in the heart of Surat, Hotel Rose Palace offers an exquisite blend of modern comfort and timeless elegance. Whether you're visiting for business or leisure, our dedicated team ensures an unforgettable experience.
                </p>
                <p style="font-size: 16px; line-height: 1.8; color: var(--color-mauve-grey); margin-bottom: 32px;">
                    With premium amenities, spacious rooms, and personalized service, we pride ourselves on exceeding your expectations at every turn.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary">
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rooms Section -->
<section style="background-color: var(--color-sandstone-base); padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="color: var(--color-charcoal-deep); margin-bottom: 16px;">Our Room Categories</h2>
            <p style="color: var(--color-mauve-grey); font-size: 16px;">Choose from our carefully curated selection of rooms</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; margin-bottom: 48px;">
            @forelse($featuredRooms as $room)
                <div class="card">
                    @php
                        $roomImage = $room->featuredImage ? asset('storage/' . $room->featuredImage->image_path) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500';
                    @endphp
                    <div style="position: relative; height: 280px; overflow: hidden; border-radius: 12px 12px 0 0;">
                        <img src="{{ $roomImage }}" alt="{{ $room->roomType->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                    </div>
                    <div style="padding: 24px;">
                        <h4 style="color: var(--color-charcoal-deep); margin-bottom: 12px;">{{ $room->roomType->name }}</h4>
                        <p style="color: var(--color-mauve-grey); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">{{ Str::limit($room->roomType->description, 100) }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 20px; font-weight: 700; color: var(--color-brass-gold);">₹{{ number_format($room->current_price, 0) }}/night</span>
                            <a href="{{ route('room-detail', $room->roomType->slug) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0;">
                    <p style="color: var(--color-mauve-grey);">No rooms available at the moment.</p>
                </div>
            @endforelse
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('rooms') }}" class="btn btn-secondary">
                View All Rooms →
            </a>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section style="background-color: var(--color-beige); padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="color: var(--color-charcoal-deep); margin-bottom: 16px;">World-Class Amenities</h2>
            <p style="color: var(--color-mauve-grey); font-size: 16px;">Experience comfort and convenience with our premium facilities</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
            @forelse($amenities as $amenity)
                <div style="background-color: var(--color-champagne); border: 1px solid var(--color-border-subtle); border-radius: 12px; padding: 32px; text-align: center; transition: all 0.3s ease;">
                    <div style="font-size: 40px; color: var(--color-brass-gold); margin-bottom: 16px;">
                        <i class="fas fa-{{ $amenity->icon_class ?? 'star' }}"></i>
                    </div>
                    <h5 style="color: var(--color-charcoal-deep); font-family: var(--font-ui); font-weight: 600; margin-bottom: 12px;">{{ $amenity->name }}</h5>
                    <p style="color: var(--color-mauve-grey); font-size: 14px; margin: 0; line-height: 1.6;">{{ $amenity->description }}</p>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0;">
                    <p style="color: var(--color-mauve-grey);">No amenities to display.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Curated Experiences Section -->
<section style="background-color: var(--color-sandstone-base); padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="color: var(--color-charcoal-deep); margin-bottom: 16px;">Curated Experiences</h2>
            <p style="color: var(--color-mauve-grey); font-size: 16px;">Tailored packages designed for your unique journey</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 28px;">
            <!-- Corporate Stays -->
            <div class="card" style="transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); transform: translateY(0);" onmouseover="this.style.transform = 'translateY(-8px)'; this.style.boxShadow = 'var(--shadow-lg)';" onmouseout="this.style.transform = 'translateY(0)'; this.style.boxShadow = 'var(--shadow-sm)';">
                <div style="height: 200px; background: linear-gradient(135deg, rgba(110, 44, 58, 0.1), rgba(184, 138, 68, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i class="fas fa-briefcase" style="font-size: 48px; color: var(--color-brass-gold);"></i>
                </div>
                <h4 style="color: var(--color-charcoal-deep); margin-bottom: 12px;">Corporate Stays</h4>
                <p style="color: var(--color-mauve-grey); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Flexible check-in, dedicated business center, high-speed Wi-Fi, and executive lounge access — designed for productive business travelers.</p>
                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--color-border-subtle);">
                    <span style="font-weight: 600; color: var(--color-brass-gold);">From ₹4,999/night</span>
                    <a href="{{ route('contact') }}" style="color: var(--color-burgundy-rose); font-weight: 600; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color = 'var(--color-brass-gold)';" onmouseout="this.style.color = 'var(--color-burgundy-rose)';">Learn More →</a>
                </div>
            </div>

            <!-- Banquet & Events -->
            <div class="card" style="transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); transform: translateY(0);" onmouseover="this.style.transform = 'translateY(-8px)'; this.style.boxShadow = 'var(--shadow-lg)';" onmouseout="this.style.transform = 'translateY(0)'; this.style.boxShadow = 'var(--shadow-sm)';">
                <div style="height: 200px; background: linear-gradient(135deg, rgba(110, 44, 58, 0.1), rgba(184, 138, 68, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i class="fas fa-champagne-glasses" style="font-size: 48px; color: var(--color-brass-gold);"></i>
                </div>
                <h4 style="color: var(--color-charcoal-deep); margin-bottom: 12px;">Banquet & Events</h4>
                <p style="color: var(--color-mauve-grey); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Host unforgettable celebrations with our sophisticated venues, expert catering, and dedicated event planning team.</p>
                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--color-border-subtle);">
                    <span style="font-weight: 600; color: var(--color-brass-gold);">Customized Pricing</span>
                    <a href="{{ route('contact') }}" style="color: var(--color-burgundy-rose); font-weight: 600; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color = 'var(--color-brass-gold)';" onmouseout="this.style.color = 'var(--color-burgundy-rose)';">Enquire →</a>
                </div>
            </div>

            <!-- Weekend Packages -->
            <div class="card" style="transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); transform: translateY(0);" onmouseover="this.style.transform = 'translateY(-8px)'; this.style.boxShadow = 'var(--shadow-lg)';" onmouseout="this.style.transform = 'translateY(0)'; this.style.boxShadow = 'var(--shadow-sm)';">
                <div style="height: 200px; background: linear-gradient(135deg, rgba(110, 44, 58, 0.1), rgba(184, 138, 68, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i class="fas fa-heart" style="font-size: 48px; color: var(--color-brass-gold);"></i>
                </div>
                <h4 style="color: var(--color-charcoal-deep); margin-bottom: 12px;">Weekend Packages</h4>
                <p style="color: var(--color-mauve-grey); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Romantic getaways and rejuvenating retreats with spa credits, fine dining experiences, and exclusive weekend perks.</p>
                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--color-border-subtle);">
                    <span style="font-weight: 600; color: var(--color-brass-gold);">From ₹5,499/night</span>
                    <a href="{{ route('contact') }}" style="color: var(--color-burgundy-rose); font-weight: 600; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color = 'var(--color-brass-gold)';" onmouseout="this.style.color = 'var(--color-burgundy-rose)';">Book Now →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Preview Section -->
<section style="background-color: var(--color-sandstone-base); padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="color: var(--color-charcoal-deep); margin-bottom: 16px;">Gallery Highlights</h2>
            <p style="color: var(--color-mauve-grey); font-size: 16px;">Discover the beauty of Hotel Rose Palace</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-bottom: 48px;">
            @forelse($galleryImages as $image)
                <div style="position: relative; height: 250px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md); transition: transform 0.3s ease; cursor: pointer;">
                    @php
                        $galleryImage = $image->image_path ? asset('storage/' . $image->image_path) : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';
                    @endphp
                    <img src="{{ $galleryImage }}" alt="{{ $image->title ?? 'Gallery' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(46, 31, 34, 0.7), transparent); display: flex; align-items: flex-end; padding: 20px; opacity: 0; transition: opacity 0.3s ease;">
                        <h4 style="color: var(--color-champagne); margin: 0; font-family: var(--font-heading);">{{ $image->title ?? 'Gallery Image' }}</h4>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0;">
                    <p style="color: var(--color-mauve-grey);">No gallery images to display.</p>
                </div>
            @endforelse
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('gallery') }}" class="btn btn-primary">
                View Full Gallery
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section style="background-color: var(--color-sandstone-base); padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="color: var(--color-charcoal-deep); margin-bottom: 16px;">Guest Testimonials</h2>
            <p style="color: var(--color-mauve-grey); font-size: 16px;">What our guests say about their experience</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 28px;">
            <div class="card">
                <div style="margin-bottom: 12px; color: var(--color-brass-gold);">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p style="font-style: italic; color: var(--color-mauve-grey); line-height: 1.8; margin-bottom: 20px;">
                    "Hotel Rose Palace exceeded all my expectations. The staff was incredibly attentive and the rooms are absolutely beautiful. Highly recommended!"
                </p>
                <p style="font-weight: 600; margin: 0; color: var(--color-charcoal-deep);">
                    Sarah Johnson
                </p>
                <p style="font-size: 13px; color: var(--color-mauve-grey); margin: 0;">
                    New York, USA
                </p>
            </div>
            
            <div class="card">
                <div style="margin-bottom: 12px; color: var(--color-brass-gold);">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p style="font-style: italic; color: var(--color-mauve-grey); line-height: 1.8; margin-bottom: 20px;">
                    "A perfect blend of luxury and comfort. The restaurant serves amazing food, and the ambiance is just perfect for a relaxing getaway."
                </p>
                <p style="font-weight: 600; margin: 0; color: var(--color-charcoal-deep);">
                    Priya Patel
                </p>
                <p style="font-size: 13px; color: var(--color-mauve-grey); margin: 0;">
                    Mumbai, India
                </p>
            </div>
            
            <div class="card">
                <div style="margin-bottom: 12px; color: var(--color-brass-gold);">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p style="font-style: italic; color: var(--color-mauve-grey); line-height: 1.8; margin-bottom: 20px;">
                    "Outstanding service and exceptional hospitality. Every detail was taken care of perfectly. Can't wait to return!"
                </p>
                <p style="font-weight: 600; margin: 0; color: var(--color-charcoal-deep);">
                    David Chen
                </p>
                <p style="font-size: 13px; color: var(--color-mauve-grey); margin: 0;">
                    Singapore
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section style="background-color: var(--color-sandstone-base); padding: 60px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="color: var(--color-charcoal-deep); margin-bottom: 16px;">Our Location</h2>
            <p style="color: var(--color-mauve-grey); font-size: 16px;">Conveniently located in the heart of Surat</p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;">
            {{-- Interactive Google Maps Iframe --}}
            <div style="border: 1px solid var(--color-border-subtle); border-radius: 12px; overflow: hidden; min-height: 400px; box-shadow: var(--shadow-md);">
                <iframe class="w-100 h-100 border-0 rounded-3" style="min-height: 400px;" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=Hotel%20Rose%20Palace%20Atlanta%20Business%20Hub%20VIP%20Road%20Vesu%20Surat&t=&z=16&ie=UTF8&iwloc=&output=embed" allowfullscreen=""></iframe>
            </div>
            <div>
                <span style="color: var(--color-brass-gold); font-family: var(--font-ui); font-weight: 600; font-size: 14px; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 16px;">Location</span>
                <h4 style="color: var(--color-charcoal-deep); margin-bottom: 28px; font-family: var(--font-heading);">Hotel Rose Palace</h4>
                <p style="margin-bottom: 20px; color: var(--color-mauve-grey); line-height: 1.8;">
                    <i class="fas fa-map-marker-alt" style="color: var(--color-brass-gold); width: 24px; margin-right: 12px;"></i>
                    {{ config('hotel.location.address') }}
                </p>
                <p style="margin-bottom: 20px; color: var(--color-mauve-grey); line-height: 1.8;">
                    <i class="fas fa-phone" style="color: var(--color-brass-gold); width: 24px; margin-right: 12px;"></i>
                    <a href="tel:{{ config('hotel.contact.phone_1') }}" style="color: var(--color-brass-gold); text-decoration: none; transition: color 0.3s ease;">{{ config('hotel.contact.phone_1') }}</a>
                </p>
                <p style="margin-bottom: 20px; color: var(--color-mauve-grey); line-height: 1.8;">
                    <i class="fas fa-phone" style="color: var(--color-brass-gold); width: 24px; margin-right: 12px;"></i>
                    <a href="tel:{{ config('hotel.contact.phone_2') }}" style="color: var(--color-brass-gold); text-decoration: none; transition: color 0.3s ease;">{{ config('hotel.contact.phone_2') }}</a>
                </p>
                <p style="margin-bottom: 20px; color: var(--color-mauve-grey); line-height: 1.8;">
                    <i class="fas fa-envelope" style="color: var(--color-brass-gold); width: 24px; margin-right: 12px;"></i>
                    <a href="mailto:{{ config('hotel.contact.email') }}" style="color: var(--color-brass-gold); text-decoration: none; transition: color 0.3s ease;">{{ config('hotel.contact.email') }}</a>
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('contact') }}" class="btn btn-primary">
                        Get In Touch
                    </a>
                    <a href="{{ config('hotel.contact.google_maps', '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="background: #E2D5C3; border: 1px solid #D8CBB8; color: #6E2C3A;">
                        Open in Maps ↗
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extra_css')
<style>
/* Phase 5 Enhancements - Home Page */

/* Gold Gradient Dividers */
section {
    position: relative;
}

section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--color-brass-gold), transparent);
    border-radius: 2px;
}

section:first-of-type::before {
    display: none;
}

/* Card Hover Lift Animation */
.card {
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 16px 40px rgba(110, 44, 58, 0.15) !important;
    border-color: var(--color-brass-gold) !important;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Quick Availability Bar Animation */
div[style*="position: absolute; bottom: -80px"] {
    animation: slideUpAvail 0.8s ease 0.3s both;
}

@keyframes slideUpAvail {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

/* Amenity cards slight scale */
div[style*="background-color: var(--color-champagne); border: 1px solid var(--color-border-subtle); border-radius: 12px; padding: 32px; text-align: center;"] {
    transition: all 0.3s ease;
}

div[style*="background-color: var(--color-champagne); border: 1px solid var(--color-border-subtle); border-radius: 12px; padding: 32px; text-align: center;"]:hover {
    transform: scale(1.03) translateY(-4px);
    border-color: var(--color-brass-gold);
    box-shadow: 0 10px 30px rgba(184, 138, 68, 0.2);
}

/* Button hover effects */
.btn {
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(110, 44, 58, 0.25);
}

/* Text transitions */
a {
    transition: color 0.3s ease;
}
</style>
@endsection
