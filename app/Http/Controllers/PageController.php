<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Models\GalleryImage;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show the home page
     */
    public function home(): View
    {
        $featuredRooms = Room::with(['roomType', 'images'])
            ->where('is_available', true)
            ->take(3)
            ->get();

        $amenities = Amenity::where('is_active', true)
            ->take(9)
            ->get();

        $galleryImages = GalleryImage::where('is_active', true)
            ->orderBy('display_order')
            ->take(6)
            ->get();

        return view('pages.home', [
            'featuredRooms' => $featuredRooms,
            'amenities' => $amenities,
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Show the about page
     */
    public function about(): View
    {
        $amenities = Amenity::where('is_active', true)->get();

        return view('pages.about', [
            'amenities' => $amenities,
        ]);
    }

    /**
     * Show all rooms
     */
    public function rooms(): View
    {
        $roomTypes = RoomType::with(['rooms', 'amenities'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.rooms', [
            'roomTypes' => $roomTypes,
        ]);
    }

    /**
     * Show room details
     */
    public function roomDetail($slug): View
    {
        $roomType = RoomType::with(['rooms', 'amenities'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $rooms = $roomType->rooms()->with('images')->get();

        return view('pages.room-detail', [
            'roomType' => $roomType,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show gallery
     */
    public function gallery(): View
    {
        $galleryImages = GalleryImage::where('is_active', true)
            ->orderBy('display_order')
            ->paginate(12);

        return view('pages.gallery', [
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Show amenities page
     */
    public function amenities(): View
    {
        $amenities = Amenity::where('is_active', true)
            ->get()
            ->groupBy('category');

        return view('pages.amenities', [
            'amenities' => $amenities,
        ]);
    }

    /**
     * Show contact page
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Show privacy policy
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }

    /**
     * Show terms and conditions
     */
    public function terms(): View
    {
        return view('pages.terms');
    }

    /**
     * Show cancellation policy
     */
    public function cancellation(): View
    {
        return view('pages.cancellation');
    }
}
