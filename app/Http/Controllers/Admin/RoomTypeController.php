<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of room types
     */
    public function index()
    {
        $roomTypes = RoomType::withCount(['rooms', 'amenities'])
            ->orderBy('sort_order')
            ->paginate(15);

        return view('admin.room-types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new room type
     */
    public function create()
    {
        $amenities = Amenity::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('admin.room-types.create', compact('amenities'));
    }

    /**
     * Store a newly created room type
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types,name',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'max_occupancy' => 'required|integer|min:1|max:10',
            'max_adults' => 'required|integer|min:1|max:10',
            'max_children' => 'required|integer|min:0|max:10',
            'size_sqft' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Set sort order
        $validated['sort_order'] = RoomType::max('sort_order') + 1;

        // Create room type
        $roomType = RoomType::create($validated);

        // Attach amenities
        if ($request->has('amenities')) {
            $roomType->amenities()->sync($request->amenities);
        }

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Room type created successfully!');
    }

    /**
     * Show the form for editing the specified room type
     */
    public function edit(RoomType $roomType)
    {
        $amenities = Amenity::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $selectedAmenities = $roomType->amenities->pluck('id')->toArray();

        return view('admin.room-types.edit', compact('roomType', 'amenities', 'selectedAmenities'));
    }

    /**
     * Update the specified room type
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('room_types')->ignore($roomType->id),
            ],
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'max_occupancy' => 'required|integer|min:1|max:10',
            'max_adults' => 'required|integer|min:1|max:10',
            'max_children' => 'required|integer|min:0|max:10',
            'size_sqft' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        // Update slug if name changed
        if ($validated['name'] !== $roomType->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Update room type
        $roomType->update($validated);

        // Sync amenities
        $roomType->amenities()->sync($request->amenities ?? []);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Room type updated successfully!');
    }

    /**
     * Remove the specified room type
     */
    public function destroy(RoomType $roomType)
    {
        // Soft delete all related rooms
        $roomType->rooms()->delete();
        // Soft delete related enquiries
        $roomType->enquiries()->delete();
        // Then soft delete the room type
        $roomType->delete();

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Room type deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(RoomType $roomType)
    {
        $roomType->update([
            'is_active' => !$roomType->is_active,
        ]);

        $status = $roomType->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Room type {$status} successfully!");
    }
}
