@extends('layouts.app')

@section('title', 'Rooms & Suites — Hotel Rose Palace | Luxury Accommodation Surat')
@section('meta_description', 'Explore luxury rooms and suites at Hotel Rose Palace Surat. Deluxe rooms, twin executive rooms, and royal suites with pure comfort, free high-speed Wi-Fi, and 24/7 service.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.4) 0%, rgba(46,31,34,0.85) 100%), url('{{ asset('images/hotel/hero-hd-2.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ Bespoke Living Spaces ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">Rooms & Royal Suites</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            A sanctuary of tranquility and refined taste in Vesu, Surat. Designed for restful nights, productive business days, and family comforts.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface);">Home</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; color: var(--hrp-gold);"></i>
            <span>Accommodations</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     FILTER & SORT TOOLBAR
═══════════════════════════════════════════════════════ --}}
<div style="background: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 16px 0; position: sticky; top: 72px; z-index: 100;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            
            {{-- Category Filter Pills --}}
            <div class="d-flex flex-wrap align-items-center gap-2" id="roomCategoryFilters">
                <button class="hrp-menu-tab-btn active" data-filter="all" onclick="filterRoomCards('all', this)">All Accommodations</button>
                @foreach($roomTypes as $filterType)
                    <button class="hrp-menu-tab-btn" data-filter="{{ $filterType->slug }}" onclick="filterRoomCards('{{ $filterType->slug }}', this)">
                        {{ $filterType->name }}
                    </button>
                @endforeach
                <button type="button" class="btn btn-outline-secondary btn-sm ms-md-2" onclick="clearAllRoomFilters()">
                    <i class="fas fa-rotate-left me-1"></i> Clear Filters
                </button>
            </div>

            {{-- Price Sort Dropdown & Quick Rates --}}
            <div class="d-flex align-items-center gap-2">
                <label for="priceSortSelect" style="font-size: 13px; font-weight: 600; color: var(--hrp-plum); white-space: nowrap;">Sort by:</label>
                <select id="priceSortSelect" class="hrp-field-input" style="padding: 6px 12px; font-size: 13px; width: auto; cursor: pointer;" onchange="sortRoomCards(this.value)">
                    <option value="recommended">Featured / Recommended</option>
                    <option value="low-to-high">Price: Low to High</option>
                    <option value="high-to-low">Price: High to Low</option>
                </select>
                <a href="{{ route('booking.search.form') }}" class="btn btn-primary btn-sm d-none d-md-inline-flex" style="padding: 7px 16px; text-decoration: none;">
                    <i class="fas fa-calculator"></i> Check Rates
                </a>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     ROOMS LISTING GRID (2-COLUMN CARDS WITH MULTI-PHOTO GALLERY)
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 50px 0;">
    <div class="container">

        <div class="row g-4" id="roomsContainer">
            @forelse($roomTypes as $roomType)
            @php
                $photos = $roomType->getGalleryPhotos();
                $photoCount = count($photos);
                $basePrice = (float) $roomType->base_price;
                $gst12 = round($basePrice * 0.12, 2);
                $totalIndicative = $basePrice + $gst12;
                $physicalCount = $roomType->rooms ? $roomType->rooms->count() : 0;
            @endphp
            <div class="col-lg-6 room-card-item" data-category="{{ $roomType->slug }}" data-price="{{ $basePrice }}">
                <div class="card p-0 overflow-hidden shadow-sm h-100" style="border: 1px solid var(--hrp-border); border-radius: 12px; background: #fff; display: flex; flex-direction: column;">
                    
                    {{-- ── MULTI-PHOTO GALLERY CAROUSEL ── --}}
                    <div class="hrp-room-gallery-wrap position-relative overflow-hidden" id="gallery-wrap-{{ $roomType->id }}" data-room-id="{{ $roomType->id }}" data-total-slides="{{ $photoCount }}">
                        
                        {{-- Main Slide Viewport (16:10 aspect ratio) --}}
                        <div class="position-relative overflow-hidden" style="aspect-ratio: 16 / 10; background: #2E1F22;">
                            @foreach($photos as $pIdx => $photo)
                                <div class="hrp-room-slide position-absolute inset-0 w-100 h-100 {{ $pIdx === 0 ? 'active' : '' }}" 
                                     id="slide-{{ $roomType->id }}-{{ $pIdx }}"
                                     data-index="{{ $pIdx }}"
                                     style="opacity: {{ $pIdx === 0 ? '1' : '0' }}; transition: opacity 0.35s ease; z-index: {{ $pIdx === 0 ? '2' : '1' }};">
                                    <img src="{{ $photo['url'] }}" 
                                         alt="{{ $photo['title'] }}" 
                                         class="w-100 h-100 hrp-room-img hrp-gallery-img-{{ $roomType->id }}" 
                                         data-full="{{ $photo['url'] }}"
                                         style="object-fit: cover; object-position: center; cursor: pointer;" 
                                         loading="{{ $pIdx === 0 ? 'eager' : 'lazy' }}"
                                         onclick="openLightbox('{{ $photo['url'] }}', '.hrp-gallery-img-{{ $roomType->id }}')">
                                </div>
                            @endforeach

                            {{-- Top Badges: Category (Left) & Photo Counter (Right) --}}
                            <div class="position-absolute top-0 start-0 m-3 d-flex gap-2" style="z-index: 5; pointer-events: none;">
                                <span class="badge shadow-sm" style="background: rgba(110,44,58,0.92); color: #F7F1E8; padding: 6px 12px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $roomType->name }}
                                </span>
                            </div>
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 5; pointer-events: none;">
                                <span class="badge shadow-sm" style="background: rgba(46,31,34,0.85); color: #F7F1E8; border: 1px solid rgba(184,138,68,0.4); padding: 5px 11px; font-size: 11px;">
                                    <i class="fas fa-camera text-gold me-1"></i> <span id="counter-{{ $roomType->id }}">1</span> / {{ $photoCount }}
                                </span>
                            </div>

                            {{-- Carousel Navigation Controls --}}
                            @if($photoCount > 1)
                                <button type="button" 
                                        class="hrp-carousel-arrow hrp-carousel-prev" 
                                        onclick="prevRoomSlide({{ $roomType->id }}, {{ $photoCount }})" 
                                        aria-label="Previous Photo" 
                                        title="Previous Photo">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" 
                                        class="hrp-carousel-arrow hrp-carousel-next" 
                                        onclick="nextRoomSlide({{ $roomType->id }}, {{ $photoCount }})" 
                                        aria-label="Next Photo" 
                                        title="Next Photo">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif

                            {{-- Fullscreen Expand Trigger Button --}}
                            <button type="button" 
                                    class="hrp-fullscreen-btn" 
                                    onclick="openActiveSlideLightbox({{ $roomType->id }})" 
                                    aria-label="View Fullscreen" 
                                    title="View Fullscreen">
                                <i class="fas fa-expand"></i>
                            </button>

                            {{-- Bottom Right Price Badge --}}
                            <div class="position-absolute bottom-0 end-0 m-3 shadow-sm" style="background: rgba(46,31,34,0.92); backdrop-filter: blur(8px); padding: 8px 16px; border-radius: 8px; border: 1px solid var(--hrp-gold); text-align: right; z-index: 5;">
                                <span style="font-size: 10px; color: var(--hrp-tint); text-transform: uppercase; display: block; letter-spacing: 0.5px;">Starting From</span>
                                <span style="font-size: 22px; font-weight: 700; color: var(--hrp-gold-light); line-height: 1;">₹{{ number_format($basePrice, 0) }}</span>
                                <span style="font-size: 11px; color: var(--hrp-surface);">/ night</span>
                            </div>
                        </div>

                        {{-- Clickable Interactive Thumbnails Row --}}
                        <div class="hrp-thumbnails-strip p-2 d-flex gap-2 overflow-auto" id="thumbs-{{ $roomType->id }}" style="background: var(--hrp-tint); border-top: 1px solid var(--hrp-border);">
                            @foreach($photos as $pIdx => $photo)
                                <img src="{{ $photo['url'] }}" 
                                     alt="Thumbnail {{ $pIdx + 1 }}" 
                                     class="hrp-card-thumb {{ $pIdx === 0 ? 'active' : '' }}" 
                                     id="thumb-{{ $roomType->id }}-{{ $pIdx }}"
                                     onclick="setRoomSlide({{ $roomType->id }}, {{ $pIdx }}, {{ $photoCount }})"
                                     title="{{ $photo['title'] }}"
                                     style="width: 58px; height: 42px; object-fit: cover; border-radius: 4px; cursor: pointer; flex-shrink: 0; border: 2px solid {{ $pIdx === 0 ? 'var(--hrp-gold)' : 'transparent' }}; opacity: {{ $pIdx === 0 ? '1' : '0.65' }}; transition: all 0.2s ease;"
                                     loading="lazy">
                            @endforeach
                        </div>
                    </div>

                    {{-- ── ROOM DETAILS BODY ── --}}
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 style="font-size: 22px; color: var(--hrp-plum); margin: 0;">
                                <a href="{{ route('room-detail', $roomType->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $roomType->name }}
                                </a>
                            </h3>
                        </div>

                        {{-- Verified Hospitality Specifications Ribbon --}}
                        <div class="d-flex flex-wrap gap-2 mb-3 pb-2" style="border-bottom: 1px solid var(--hrp-border); font-size: 12px; color: var(--hrp-mauve);">
                            <span class="badge bg-light text-dark border"><i class="fas fa-user-friends text-gold me-1"></i> Up to {{ $roomType->max_occupancy }} Guests</span>
                            @if(!empty($roomType->bed_type))
                                <span class="badge bg-light text-dark border"><i class="fas fa-bed text-gold me-1"></i> {{ $roomType->bed_type }}</span>
                            @endif
                            @if($roomType->size_sqft > 0)
                                <span class="badge bg-light text-dark border"><i class="fas fa-vector-square text-gold me-1"></i> {{ $roomType->size_sqft }} sq.ft</span>
                            @endif
                            @if(!empty($roomType->view_type))
                                <span class="badge bg-light text-dark border"><i class="fas fa-eye text-gold me-1"></i> {{ $roomType->view_type }}</span>
                            @endif
                            @if($roomType->bedroom_count > 0)
                                <span class="badge bg-light text-dark border"><i class="fas fa-door-open text-gold me-1"></i> {{ $roomType->bedroom_count }} {{ Str::plural('Bed', $roomType->bedroom_count) }}</span>
                            @endif
                            @if($roomType->bathroom_count > 0)
                                <span class="badge bg-light text-dark border"><i class="fas fa-bath text-gold me-1"></i> {{ $roomType->bathroom_count }} {{ Str::plural('Bath', $roomType->bathroom_count) }}</span>
                            @endif
                        </div>

                        {{-- Room Description --}}
                        <p style="font-size: 14px; color: var(--hrp-mauve); line-height: 1.7; margin-bottom: 16px; flex-grow: 1;">
                            {{ $roomType->description }}
                        </p>

                        {{-- Verified Amenities Grid --}}
                        @if($roomType->amenities && $roomType->amenities->count() > 0)
                        <div class="row g-2 mb-3" style="font-size: 12px; color: var(--hrp-plum);">
                            @foreach($roomType->amenities->take(6) as $amenity)
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-gold" style="font-size: 11px;"></i>
                                <span>{{ $amenity->name }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Transparent 12% GST Itemized Box --}}
                        <div class="p-2 mb-3 rounded text-start" style="background-color: var(--hrp-tint); border: 1px solid var(--hrp-border); font-size: 11.5px;">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Base Tariff:</span>
                                <span class="fw-semibold">₹{{ number_format($basePrice, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">GST (12%):</span>
                                <span class="fw-semibold">₹{{ number_format($gst12, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-1 border-top" style="border-color: var(--hrp-border) !important;">
                                <span class="fw-bold" style="color: var(--hrp-plum);">Total Indicative:</span>
                                <span class="fw-bold text-gold">₹{{ number_format($totalIndicative, 2) }}</span>
                            </div>
                            <div class="text-muted text-center mt-1" style="font-size: 10px;">
                                Per room, per night. Instant confirmation via Razorpay.
                            </div>
                        </div>

                        {{-- Physical Room Inventory Badge --}}
                        <div class="d-flex align-items-center justify-content-between p-2 mb-3 rounded" style="background: rgba(110,44,58,0.05); border: 1px dashed var(--hrp-border);">
                            <span style="font-size: 12px; color: var(--hrp-burgundy); font-weight: 600;">
                                <i class="fas fa-door-open me-1"></i> {{ $physicalCount }} Physical Rooms in Inventory
                            </span>
                            <span class="badge" style="background: var(--hrp-burgundy); color: #fff; font-size: 11px;">
                                {{ $roomType->slug === 'deluxe-family-room' ? 'Rooms 101–105' : 'Rooms 106–115' }}
                            </span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 flex-wrap pt-3 mt-auto" style="border-top: 1px solid var(--hrp-border);">
                            <button type="button" 
                                    class="btn flex-grow-1 text-white" 
                                    style="background-color: var(--hrp-burgundy); border: none;"
                                    onclick="focusPhysicalRooms('{{ $roomType->slug }}')"
                                    title="View Individual Physical Rooms">
                                <i class="fas fa-th-large me-1"></i> View Rooms ({{ $physicalCount }})
                            </button>
                            <a href="{{ route('booking.search.form') }}" class="btn btn-primary" style="text-decoration: none;">
                                <i class="fas fa-calendar-check me-1"></i> Book Now
                            </a>
                            <a href="{{ route('room-detail', $roomType->slug) }}" class="btn btn-secondary" style="text-decoration: none;">
                                <i class="fas fa-info-circle me-1"></i> Details
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to inquire about booking the ' . $roomType->name) }}" target="_blank" class="btn btn-whatsapp" aria-label="Ask on WhatsApp" title="Ask on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No rooms currently available in the catalogue.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     INDIVIDUAL PHYSICAL ROOMS INVENTORY (15 ROOMS)
═══════════════════════════════════════════════════════ --}}
<section id="physical-rooms-section" style="background-color: var(--hrp-surface); padding: 60px 0; border-top: 1px solid var(--hrp-border);">
    <div class="container">
        
        {{-- Section Header --}}
        <div class="text-center mb-4">
            <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-size: 12px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase;">
                ✦ Verified Physical Inventory ✦
            </span>
            <h2 style="color: var(--hrp-plum); font-size: 34px; margin-top: 6px; margin-bottom: 10px;">
                Individual Physical Rooms (15 Rooms)
            </h2>
            <p style="color: var(--hrp-mauve); font-size: 15px; max-width: 720px; margin: 0 auto 24px; line-height: 1.6;">
                Hotel Rose Palace operates 15 physical rooms across two distinguished categories. Browse authentic photography for each room below.
            </p>

            {{-- Category Filter Pills --}}
            <div class="d-inline-flex flex-wrap justify-content-center gap-2 p-1 rounded-pill" style="background: var(--hrp-tint); border: 1px solid var(--hrp-border);" id="physicalRoomFilterGroup">
                <button type="button" class="btn btn-sm rounded-pill px-3 hrp-phys-tab active" data-filter="all" onclick="filterPhysicalRooms('all', this)" style="font-weight: 600; font-size: 13px;">
                    All Rooms (15)
                </button>
                <button type="button" class="btn btn-sm rounded-pill px-3 hrp-phys-tab" data-filter="deluxe-family-room" onclick="filterPhysicalRooms('deluxe-family-room', this)" style="font-weight: 600; font-size: 13px;">
                    Deluxe Family (Rooms 101–105)
                </button>
                <button type="button" class="btn btn-sm rounded-pill px-3 hrp-phys-tab" data-filter="executive-room" onclick="filterPhysicalRooms('executive-room', this)" style="font-weight: 600; font-size: 13px;">
                    Executive Rooms (Rooms 106–115)
                </button>
            </div>
        </div>

        {{-- 15 Physical Rooms Grid --}}
        @php
            $allPhysicalRooms = $roomTypes->flatMap->rooms->sortBy('room_number');
        @endphp

        <div class="row g-4" id="physicalRoomsContainer">
            @foreach($allPhysicalRooms as $pRoom)
            @php
                $parentType = $pRoom->roomType;
                $isDeluxe = $parentType && ($parentType->slug === 'deluxe-family-room');
                $catSlug = $parentType ? $parentType->slug : ($isDeluxe ? 'deluxe-family-room' : 'executive-room');
                $price = (float) ($pRoom->current_price ?: ($parentType ? $parentType->base_price : ($isDeluxe ? 1200 : 1100)));
                $gst = round($price * 0.12, 2);
                $imgPath = $pRoom->image_path ?: ($isDeluxe ? 'images/rooms/deluxe.jpg' : 'images/rooms/executive.jpg');
                $imgUrl = asset($imgPath);
            @endphp
            <div class="col-lg-4 col-md-6 col-12 physical-room-card" data-category="{{ $catSlug }}">
                <div class="card p-0 overflow-hidden shadow-sm h-100" style="border: 1px solid var(--hrp-border); border-radius: 10px; background: #fff;">
                    
                    {{-- Room Photograph --}}
                    <div class="position-relative overflow-hidden" style="aspect-ratio: 16 / 11; background: #2E1F22;">
                        <img src="{{ $imgUrl }}" 
                             alt="Hotel Rose Palace Room {{ $pRoom->room_number }}" 
                             class="w-100 h-100 hrp-phys-img" 
                             style="object-fit: cover; cursor: pointer; transition: transform 0.3s ease;"
                             loading="lazy"
                             onclick="openLightbox('{{ $imgUrl }}', '.hrp-phys-img')">

                        {{-- Room Number Badge (Top Left) --}}
                        <div class="position-absolute top-0 start-0 m-3" style="z-index: 2;">
                            <span class="badge shadow-sm" style="background: rgba(110,44,58,0.92); color: #F7F1E8; padding: 6px 12px; font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">
                                Room {{ $pRoom->room_number }}
                            </span>
                        </div>

                        {{-- Expand Lightbox Button (Bottom Right) --}}
                        <button type="button" 
                                class="hrp-fullscreen-btn" 
                                onclick="openLightbox('{{ $imgUrl }}', '.hrp-phys-img')" 
                                aria-label="Inspect Room Photo" 
                                title="Inspect Room Photo">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge" style="background: rgba(184,138,68,0.15); color: #B88A44; border: 1px solid rgba(184,138,68,0.3); font-size: 11px;">
                                    {{ $parentType ? $parentType->name : ($isDeluxe ? 'Deluxe Family Room' : 'Executive Room') }}
                                </span>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 11px;">
                                <i class="fas fa-check-circle me-1"></i> Ready for Guests
                            </span>
                        </div>

                        <h4 style="font-size: 18px; color: var(--hrp-plum); margin: 4px 0 8px;">
                            Room {{ $pRoom->room_number }} — {{ $isDeluxe ? 'Family Sanctuary' : 'Executive Space' }}
                        </h4>

                        <div class="d-flex flex-wrap gap-2 mb-3" style="font-size: 11.5px; color: var(--hrp-mauve);">
                            <span class="badge bg-light text-dark border"><i class="fas fa-user-friends text-gold me-1"></i> Up to 3 Guests</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-bed text-gold me-1"></i> {{ $isDeluxe ? 'King Bed' : 'Twin Beds' }}</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-eye text-gold me-1"></i> City View</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-wifi text-gold me-1"></i> Free Wi-Fi</span>
                        </div>

                        {{-- Pricing and Action --}}
                        <div class="d-flex justify-content-between align-items-center pt-2 mt-auto" style="border-top: 1px solid var(--hrp-border);">
                            <div>
                                <div style="font-size: 11px; color: var(--hrp-mauve); text-transform: uppercase;">Per Night</div>
                                <div style="font-size: 20px; font-weight: 700; color: var(--hrp-burgundy); line-height: 1;">
                                    ₹{{ number_format($price, 0) }}
                                    <small style="font-size: 10px; font-weight: normal; color: var(--hrp-mauve);">+ 12% GST</small>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('booking.search.form') }}" class="btn btn-primary btn-sm px-3" style="text-decoration: none;">
                                    <i class="fas fa-calendar-check me-1"></i> Book
                                </a>
                                @if($parentType)
                                <a href="{{ route('room-detail', $parentType->slug) }}" class="btn btn-outline-secondary btn-sm" title="View Category">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STANDARD INCLUSIONS BANNER (VERIFIED AMENITIES)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-surface); padding: 50px 0;">
    <div class="container text-center">
        <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 12px; letter-spacing: 2px; text-transform: uppercase;">✦ The Rose Palace Guarantee ✦</span>
        <h3 style="color: var(--hrp-plum); margin: 6px 0 28px;">Standard with Every Reservation</h3>

        <div class="row g-3 justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-wifi text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">High-Speed Wi-Fi</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Dedicated Wi-Fi connection throughout the property.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-snowflake text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Air Conditioning & TV</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Individual climate control and satellite television in every room.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-clock text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Standard Timings</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Check-in: 12:00 PM | Check-out: 11:00 AM.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-concierge-bell text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">24-Hour Front Desk</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Dedicated front desk and room service assistance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ── Multi-Photo Carousel Styles ── */
.hrp-carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(46, 31, 34, 0.75);
    backdrop-filter: blur(4px);
    color: #F7F1E8;
    border: 1px solid rgba(184, 138, 68, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 6;
    transition: all 0.25s ease;
    font-size: 14px;
}
.hrp-carousel-arrow:hover {
    background: rgba(110, 44, 58, 0.95);
    border-color: var(--hrp-gold);
    color: #fff;
    transform: translateY(-50%) scale(1.08);
}
.hrp-carousel-prev { left: 12px; }
.hrp-carousel-next { right: 12px; }

.hrp-fullscreen-btn {
    position: absolute;
    bottom: 12px;
    left: 12px;
    width: 34px;
    height: 34px;
    border-radius: 6px;
    background: rgba(46, 31, 34, 0.75);
    backdrop-filter: blur(4px);
    color: #F7F1E8;
    border: 1px solid rgba(184, 138, 68, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 6;
    transition: all 0.2s ease;
    font-size: 13px;
}
.hrp-fullscreen-btn:hover {
    background: rgba(110, 44, 58, 0.95);
    color: #fff;
    transform: scale(1.06);
}

.hrp-card-thumb:hover {
    opacity: 0.9 !important;
}

.hrp-thumbnails-strip::-webkit-scrollbar {
    height: 4px;
}
.hrp-thumbnails-strip::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
}
.hrp-thumbnails-strip::-webkit-scrollbar-thumb {
    background: var(--hrp-gold);
    border-radius: 4px;
}

.hrp-phys-tab {
    background: transparent;
    color: var(--hrp-plum);
    border: none;
    transition: all 0.2s ease;
}
.hrp-phys-tab.active {
    background: var(--hrp-burgundy);
    color: #fff;
    box-shadow: 0 2px 6px rgba(110, 44, 58, 0.25);
}
.hrp-phys-tab:hover:not(.active) {
    background: rgba(110, 44, 58, 0.08);
    color: var(--hrp-burgundy);
}

.physical-room-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.physical-room-card:hover {
    transform: translateY(-4px);
}
.physical-room-card:hover img.hrp-phys-img {
    transform: scale(1.04);
}
</style>

<script>
// ── Multi-Photo Carousel Controls ──
function getRoomCurrentSlide(roomId) {
    const activeSlide = document.querySelector(`#gallery-wrap-${roomId} .hrp-room-slide.active`);
    return activeSlide ? parseInt(activeSlide.getAttribute('data-index'), 10) : 0;
}

function setRoomSlide(roomId, newIdx, totalCount) {
    // Hide all slides
    const slides = document.querySelectorAll(`#gallery-wrap-${roomId} .hrp-room-slide`);
    slides.forEach((s, idx) => {
        if (idx === newIdx) {
            s.classList.add('active');
            s.style.opacity = '1';
            s.style.zIndex = '2';
        } else {
            s.classList.remove('active');
            s.style.opacity = '0';
            s.style.zIndex = '1';
        }
    });

    // Update thumbnail highlights & scroll into view
    const thumbs = document.querySelectorAll(`#thumbs-${roomId} .hrp-card-thumb`);
    thumbs.forEach((t, idx) => {
        if (idx === newIdx) {
            t.classList.add('active');
            t.style.border = '2px solid var(--hrp-gold)';
            t.style.opacity = '1';
        } else {
            t.classList.remove('active');
            t.style.border = '2px solid transparent';
            t.style.opacity = '0.65';
        }
    });

    const nextThumb = document.getElementById(`thumb-${roomId}-${newIdx}`);
    if (nextThumb) {
        const strip = document.getElementById(`thumbs-${roomId}`);
        if (strip) {
            const thumbLeft = nextThumb.offsetLeft;
            const thumbWidth = nextThumb.offsetWidth;
            const stripWidth = strip.clientWidth;
            strip.scrollTo({
                left: thumbLeft - (stripWidth / 2) + (thumbWidth / 2),
                behavior: 'smooth'
            });
        }
    }

    // Update counter display
    const counter = document.getElementById(`counter-${roomId}`);
    if (counter) {
        counter.textContent = newIdx + 1;
    }
}

function prevRoomSlide(roomId, totalCount) {
    const cur = getRoomCurrentSlide(roomId);
    const prev = (cur - 1 + totalCount) % totalCount;
    setRoomSlide(roomId, prev, totalCount);
}

function nextRoomSlide(roomId, totalCount) {
    const cur = getRoomCurrentSlide(roomId);
    const next = (cur + 1) % totalCount;
    setRoomSlide(roomId, next, totalCount);
}

function openActiveSlideLightbox(roomId) {
    const activeIdx = getRoomCurrentSlide(roomId);
    const activeImg = document.querySelector(`#slide-${roomId}-${activeIdx} img`);
    if (activeImg) {
        openLightbox(activeImg.src, `.hrp-gallery-img-${roomId}`);
    }
}

// Category filter for top 2-column cards
function filterRoomCards(category, btn) {
    document.querySelectorAll('#roomCategoryFilters button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const items = document.querySelectorAll('.room-card-item');
    items.forEach(item => {
        if (category === 'all' || item.getAttribute('data-category') === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Focus on physical rooms for a specific category
function focusPhysicalRooms(categorySlug) {
    const targetFilter = document.querySelector(`#physicalRoomFilterGroup button[data-filter="${categorySlug}"]`);
    if (targetFilter) {
        filterPhysicalRooms(categorySlug, targetFilter);
    }
    const sec = document.getElementById('physical-rooms-section');
    if (sec) {
        sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Filter 15 physical rooms
function filterPhysicalRooms(category, btn) {
    document.querySelectorAll('#physicalRoomFilterGroup button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const cards = document.querySelectorAll('.physical-room-card');
    cards.forEach(card => {
        if (category === 'all' || card.getAttribute('data-category') === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Clear all filters
function clearAllRoomFilters() {
    document.querySelectorAll('#roomCategoryFilters button').forEach(b => b.classList.remove('active'));
    const allBtn = document.querySelector('#roomCategoryFilters button[data-filter="all"]');
    if (allBtn) allBtn.classList.add('active');

    document.querySelectorAll('.room-card-item').forEach(item => {
        item.style.display = 'block';
    });

    const sortSelect = document.getElementById('priceSortSelect');
    if (sortSelect) {
        sortSelect.value = 'recommended';
        sortRoomCards('recommended');
    }
}

// Price sorting
function sortRoomCards(criteria) {
    const container = document.getElementById('roomsContainer');
    const items = Array.from(document.querySelectorAll('.room-card-item'));

    if (criteria === 'low-to-high') {
        items.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
    } else if (criteria === 'high-to-low') {
        items.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
    } else {
        // Default order
        return;
    }

    items.forEach(item => container.appendChild(item));
}
</script>

@endsection
