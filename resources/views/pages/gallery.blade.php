@extends('layouts.app')

@section('title', 'Gallery - Hotel Rose Palace')

@section('content')

<!-- Hero -->
<section class="hero" style="background: linear-gradient(rgba(26, 35, 50, 0.6), rgba(26, 35, 50, 0.6)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200') center/cover no-repeat;">
    <div class="container text-center text-white">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 56px; margin-bottom: 16px;">Our Gallery</h1>
        <p style="font-size: 24px; color: #d9a9a0;">Experience the beauty of Hotel Rose Palace</p>
    </div>
</section>

<!-- Gallery -->
<section>
    <div class="container">
        <div class="gallery-grid">
            @forelse($galleryImages as $image)
                <div class="gallery-item">
                    <img src="{{ $image->image_url }}" alt="{{ $image->title ?? 'Gallery' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div class="gallery-overlay">
                        <h4 style="color: #c9a961;">{{ $image->title ?? 'Gallery Image' }}</h4>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p style="color: #999;">No gallery images to display.</p>
                </div>
            @endforelse
        </div>

        @if($galleryImages->hasPages())
            <div style="margin-top: 40px; text-align: center;">
                {{ $galleryImages->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
