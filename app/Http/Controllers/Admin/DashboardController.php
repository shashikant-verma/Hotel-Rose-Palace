<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\GalleryImage;
use App\Models\BanquetBooking;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with PMS statistics
     */
    public function index()
    {
        $today = today();

        // PMS & Hotel KPI statistics
        $stats = [
            'total_enquiries' => Enquiry::count(),
            'new_enquiries' => Enquiry::where('status', 'new')->count(),
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('is_available', true)->count(),
            'clean_available_rooms' => Room::where('is_available', true)->where('housekeeping_status', 'clean')->count(),
            'dirty_rooms' => Room::where('housekeeping_status', 'dirty')->count(),
            'maintenance_rooms' => Room::where('housekeeping_status', 'maintenance')->count(),
            'today_checkins' => Enquiry::whereDate('check_in_date', $today)->whereIn('status', ['confirmed', 'booking_confirmed', 'checked_in'])->count(),
            'today_checkouts' => Enquiry::whereDate('check_out_date', $today)->whereIn('status', ['checked_in', 'checked_out'])->count(),
            'active_inhouse_guests' => Enquiry::where('status', 'checked_in')->count(),
            'monthly_revenue' => Enquiry::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('paid_amount') + BanquetBooking::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('advance_paid'),
            'total_room_types' => RoomType::count(),
            'gallery_images' => GalleryImage::count(),
            'upcoming_banquets_count' => BanquetBooking::where('event_date', '>=', $today)->whereIn('status', ['confirmed', 'tentative'])->count(),
            'total_contact_messages' => ContactMessage::count(),
            'new_contact_messages' => ContactMessage::where('status', 'new')->orWhere(function($q) { $q->whereNull('status')->where('is_read', false); })->count(),
        ];

        // Today's arrivals for front desk quick action
        $todayArrivals = Enquiry::with(['roomType', 'room'])
            ->whereDate('check_in_date', $today)
            ->whereIn('status', ['confirmed', 'booking_confirmed', 'contacted', 'availability_confirmed', 'checked_in'])
            ->orderBy('check_in_date')
            ->take(8)
            ->get();

        // Today's departures for front desk quick checkout
        $todayDepartures = Enquiry::with(['roomType', 'room'])
            ->whereDate('check_out_date', $today)
            ->whereIn('status', ['checked_in', 'checked_out'])
            ->orderBy('check_out_date')
            ->take(8)
            ->get();

        // Recent enquiries (last 6)
        $recentEnquiries = Enquiry::with(['roomType', 'room'])
            ->latest()
            ->take(6)
            ->get();

        // Available rooms for walk-in modal dropdown
        $allRooms = Room::with('roomType')->orderBy('room_number')->get();
        $roomTypes = RoomType::where('is_active', true)->orderBy('name')->get();

        // Upcoming banquets
        $upcomingBanquets = BanquetBooking::where('event_date', '>=', $today)
            ->where('status', 'confirmed')
            ->orderBy('event_date', 'asc')
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
            'todayArrivals',
            'todayDepartures',
            'recentEnquiries',
            'allRooms',
            'roomTypes',
            'upcomingBanquets',
            'enquiriesByStatus',
            'enquiriesByRoomType',
            'enquiriesTrend'
        ));
    }
}
