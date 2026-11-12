<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms
     */
    public function index()
    {
        $rooms = Room::with(['roomType', 'images'])
            ->orderBy('floor')
            ->orderBy('room_number')
            ->paginate(15);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room
     */
    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created room
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'floor' => 'required|integer|min:0|max:50',
            'current_price' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
            'status' => 'required|in:available,occupied,maintenance,reserved',
        ]);

        // If current_price not set, use room type base price
        if (!isset($validated['current_price'])) {
            $roomType = RoomType::find($validated['room_type_id']);
            $validated['current_price'] = $roomType->base_price;
        }

        $room = Room::create($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room created successfully!');
    }

    /**
     * Show the form for editing the specified room
     */
    public function edit(Room $room)
    {
        $roomTypes = RoomType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $room->load('images');

        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified room
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms')->ignore($room->id),
            ],
            'floor' => 'required|integer|min:0|max:50',
            'current_price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'status' => 'required|in:available,occupied,maintenance,reserved',
        ]);

        $room->update($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room
     */
    public function destroy(Room $room)
    {
        // Delete all room images
        foreach ($room->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully!');
    }

    /**
     * Upload images for a room
     */
    public function uploadImages(Request $request, Room $room)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $uploadedCount = 0;

        foreach ($request->file('images') as $image) {
            // Store image
            $path = $image->store('rooms/' . $room->id, 'public');

            // Create room image record
            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $path,
                'caption' => null,
                'sort_order' => RoomImage::where('room_id', $room->id)->max('sort_order') + 1,
                'is_featured' => RoomImage::where('room_id', $room->id)->count() === 0, // First image is featured
            ]);

            $uploadedCount++;
        }

        return back()->with('success', "{$uploadedCount} image(s) uploaded successfully!");
    }

    /**
     * Delete a room image
     */
    public function deleteImage(RoomImage $image)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // If this was featured, make next image featured
        if ($image->is_featured) {
            $nextImage = RoomImage::where('room_id', $image->room_id)
                ->where('id', '!=', $image->id)
                ->first();

            if ($nextImage) {
                $nextImage->update(['is_featured' => true]);
            }
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }

    /**
     * Set featured image
     */
    public function setFeaturedImage(RoomImage $image)
    {
        // Remove featured from all images of this room
        RoomImage::where('room_id', $image->room_id)->update(['is_featured' => false]);

        // Set this image as featured
        $image->update(['is_featured' => true]);

        return back()->with('success', 'Featured image updated successfully!');
    }

    /**
     * Toggle room availability
     */
    public function toggleAvailability(Room $room)
    {
        $room->update([
            'is_available' => !$room->is_available,
            'status' => $room->is_available ? 'occupied' : 'available',
        ]);

        $status = $room->is_available ? 'available' : 'unavailable';

        return back()->with('success', "Room marked as {$status}!");
    }
}
