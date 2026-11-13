<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomType;
use App\Models\TemporaryReservation;
use App\Models\RoomAllocation;
use App\Services\RoomAvailabilityService;
use App\Services\RoomAllocationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected RoomAvailabilityService $availabilityService;
    protected RoomAllocationService $allocationService;

    public function __construct(
        RoomAvailabilityService $availabilityService,
        RoomAllocationService $allocationService
    ) {
        $this->availabilityService = $availabilityService;
        $this->allocationService = $allocationService;
    }

    /**
     * Show booking search form
     */
    public function searchForm(): View
    {
        return view('booking.search-form');
    }

    /**
     * Search availability - AJAX endpoint
     * Returns availability data for given dates and room category
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'check_in' => 'required|date|after_or_equal:today',
                'check_out' => 'required|date|after:check_in',
                'room_type_id' => 'required|exists:room_types,id',
            ]);

            $checkIn = Carbon::parse($validated['check_in'])->startOfDay();
            $checkOut = Carbon::parse($validated['check_out'])->startOfDay();
            $roomTypeId = $validated['room_type_id'];

            // Get room type details
            $roomType = RoomType::findOrFail($roomTypeId);

            // Calculate number of nights
            $nights = $this->availabilityService->calculateNights($checkIn, $checkOut);
            
            // Get available rooms for this category - returns array with available_quantity
            $availabilityData = $this->availabilityService->getAvailableRooms(
                $roomTypeId,
                $checkIn,
                $checkOut
            );
            $availableCount = $availabilityData['available_quantity'];

            // Calculate pricing
            $pricePerNight = $roomType->base_price;
            $totalPrice = $pricePerNight * $nights;
            $taxRate = 0.12; // 12% GST
            $tax = round($totalPrice * $taxRate, 2);
            $grandTotal = $totalPrice + $tax;

            return response()->json([
                'success' => true,
                'room_type' => [
                    'id' => $roomType->id,
                    'name' => $roomType->name,
                    'max_occupancy' => $roomType->max_occupancy,
                    'base_price' => $roomType->base_price,
                ],
                'availability' => [
                    'available_rooms' => $availableCount,
                    'nights' => $nights,
                    'check_in' => $checkIn->format('Y-m-d'),
                    'check_out' => $checkOut->format('Y-m-d'),
                ],
                'pricing' => [
                    'price_per_night' => $pricePerNight,
                    'subtotal' => $totalPrice,
                    'tax_rate' => $taxRate * 100,
                    'tax_amount' => $tax,
                    'grand_total' => $grandTotal,
                ],
            ]);
        } catch (\Exception $e) {
            Log::warning('Availability check failed', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to check availability. Please try again.',
            ], 400);
        }
    }

    /**
     * Show booking form with pre-filled availability data
     */
    public function showForm(Request $request): View
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_type_id' => 'required|exists:room_types,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $checkIn = Carbon::parse($validated['check_in'])->startOfDay();
        $checkOut = Carbon::parse($validated['check_out'])->startOfDay();
        $roomTypeId = $validated['room_type_id'];
        $quantity = $validated['quantity'];

        // Verify availability still holds
        $availabilityData = $this->availabilityService->getAvailableRooms(
            $roomTypeId,
            $checkIn,
            $checkOut
        );
        $available = $availabilityData['available_quantity'];

        if ($available < $quantity) {
            return back()->withErrors([
                'quantity' => 'Only ' . $available . ' rooms available for selected dates.',
            ])->withInput();
        }

        // Get room type details
        $roomType = RoomType::findOrFail($roomTypeId);

        // Calculate pricing
        $nights = $this->availabilityService->calculateNights($checkIn, $checkOut);
        $pricePerNight = $roomType->base_price;
        $subtotal = $pricePerNight * $nights;
        $taxRate = 0.12; // 12% GST
        $tax = round($subtotal * $taxRate, 2);
        $grandTotal = $subtotal + $tax;

        // Get verified customer mobile from session
        $customerMobile = session('verified_mobile');

        return view('booking.form', [
            'roomType' => $roomType,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
            'quantity' => $quantity,
            'pricePerNight' => $pricePerNight,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'grandTotal' => $grandTotal,
            'customerMobile' => $customerMobile,
        ]);
    }

    /**
     * Store booking (create temporary reservation)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'check_in' => 'required|date|after_or_equal:today',
                'check_out' => 'required|date|after:check_in',
                'room_type_id' => 'required|exists:room_types,id',
                'quantity' => 'required|integer|min:1|max:10',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'total_guests' => 'required|integer|min:1',
                'special_requests' => 'nullable|string|max:1000',
            ]);

            $checkIn = Carbon::parse($validated['check_in'])->startOfDay();
            $checkOut = Carbon::parse($validated['check_out'])->startOfDay();
            $roomTypeId = $validated['room_type_id'];
            $quantity = $validated['quantity'];

            // Get verified mobile from session
            $customerMobile = session('verified_mobile');
            if (!$customerMobile) {
                return back()->withErrors([
                    'auth' => 'Your OTP verification has expired. Please verify again.',
                ])->withInput();
            }

            // Recheck availability (critical security check)
            $availabilityData = $this->availabilityService->getAvailableRooms(
                $roomTypeId,
                $checkIn,
                $checkOut
            );
            $available = $availabilityData['available_quantity'];

            if ($available < $quantity) {
                return back()->withErrors([
                    'quantity' => 'Only ' . $available . ' rooms available now. Please adjust your selection.',
                ])->withInput();
            }

            // Get room type for pricing verification
            $roomType = RoomType::findOrFail($roomTypeId);

            // Calculate pricing (server-side only - never trust frontend)
            $nights = $this->availabilityService->calculateNights($checkIn, $checkOut);
            $pricePerNight = $roomType->base_price;
            $baseAmount = $pricePerNight * $nights;
            $taxRate = 0.12; // 12% GST
            $tax = round($baseAmount * $taxRate, 2);
            $totalAmount = $baseAmount + $tax;

            // Validate guest count
            $maxGuestsPerRoom = $roomType->max_occupancy;
            if ($validated['total_guests'] > ($maxGuestsPerRoom * $quantity)) {
                return back()->withErrors([
                    'total_guests' => 'Maximum ' . ($maxGuestsPerRoom * $quantity) . ' guests allowed for ' . $quantity . ' rooms.',
                ])->withInput();
            }

            // Use database transaction to prevent race conditions
            return DB::transaction(function () use (
                $checkIn,
                $checkOut,
                $roomTypeId,
                $quantity,
                $customerMobile,
                $validated,
                $totalAmount,
                $baseAmount,
                $tax
            ) {
                // Get available physical rooms (with row-level locking)
                $availableRooms = $this->availabilityService->getAvailablePhysicalRooms(
                    $roomTypeId,
                    $checkIn,
                    $checkOut,
                    $quantity
                );

                if (count($availableRooms) < $quantity) {
                    throw new \Exception('Rooms no longer available. Please try again.');
                }

                // Generate unique booking reference and temporary razorpay order ID
                $bookingReference = 'BK' . now()->format('YmdHis') . rand(1000, 9999);
                $tempOrderId = 'TEMP_' . $bookingReference;

                // Create temporary booking record
                $booking = Booking::create([
                    'booking_reference' => $bookingReference,
                    'customer_name' => $validated['customer_name'],
                    'customer_mobile' => $customerMobile,
                    'customer_email' => $validated['customer_email'],
                    'room_type_id' => $roomTypeId,
                    'check_in_date' => $checkIn,
                    'check_out_date' => $checkOut,
                    'room_quantity' => $quantity,
                    'num_adults' => $validated['total_guests'],
                    'num_children' => 0,
                    'base_amount' => $baseAmount,
                    'tax_amount' => $tax,
                    'total_amount' => $totalAmount,
                    'razorpay_order_id' => $tempOrderId,
                    'booking_status' => 'confirmed',
                    'payment_status' => 'pending',
                    'special_requests' => $validated['special_requests'] ?? null,
                ]);

                // Allocate temporary rooms to this booking
                foreach ($availableRooms->take($quantity) as $room) {
                    RoomAllocation::create([
                        'booking_id' => $booking->id,
                        'room_id' => $room->id,
                        'check_in_date' => $checkIn,
                        'check_out_date' => $checkOut,
                        'allocation_status' => 'temporary',
                    ]);
                }

                // Store booking session for payment flow
                session([
                    'booking_id' => $booking->id,
                    'booking_amount' => $totalAmount,
                    'booking_customer_mobile' => $customerMobile,
                ]);

                return redirect()->route('booking.review', ['booking' => $booking->id])
                    ->with('success', 'Booking created. Please review and proceed to payment.');
            });
        } catch (\Exception $e) {
            Log::error('Booking creation failed', [
                'error' => $e->getMessage(),
                'mobile' => session('verified_mobile'),
            ]);

            return back()->withErrors([
                'error' => 'Unable to create booking. ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Review booking details before payment
     */
    public function review($booking): View
    {
        $booking = Booking::with('roomType')
            ->findOrFail($booking);

        // Verify booking belongs to current session (security check)
        if ($booking->customer_mobile !== session('verified_mobile')) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Check booking is pending payment
        if ($booking->payment_status !== 'pending') {
            return redirect()->route('booking.status', ['booking' => $booking->id])
                ->with('info', 'Booking has already been processed.');
        }

        return view('booking.review', [
            'booking' => $booking,
        ]);
    }

    /**
     * Check booking status (useful after payment)
     */
    public function status($booking): View
    {
        $booking = Booking::with('roomType', 'allocations')
            ->findOrFail($booking);

        // Verify booking belongs to current customer
        if ($booking->customer_mobile !== session('verified_mobile')) {
            abort(403, 'Unauthorized access to booking.');
        }

        return view('booking.status', [
            'booking' => $booking,
        ]);
    }
}
