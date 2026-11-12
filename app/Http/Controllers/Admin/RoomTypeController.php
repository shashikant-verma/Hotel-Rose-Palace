<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of room types
     */
    public function index(): View
    {
        $roomTypes = RoomType::orderBy('sort_order')
            ->paginate(15);

        return view('admin.room-types.index', [
            'roomTypes' => $roomTypes,
        ]);
    }

    /**
     * Show the form for creating a new room type
     */
    public function create(): View
    {
        $amenities = Amenity::all();

        return view('admin.room-types.create', [
            'amenities' => $amenities,
        ]);
    }

    /**
     * Store a newly created room type in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:room_types,name'],
            'description' => ['required', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'max_occupancy' => ['required', 'integer', 'min:1'],
            'max_adults' => ['required', 'integer', 'min:1'],
            'max_children' => ['required', 'integer', 'min:0'],
            'amenities' => ['array'],
            'amenities.*' => ['exists:amenities,id'],
            'is_active' => ['boolean'],
        ]);

        // Generate slug from name
        $validated['slug'] = str($validated['name'])
            ->slug()
            ->value();

        $roomType = RoomType::create($validated);

        // Attach amenities if provided
        if (!empty($validated['amenities'])) {
            $roomType->amenities()->attach($validated['amenities']);
        }

        return redirect()->route('admin.room-types.show', $roomType)
            ->with('success', 'Room type created successfully!');
    }

    /**
     * Display the specified room type
     */
    public function show(RoomType $roomType): View
    {
        $roomType->load('amenities', 'rooms');

        return view('admin.room-types.show', [
            'roomType' => $roomType,
        ]);
    }

    /**
     * Show the form for editing the specified room type
     */
    public function edit(RoomType $roomType): View
    {
        $amenities = Amenity::all();
        $selectedAmenities = $roomType->amenities->pluck('id')->toArray();

        return view('admin.room-types.edit', [
            'roomType' => $roomType,
            'amenities' => $amenities,
            'selectedAmenities' => $selectedAmenities,
        ]);
    }

    /**
     * Update the specified room type in database
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:room_types,name,' . $roomType->id],
            'description' => ['required', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'max_occupancy' => ['required', 'integer', 'min:1'],
            'max_adults' => ['required', 'integer', 'min:1'],
            'max_children' => ['required', 'integer', 'min:0'],
            'amenities' => ['array'],
            'amenities.*' => ['exists:amenities,id'],
            'is_active' => ['boolean'],
        ]);

        // Generate slug from name if name changed
        if ($validated['name'] !== $roomType->name) {
            $validated['slug'] = str($validated['name'])
                ->slug()
                ->value();
        }

        $roomType->update($validated);

        // Update amenities
        $roomType->amenities()->sync($validated['amenities'] ?? []);

        return redirect()->route('admin.room-types.show', $roomType)
            ->with('success', 'Room type updated successfully!');
    }

    /**
     * Remove the specified room type from database
     */
    public function destroy(RoomType $roomType)
    {
        // Check if room type has rooms
        if ($roomType->rooms()->count() > 0) {
            return back()->with('error', 'Cannot delete room type that has existing rooms.');
        }

        $roomType->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type deleted successfully!');
    }
}
