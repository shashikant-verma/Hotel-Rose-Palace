@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="h2 mb-4 text-center">Direct Room Booking</h1>
                    <p class="text-muted text-center mb-4">
                        Search for available rooms and complete your booking in minutes
                    </p>

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">Booking Error</h6>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="searchForm" class="needs-validation">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label fw-semibold">Check-in Date</label>
                                <input 
                                    type="date" 
                                    class="form-control form-control-lg"
                                    id="check_in"
                                    name="check_in"
                                    required
                                    min="{{ now()->format('Y-m-d') }}"
                                >
                                <small class="form-text text-muted">Select arrival date</small>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label fw-semibold">Check-out Date</label>
                                <input 
                                    type="date" 
                                    class="form-control form-control-lg"
                                    id="check_out"
                                    name="check_out"
                                    required
                                >
                                <small class="form-text text-muted">Select departure date</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="room_type_id" class="form-label fw-semibold">Room Category</label>
                                <select class="form-select form-select-lg" id="room_type_id" name="room_type_id" required>
                                    <option value="">-- Select Room Type --</option>
                                    @foreach (\App\Models\RoomType::where('is_active', true)->get() as $roomType)
                                        <option value="{{ $roomType->id }}">
                                            {{ $roomType->name }} - ₹{{ number_format($roomType->base_price) }}/night
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Choose your preferred room category</small>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label fw-semibold">Number of Rooms</label>
                                <input 
                                    type="number" 
                                    class="form-control form-control-lg"
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="10"
                                    required
                                >
                                <small class="form-text text-muted">How many rooms do you need?</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                            <i class="fas fa-search"></i> Search Availability
                        </button>
                    </form>
                </div>
            </div>

            <!-- Availability Results (hidden until search) -->
            <div id="resultsContainer" class="mt-4" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Availability & Pricing</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">Dates</small>
                                <p class="mb-0"><strong id="resultDates"></strong></p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Nights</small>
                                <p class="mb-0"><strong id="resultNights"></strong></p>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <strong id="availabilityStatus"></strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm mb-3">
                                <tbody>
                                    <tr>
                                        <td>Price per night:</td>
                                        <td class="text-end"><strong id="pricePerNight"></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td class="text-end"><strong id="subtotal"></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tax (12%):</td>
                                        <td class="text-end"><strong id="taxAmount"></strong></td>
                                    </tr>
                                    <tr class="table-active">
                                        <td><strong>Total:</strong></td>
                                        <td class="text-end"><strong id="grandTotal" style="font-size: 1.2em;"></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="#" id="proceedBtn" class="btn btn-success btn-lg w-100 fw-semibold" style="display: none;">
                            <i class="fas fa-arrow-right"></i> Proceed to Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border: none;
        border-radius: 12px;
    }
    
    .form-control-lg, .form-select-lg {
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 16px;
        border: 1px solid #dee2e6;
    }
    
    .form-control-lg:focus, .form-select-lg:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .btn-lg {
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 16px;
    }
</style>

<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    searchAvailability();
});

// Update min check-out date when check-in changes
document.getElementById('check_in').addEventListener('change', function() {
    const checkInDate = new Date(this.value);
    const minCheckOut = new Date(checkInDate);
    minCheckOut.setDate(minCheckOut.getDate() + 1);
    
    document.getElementById('check_out').min = minCheckOut.toISOString().split('T')[0];
});

function searchAvailability() {
    const checkIn = document.getElementById('check_in').value;
    const checkOut = document.getElementById('check_out').value;
    const roomTypeId = document.getElementById('room_type_id').value;
    const quantity = document.getElementById('quantity').value;

    if (!checkIn || !checkOut || !roomTypeId) {
        alert('Please fill in all fields');
        return;
    }

    // Show loading state
    const searchBtn = document.querySelector('button[type="submit"]');
    const originalText = searchBtn.innerHTML;
    searchBtn.disabled = true;
    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';

    fetch('{{ route("booking.check-availability") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({
            check_in: checkIn,
            check_out: checkOut,
            room_type_id: roomTypeId
        })
    })
    .then(response => response.json())
    .then(data => {
        searchBtn.disabled = false;
        searchBtn.innerHTML = originalText;

        if (!data.success) {
            alert(data.message || 'Search failed. Please try again.');
            return;
        }

        // Display results
        const checkInDate = new Date(data.availability.check_in).toLocaleDateString('en-IN');
        const checkOutDate = new Date(data.availability.check_out).toLocaleDateString('en-IN');
        
        document.getElementById('resultDates').textContent = `${checkInDate} to ${checkOutDate}`;
        document.getElementById('resultNights').textContent = `${data.availability.nights} night(s)`;
        
        if (data.availability.available_rooms >= quantity) {
            document.getElementById('availabilityStatus').innerHTML = 
                `<i class="fas fa-check-circle"></i> ${data.availability.available_rooms} room(s) available!`;
        } else {
            document.getElementById('availabilityStatus').innerHTML = 
                `<i class="fas fa-exclamation-triangle"></i> Only ${data.availability.available_rooms} room(s) available. You requested ${quantity}.`;
        }
        
        document.getElementById('pricePerNight').textContent = '₹' + number_format(data.pricing.price_per_night);
        document.getElementById('subtotal').textContent = '₹' + number_format(data.pricing.subtotal);
        document.getElementById('taxAmount').textContent = '₹' + number_format(data.pricing.tax_amount);
        document.getElementById('grandTotal').textContent = '₹' + number_format(data.pricing.grand_total);
        
        // Build proceed URL
        const proceedUrl = new URL('{{ route("booking.form") }}', window.location.origin);
        proceedUrl.searchParams.append('check_in', checkIn);
        proceedUrl.searchParams.append('check_out', checkOut);
        proceedUrl.searchParams.append('room_type_id', roomTypeId);
        proceedUrl.searchParams.append('quantity', quantity);
        
        document.getElementById('proceedBtn').href = proceedUrl.toString();
        
        // Show results and proceed button only if available
        if (data.availability.available_rooms >= quantity) {
            document.getElementById('proceedBtn').style.display = 'block';
        } else {
            document.getElementById('proceedBtn').style.display = 'none';
        }
        
        document.getElementById('resultsContainer').style.display = 'block';
    })
    .catch(error => {
        searchBtn.disabled = false;
        searchBtn.innerHTML = originalText;
        console.error('Error:', error);
        alert('An error occurred while searching. Please try again.');
    });
}

function number_format(number) {
    return Number(number).toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 2});
}
</script>
@endsection
