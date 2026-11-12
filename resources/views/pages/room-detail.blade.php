@extends('layouts.app')

@section('title', $roomType->name . ' - Hotel Rose Palace')

@section('content')

<!-- Breadcrumb -->
<section style="background-color: #f5f3f0; padding: 16px 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="margin: 0;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rooms') }}">Rooms</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $roomType->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Room Details -->
<section>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800" alt="{{ $roomType->name }}" style="border-radius: 8px; width: 100%; margin-bottom: 16px;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300" alt="Room" style="border-radius: 4px; width: 100%; height: 80px; object-fit: cover;">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300" alt="Room" style="border-radius: 4px; width: 100%; height: 80px; object-fit: cover;">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300" alt="Room" style="border-radius: 4px; width: 100%; height: 80px; object-fit: cover;">
                </div>
            </div>

            <div class="col-md-6 ps-md-4">
                <h1 style="color: #1a2332; margin-bottom: 16px;">{{ $roomType->name }}</h1>
                
                <div style="background-color: #f5f3f0; padding: 20px; border-radius: 8px; margin-bottom: 24px;">
                    <div class="row text-center">
                        <div class="col-4">
                            <p style="color: #999; font-size: 12px; margin-bottom: 8px;">PRICE PER NIGHT</p>
                            <p style="color: #c9a961; font-size: 32px; font-weight: 700; margin: 0;">₹{{ number_format($roomType->base_price, 0) }}</p>
                        </div>
                        <div class="col-4">
                            <p style="color: #999; font-size: 12px; margin-bottom: 8px;">MAX GUESTS</p>
                            <p style="color: #1a2332; font-size: 32px; font-weight: 700; margin: 0;">{{ $roomType->max_occupancy }}</p>
                        </div>
                        <div class="col-4">
                            <p style="color: #999; font-size: 12px; margin-bottom: 8px;">AVAILABLE ROOMS</p>
                            <p style="color: #1a2332; font-size: 32px; font-weight: 700; margin: 0;">{{ count($rooms) }}</p>
                        </div>
                    </div>
                </div>

                <h5 style="color: #1a2332; margin-bottom: 16px; font-family: 'Poppins', sans-serif;">Description</h5>
                <p style="color: #666; line-height: 1.8; margin-bottom: 24px;">{{ $roomType->description }}</p>

                <h5 style="color: #1a2332; margin-bottom: 16px; font-family: 'Poppins', sans-serif;">Room Amenities</h5>
                <ul style="list-style: none; padding: 0; margin-bottom: 24px;">
                    @foreach($roomType->amenities as $amenity)
                        <li style="margin-bottom: 12px; color: #666;">
                            <i class="fas fa-check" style="color: #c9a961; margin-right: 8px;"></i>
                            {{ $amenity->name }}
                        </li>
                    @endforeach
                </ul>

                <a href="https://wa.me/{{ str_replace([' ', '+'], '', config('hotel.contact.whatsapp_number')) }}?text=I%20would%20like%20to%20enquire%20about%20{{ urlencode($roomType->name) }}" target="_blank" class="btn btn-primary btn-lg w-100">
                    <i class="fab fa-whatsapp"></i> Enquire on WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Enquiry Form Section -->
<section class="bg-ivory">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 style="color: #1a2332; text-align: center; margin-bottom: 32px;">Check Availability</h3>
                
                <form method="POST" action="#" style="background-color: white; padding: 32px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    @csrf

                    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                    <div class="form-group mb-4">
                        <label for="check_in">Check-in Date <span class="required" style="color: #e74c3c;">*</span></label>
                        <input type="date" id="check_in" name="check_in_date" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="check_out">Check-out Date <span class="required" style="color: #e74c3c;">*</span></label>
                        <input type="date" id="check_out" name="check_out_date" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label for="adults">Adults <span class="required" style="color: #e74c3c;">*</span></label>
                                <select id="adults" name="num_adults" class="form-control" required>
                                    @for($i = 1; $i <= $roomType->max_adults; $i++)
                                        <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label for="children">Children</label>
                                <select id="children" name="num_children" class="form-control">
                                    @for($i = 0; $i <= $roomType->max_children; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="name">Your Name <span class="required" style="color: #e74c3c;">*</span></label>
                        <input type="text" id="name" name="customer_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="phone">Phone Number <span class="required" style="color: #e74c3c;">*</span></label>
                        <input type="tel" id="phone" name="customer_phone" class="form-control" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="customer_email" class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label for="requests">Special Requests</label>
                        <textarea id="requests" name="special_requests" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Enquiry via WhatsApp</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
