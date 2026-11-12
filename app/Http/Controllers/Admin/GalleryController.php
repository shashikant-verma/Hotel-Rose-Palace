<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display gallery management page
     */
    public function index()
    {
        $images = GalleryImage::orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->paginate(24);

        $categories = GalleryImage::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.gallery.index', compact('images', 'categories'));
    }

    /**
     * Show upload form
     */
    public function create()
    {
        $categories = GalleryImage::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Upload new gallery images
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array|max:20',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'category' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $uploadedCount = 0;
        $maxOrder = GalleryImage::max('display_order') ?? 0;

        foreach ($request->file('images') as $image) {
            // Store image
            $path = $image->store('gallery', 'public');

            // Create gallery image record
            GalleryImage::create([
                'title' => $request->input('title'),
                'image_path' => $path,
                'category' => $request->input('category'),
                'alt_text' => $request->input('alt_text', 'Hotel Rose Palace'),
                'display_order' => ++$maxOrder,
                'is_active' => $request->input('is_active', true),
            ]);

            $uploadedCount++;
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', "{$uploadedCount} image(s) uploaded successfully!");
    }

    /**
     * Show edit form for an image
     */
    public function edit(GalleryImage $gallery)
    {
        $categories = GalleryImage::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Update gallery image
     */
    public function update(Request $request, GalleryImage $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:50',
            'alt_text' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $gallery->update($validated);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Image updated successfully!');
    }

    /**
     * Delete gallery image
     */
    public function destroy(GalleryImage $gallery)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return back()->with('success', 'Image deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(GalleryImage $gallery)
    {
        $gallery->update([
            'is_active' => !$gallery->is_active,
        ]);

        $status = $gallery->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Image {$status} successfully!");
    }

    /**
     * Bulk delete images
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:gallery_images,id',
        ]);

        $images = GalleryImage::whereIn('id', $validated['image_ids'])->get();

        foreach ($images as $image) {
            // Delete file from storage
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        return back()->with('success', count($images) . ' image(s) deleted successfully!');
    }

    /**
     * Update display order
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:gallery_images,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['orders'] as $orderData) {
            GalleryImage::where('id', $orderData['id'])
                ->update(['display_order' => $orderData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Display order updated successfully'
        ]);
    }
}
