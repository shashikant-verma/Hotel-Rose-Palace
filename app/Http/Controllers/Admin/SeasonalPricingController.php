<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\SeasonalPricing;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SeasonalPricingController extends Controller
{
    protected PricingService $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    /**
     * Display a listing of seasonal pricing
     */
    public function index()
    {
        $seasonalPricing = SeasonalPricing::with('roomType')
            ->orderBy('start_date', 'desc')
            ->paginate(20);

        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.seasonal-pricing.index', compact('seasonalPricing', 'roomTypes'));
    }

    /**
     * Show the form for creating new seasonal pricing
     */
    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.seasonal-pricing.create', compact('roomTypes'));
    }

    /**
     * Store a newly created seasonal pricing
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'season_name' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        // Check for overlapping seasonal pricing
        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->startOfDay();
        $roomTypeId = $validated['room_type_id'];

        $validation = $this->pricingService->validateSeasonalPricingNoConflict(
            RoomType::findOrFail($roomTypeId),
            $startDate,
            $endDate
        );

        if (!$validation['valid']) {
            return back()->withErrors([
                'date_conflict' => 'This date range overlaps with existing seasonal pricing: ' .
                    $validation['conflicts']->map(fn($c) => $c->getPeriodLabel())->implode(', '),
            ])->withInput();
        }

        SeasonalPricing::create($validated);

        return redirect()->route('admin.seasonal-pricing.index')
            ->with('success', 'Seasonal pricing created successfully!');
    }

    /**
     * Show the form for editing seasonal pricing
     */
    public function edit(SeasonalPricing $seasonalPricing)
    {
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.seasonal-pricing.edit', compact('seasonalPricing', 'roomTypes'));
    }

    /**
     * Update the specified seasonal pricing
     */
    public function update(Request $request, SeasonalPricing $seasonalPricing)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'season_name' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        // Check for overlapping seasonal pricing (exclude current record)
        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->startOfDay();
        $roomTypeId = $validated['room_type_id'];

        $validation = $this->pricingService->validateSeasonalPricingNoConflict(
            RoomType::findOrFail($roomTypeId),
            $startDate,
            $endDate,
            excludeId: $seasonalPricing->id
        );

        if (!$validation['valid']) {
            return back()->withErrors([
                'date_conflict' => 'This date range overlaps with existing seasonal pricing: ' .
                    $validation['conflicts']->map(fn($c) => $c->getPeriodLabel())->implode(', '),
            ])->withInput();
        }

        $seasonalPricing->update($validated);

        return redirect()->route('admin.seasonal-pricing.index')
            ->with('success', 'Seasonal pricing updated successfully!');
    }

    /**
     * Delete the specified seasonal pricing
     */
    public function destroy(SeasonalPricing $seasonalPricing)
    {
        $seasonalPricing->delete();

        return redirect()->route('admin.seasonal-pricing.index')
            ->with('success', 'Seasonal pricing deleted successfully!');
    }

    /**
     * Soft delete (deactivate) seasonal pricing
     */
    public function deactivate(SeasonalPricing $seasonalPricing)
    {
        $seasonalPricing->update(['is_active' => false]);

        return back()->with('success', 'Seasonal pricing deactivated successfully!');
    }

    /**
     * Reactivate seasonal pricing
     */
    public function activate(SeasonalPricing $seasonalPricing)
    {
        $seasonalPricing->update(['is_active' => true]);

        return back()->with('success', 'Seasonal pricing activated successfully!');
    }
}
