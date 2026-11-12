@extends('layouts.app')

@section('title', 'Amenities - Hotel Rose Palace')

@section('content')

<!-- Hero -->
<section class="hero" style="background: linear-gradient(rgba(26, 35, 50, 0.6), rgba(26, 35, 50, 0.6)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat;">
    <div class="container text-center text-white">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px;">Our Amenities</h1>
        <p style="font-size: 24px; color: #d9a9a0;">Premium facilities for your comfort</p>
    </div>
</section>

<!-- Amenities -->
<section>
    <div class="container">
        @forelse($amenities as $category => $categoryAmenities)
            <div class="mb-5" style="margin-bottom: 60px;">
                <h3 style="color: #1a2332; margin-bottom: 32px;">{{ $category ?? 'General Amenities' }}</h3>
                <div class="row g-4">
                    @foreach($categoryAmenities as $amenity)
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center p-4">
                                    <div style="font-size: 50px; color: #c9a961; margin-bottom: 16px;">
                                        <i class="fas fa-{{ $amenity->icon_class ?? 'star' }}"></i>
                                    </div>
                                    <h5 style="color: #1a2332; margin-bottom: 12px;">{{ $amenity->name }}</h5>
                                    <p style="color: #666; font-size: 14px;">{{ $amenity->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <p style="color: #999;">No amenities to display.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection
