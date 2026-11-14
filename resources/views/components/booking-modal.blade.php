@php
    try {
        $dbRoomTypes = \App\Models\RoomType::where('is_active', true)->orderBy('sort_order')->get();
    } catch (\Exception $e) {
        $dbRoomTypes = collect();
    }
    if ($dbRoomTypes->isEmpty()) {
        $dbRoomTypes = collect([
            (object)['id' => 1, 'name' => 'Deluxe Double Room', 'slug' => 'deluxe-double-room', 'base_price' => 3999],
            (object)['id' => 2, 'name' => 'Superior Twin Room', 'slug' => 'superior-twin-room', 'base_price' => 4499],
            (object)['id' => 3, 'name' => 'Executive Suite', 'slug' => 'executive-suite', 'base_price' => 6499],
            (object)['id' => 4, 'name' => 'Royal Palace Suite', 'slug' => 'royal-palace-suite', 'base_price' => 8999],
        ]);
    }
@endphp

<!-- Real Interactive Booking & Price Calculator Modal -->
<div class="modal fade" id="hrpBookingModal" tabindex="-1" aria-labelledby="hrpBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content hrp-modal-content">
            
            {{-- Header --}}
            <div class="modal-header hrp-modal-header">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="hrp-guarantee-badge">
                            <i class="fas fa-shield-alt"></i> Best Rate Guaranteed
                        </span>
                        <span class="badge" style="background: rgba(110,44,58,0.12); color: #6E2C3A; font-size: 11px; padding: 4px 8px;">
                            Zero Booking Fees
                        </span>
                    </div>
                    <h4 class="modal-title m-0" id="hrpBookingModalLabel" style="font-family: 'Playfair Display', serif; color: #2E1F22; font-weight: 700;">
                        Room Reservation Enquiry
                    </h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: sepia(1) saturate(2);"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body hrp-modal-body">
                
                {{-- Reservation Form --}}
                <form id="hrpDirectBookingForm" method="POST" action="{{ route('enquiry.store') }}">
                    @csrf

                    {{-- Top Row: Currency Toggle --}}
                    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2 mb-3 pb-2" style="border-bottom: 1px solid #D8CBB8;">
                        <div class="hrp-currency-toggle">
                            <button type="button" class="hrp-curr-btn active" id="modalCurrINR" onclick="setBookingCurrency('INR')">INR (₹)</button>
                            <button type="button" class="hrp-curr-btn" id="modalCurrUSD" onclick="setBookingCurrency('USD')">USD ($)</button>
                        </div>
                    </div>

                    {{-- Dates & Room Type Row --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 col-sm-6">
                            <label class="hrp-field-label" for="modalCheckIn">
                                <i class="fas fa-calendar-alt text-gold"></i> Check-in Date
                            </label>
                            <input type="date" id="modalCheckIn" name="check_in_date" class="hrp-field-input" required onchange="calculateBookingPrice()">
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="hrp-field-label" for="modalCheckOut">
                                <i class="fas fa-calendar-check text-gold"></i> Check-out Date
                            </label>
                            <input type="date" id="modalCheckOut" name="check_out_date" class="hrp-field-input" required onchange="calculateBookingPrice()">
                        </div>
                    </div>

                    {{-- Room Category & Rooms Count --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="hrp-field-label" for="modalRoomType">
                                <i class="fas fa-bed text-gold"></i> Select Room / Suite
                            </label>
                            <select id="modalRoomType" name="room_type_id" class="hrp-field-input" style="cursor: pointer;" required onchange="calculateBookingPrice()">
                                @foreach($dbRoomTypes as $rt)
                                    <option value="{{ $rt->id }}" data-price="{{ (float)$rt->base_price }}" data-slug="{{ $rt->slug ?? '' }}">
                                        {{ $rt->name }} — ₹{{ number_format($rt->base_price, 0) }}/night
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="hrp-field-label">
                                <i class="fas fa-door-open text-gold"></i> Rooms
                            </label>
                            <div class="hrp-counter w-100 justify-content-between p-1">
                                <button type="button" class="hrp-counter-btn" onclick="updateCounter('Rooms', -1)">−</button>
                                <span class="hrp-counter-val" id="valRooms">1</span>
                                <button type="button" class="hrp-counter-btn" onclick="updateCounter('Rooms', 1)">+</button>
                            </div>
                            <input type="hidden" id="numRoomsInput" name="num_rooms" value="1">
                        </div>
                    </div>

                    {{-- Adults & Children Counters --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 col-sm-6">
                            <label class="hrp-field-label">
                                <i class="fas fa-user text-gold"></i> Adults (Age 12+)
                            </label>
                            <div class="hrp-counter w-100 justify-content-between p-1">
                                <button type="button" class="hrp-counter-btn" onclick="updateCounter('Adults', -1)">−</button>
                                <span class="hrp-counter-val" id="valAdults">2</span>
                                <button type="button" class="hrp-counter-btn" onclick="updateCounter('Adults', 1)">+</button>
                            </div>
                            <input type="hidden" id="numAdultsInput" name="num_adults" value="2">
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="hrp-field-label">
                                <i class="fas fa-child text-gold"></i> Children (Age 0-11)
                            </label>
                            <div class="hrp-counter w-100 justify-content-between p-1">
                                <button type="button" class="hrp-counter-btn" onclick="updateCounter('Children', -1)">−</button>
                                <span class="hrp-counter-val" id="valChildren">0</span>
                                <button type="button" class="hrp-counter-btn" onclick="updateCounter('Children', 1)">+</button>
                            </div>
                            <input type="hidden" id="numChildrenInput" name="num_children" value="0">
                        </div>
                    </div>

                    {{-- Guest Details Section --}}
                    <div class="mb-3">
                        <span style="font-size: 12px; font-weight: 700; color: #2E1F22; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 10px;">
                            <i class="fas fa-user-check text-gold"></i> Guest Contact Information:
                        </span>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" id="modalCustomerName" name="customer_name" class="hrp-field-input" placeholder="Full Name *" required>
                            </div>
                            <div class="col-md-4">
                                <input type="tel" id="modalCustomerPhone" name="customer_phone" class="hrp-field-input" placeholder="Phone / WhatsApp Number *" required>
                            </div>
                            <div class="col-md-4">
                                <input type="email" id="modalCustomerEmail" name="customer_email" class="hrp-field-input" placeholder="Email Address (Optional)">
                            </div>
                            <div class="col-12 mt-2">
                                <input type="text" id="modalSpecialRequests" name="special_requests" class="hrp-field-input" placeholder="Special Requests (e.g. Early check-in, Jain food, High floor, Anniversary)">
                            </div>
                        </div>
                    </div>

                    {{-- Live Price Summary Breakdown Card --}}
                    <div class="hrp-calc-summary-card">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-weight: 700; color: #2E1F22; font-size: 15px;">Live Price Estimate</span>
                            <span class="badge" style="background: #27ae60; color: #F7F1E8; font-size: 11px;">Best Rate Guaranteed</span>
                        </div>
                        <div class="hrp-calc-row">
                            <span id="summaryNightsLabel">Accommodation (1 Night, 1 Room):</span>
                            <span id="summaryBasePrice" style="font-weight: 600; color: #2E1F22;">₹3,999</span>
                        </div>
                        <div class="hrp-calc-row" id="summaryAddonsRow" style="display: none;">
                            <span>Stay Enhancements:</span>
                            <span id="summaryAddonsPrice" style="font-weight: 600; color: #2E1F22;">₹0</span>
                        </div>
                        <div class="hrp-calc-row">
                            <span>Taxes & Service GST (12%):</span>
                            <span id="summaryGstPrice" style="font-weight: 600; color: #2E1F22;">₹480</span>
                        </div>
                        <div class="hrp-calc-total-row">
                            <span>Estimated Total:</span>
                            <span id="summaryTotalPrice" style="color: #6E2C3A;">₹4,479</span>
                        </div>
                        <div style="font-size: 11px; color: #5E4B4E; margin-top: 6px; text-align: right;">
                            Pay directly at the hotel or online via UPI/Card. Free cancellation up to 24 hrs prior to arrival.
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex flex-wrap gap-2 justify-content-end mt-4 pt-2" style="border-top: 1px solid #D8CBB8;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Booking Enquiry
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
let currentCurrency = 'INR';
const USD_RATE = 85.0; // 1 USD = 85 INR

// Initialize Dates on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);

    const checkInInput = document.getElementById('modalCheckIn');
    const checkOutInput = document.getElementById('modalCheckOut');

    if (checkInInput && checkOutInput) {
        const todayStr = today.toISOString().split('T')[0];
        const tomorrowStr = tomorrow.toISOString().split('T')[0];

        checkInInput.min = todayStr;
        checkInInput.value = todayStr;

        checkOutInput.min = tomorrowStr;
        checkOutInput.value = tomorrowStr;
    }

    calculateBookingPrice();
});

function setBookingCurrency(curr) {
    currentCurrency = curr;
    document.getElementById('modalCurrINR').classList.toggle('active', curr === 'INR');
    document.getElementById('modalCurrUSD').classList.toggle('active', curr === 'USD');

    // Update add-on labels
    document.querySelectorAll('.addon-price').forEach(el => {
        const inr = parseFloat(el.getAttribute('data-inr'));
        if (curr === 'USD') {
            el.textContent = '+$' + Math.round(inr / USD_RATE);
        } else {
            el.textContent = '+₹' + inr.toLocaleString('en-IN');
        }
    });

    calculateBookingPrice();
}

function updateCounter(type, change) {
    const valEl = document.getElementById('val' + type);
    const inputEl = document.getElementById(type === 'Rooms' ? 'numRoomsInput' : (type === 'Adults' ? 'numAdultsInput' : 'numChildrenInput'));
    if (!valEl) return;

    let current = parseInt(valEl.textContent) || 0;
    let min = (type === 'Children') ? 0 : 1;
    let max = (type === 'Rooms') ? 5 : (type === 'Adults' ? 10 : 6);

    current = Math.max(min, Math.min(max, current + change));
    valEl.textContent = current;
    if (inputEl) inputEl.value = current;

    calculateBookingPrice();
}

function calculateBookingPrice() {
    const checkInVal = document.getElementById('modalCheckIn')?.value;
    const checkOutVal = document.getElementById('modalCheckOut')?.value;
    const roomSelect = document.getElementById('modalRoomType');
    if (!checkInVal || !checkOutVal || !roomSelect) return;

    const dIn = new Date(checkInVal);
    const dOut = new Date(checkOutVal);

    let nights = Math.max(1, Math.round((dOut - dIn) / (1000 * 60 * 60 * 24)));
    if (isNaN(nights) || nights < 1) nights = 1;

    const numRooms = parseInt(document.getElementById('valRooms')?.textContent) || 1;
    const selectedOption = roomSelect.options[roomSelect.selectedIndex];
    const baseRatePerNight = parseFloat(selectedOption?.getAttribute('data-price')) || 3999;

    const baseSubtotal = baseRatePerNight * nights * numRooms;
    const subtotal = baseSubtotal;
    const gst = Math.round(subtotal * 0.12);
    const grandTotal = subtotal + gst;

    // Formatting helper
    function fmt(inrVal) {
        if (currentCurrency === 'USD') {
            return '$' + Math.round(inrVal / USD_RATE).toLocaleString('en-US');
        }
        return '₹' + inrVal.toLocaleString('en-IN');
    }

    const nightsLabel = `Accommodation (${nights} ${nights === 1 ? 'Night' : 'Nights'}, ${numRooms} ${numRooms === 1 ? 'Room' : 'Rooms'}):`;
    const summaryNightsLabel = document.getElementById('summaryNightsLabel');
    if (summaryNightsLabel) summaryNightsLabel.textContent = nightsLabel;

    document.getElementById('summaryBasePrice').textContent = fmt(baseSubtotal);
    
    const addonsRow = document.getElementById('summaryAddonsRow');
    if (addonsRow) addonsRow.style.display = 'none';

    document.getElementById('summaryGstPrice').textContent = fmt(gst);
    document.getElementById('summaryTotalPrice').textContent = fmt(grandTotal);
}

function submitBookingToWhatsApp() {
    const checkIn = document.getElementById('modalCheckIn')?.value || 'Not specified';
    const checkOut = document.getElementById('modalCheckOut')?.value || 'Not specified';
    const roomSelect = document.getElementById('modalRoomType');
    const roomName = roomSelect ? roomSelect.options[roomSelect.selectedIndex].text.split('—')[0].trim() : 'Room';
    const rooms = document.getElementById('valRooms')?.textContent || '1';
    const adults = document.getElementById('valAdults')?.textContent || '2';
    const children = document.getElementById('valChildren')?.textContent || '0';
    const name = document.getElementById('modalCustomerName')?.value || 'Guest';
    const phone = document.getElementById('modalCustomerPhone')?.value || '';
    const total = document.getElementById('summaryTotalPrice')?.textContent || '';
    const requests = document.getElementById('modalSpecialRequests')?.value || 'None';

    const msg = `*HOTEL ROSE PALACE — DIRECT RESERVATION ENQUIRY*
━━━━━━━━━━━━━━━━━━━━━━
🏨 *Room:* ${roomName} (${rooms} Room)
📅 *Dates:* ${checkIn} to ${checkOut}
👥 *Guests:* ${adults} Adults, ${children} Children
💰 *Estimated Total:* ${total} (incl. 12% GST)
━━━━━━━━━━━━━━━━━━━━━━
👤 *Guest Name:* ${name}
� *Phone:* ${phone}
📝 *Special Requests:* ${requests}`;

    const waNumber = '{{ preg_replace("/\D/", "", config("hotel.contact.whatsapp_number", "918799129929")) }}';
    const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;
    window.open(waUrl, '_blank');
}

// Global modal trigger helper
window.openBookingModal = function(preselectedSlugOrId, checkIn, checkOut, guests) {
    if (checkIn) document.getElementById('modalCheckIn').value = checkIn;
    if (checkOut) document.getElementById('modalCheckOut').value = checkOut;

    if (preselectedSlugOrId) {
        const roomSelect = document.getElementById('modalRoomType');
        for (let i = 0; i < roomSelect.options.length; i++) {
            if (roomSelect.options[i].value == preselectedSlugOrId || 
                roomSelect.options[i].getAttribute('data-slug') == preselectedSlugOrId) {
                roomSelect.selectedIndex = i;
                break;
            }
        }
    }

    if (guests) {
        document.getElementById('valAdults').textContent = guests;
        document.getElementById('numAdultsInput').value = guests;
    }

    calculateBookingPrice();

    const modalEl = document.getElementById('hrpBookingModal');
    if (modalEl && window.bootstrap && window.bootstrap.Modal) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
};
</script>
