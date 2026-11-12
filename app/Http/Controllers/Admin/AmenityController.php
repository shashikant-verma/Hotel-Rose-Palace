<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    /**
     * Display amenities list
     */
    public function index()
    {
        $amenities = Amenity::orderBy('category')
            ->orderBy('name')
            ->paginate(20);

        $categories = Amenity::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.amenities.index', compact('amenities', 'categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = Amenity::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.amenities.create', compact('categories'));
    }

    /**
     * Store new amenity
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon_class' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        Amenity::create($validated);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(Amenity $amenity)
    {
        $categories = Amenity::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.amenities.edit', compact('amenity', 'categories'));
    }

    /**
     * Update amenity
     */
    public function update(Request $request, Amenity $amenity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon_class' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        $amenity->update($validated);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity updated successfully!');
    }

    /**
     * Delete amenity
     */
    public function destroy(Amenity $amenity)
    {
        // Check if amenity is assigned to any room types
        if ($amenity->roomTypes()->count() > 0) {
            return back()->with('error', 'Cannot delete amenity that is assigned to room types. Remove assignments first.');
        }

        $amenity->delete();

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(Amenity $amenity)
    {
        $amenity->update([
            'is_active' => !$amenity->is_active,
        ]);

        $status = $amenity->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Amenity {$status} successfully!");
    }
}
