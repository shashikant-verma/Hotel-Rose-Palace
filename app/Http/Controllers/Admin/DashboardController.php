<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics
     */
    public function index()
    {
        // Get key statistics
        $stats = [
            'total_enquiries' => Enquiry::count(),
            'new_enquiries' => Enquiry::where('status', 'new')->count(),
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('is_available', true)->count(),
            'total_room_types' => RoomType::count(),
            'gallery_images' => GalleryImage::count(),
        ];

        // Recent enquiries (last 5)
        $recentEnquiries = Enquiry::with('roomType')
            ->latest()
            ->take(5)
            ->get();

        // Enquiries by status
        $enquiriesByStatus = Enquiry::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Enquiries by room type (top 5)
        $enquiriesByRoomType = Enquiry::select('room_type_id', DB::raw('count(*) as count'))
            ->with('roomType:id,name')
            ->groupBy('room_type_id')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->roomType->name ?? 'Unknown' => $item->count];
            });

        // Recent enquiries trend (last 7 days)
        $enquiriesTrend = Enquiry::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        return view('admin.dashboard', compact(
            'stats',
            'recentEnquiries',
            'enquiriesByStatus',
            'enquiriesByRoomType',
            'enquiriesTrend'
        ));
    }
}
