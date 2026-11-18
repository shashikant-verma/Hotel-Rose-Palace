<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\PromotionalOffer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PromotionalOfferController extends Controller
{
    /**
     * Display a listing of promotional offers
     */
    public function index()
    {
        $offers = PromotionalOffer::with('roomType')
            ->orderBy('start_date', 'desc')
            ->paginate(20);

        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.promotional-offers.index', compact('offers', 'roomTypes'));
    }

    /**
     * Show the form for creating a new promotional offer
     */
    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.promotional-offers.create', compact('roomTypes'));
    }

    /**
     * Store a newly created promotional offer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'discount_type' => 'required|in:fixed_amount,percentage',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date_time',
            'end_date' => 'required|date_time|after:start_date',
            'is_active' => 'boolean',
            'max_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // Validate that percentage discounts don't exceed 100%
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return back()->withErrors([
                'discount_value' => 'Percentage discount cannot exceed 100%',
            ])->withInput();
        }

        // Validate that max_discount is set for percentage discounts
        if ($validated['discount_type'] === 'percentage' && empty($validated['max_discount'])) {
            return back()->withErrors([
                'max_discount' => 'Max discount amount must be set for percentage-based offers',
            ])->withInput();
        }

        PromotionalOffer::create($validated);

        return redirect()->route('admin.promotional-offers.index')
            ->with('success', 'Promotional offer created successfully!');
    }

    /**
     * Show the form for editing a promotional offer
     */
    public function edit(PromotionalOffer $promotionalOffer)
    {
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.promotional-offers.edit', compact('promotionalOffer', 'roomTypes'));
    }

    /**
     * Update the specified promotional offer
     */
    public function update(Request $request, PromotionalOffer $promotionalOffer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'discount_type' => 'required|in:fixed_amount,percentage',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date_time',
            'end_date' => 'required|date_time|after:start_date',
            'is_active' => 'boolean',
            'max_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // Validate that percentage discounts don't exceed 100%
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return back()->withErrors([
                'discount_value' => 'Percentage discount cannot exceed 100%',
            ])->withInput();
        }

        // Validate that max_discount is set for percentage discounts
        if ($validated['discount_type'] === 'percentage' && empty($validated['max_discount'])) {
            return back()->withErrors([
                'max_discount' => 'Max discount amount must be set for percentage-based offers',
            ])->withInput();
        }

        $promotionalOffer->update($validated);

        return redirect()->route('admin.promotional-offers.index')
            ->with('success', 'Promotional offer updated successfully!');
    }

    /**
     * Delete the specified promotional offer
     */
    public function destroy(PromotionalOffer $promotionalOffer)
    {
        $promotionalOffer->delete();

        return redirect()->route('admin.promotional-offers.index')
            ->with('success', 'Promotional offer deleted successfully!');
    }

    /**
     * Deactivate a promotional offer
     */
    public function deactivate(PromotionalOffer $promotionalOffer)
    {
        $promotionalOffer->update(['is_active' => false]);

        return back()->with('success', 'Promotional offer deactivated successfully!');
    }

    /**
     * Reactivate a promotional offer
     */
    public function activate(PromotionalOffer $promotionalOffer)
    {
        $promotionalOffer->update(['is_active' => true]);

        return back()->with('success', 'Promotional offer activated successfully!');
    }
}
