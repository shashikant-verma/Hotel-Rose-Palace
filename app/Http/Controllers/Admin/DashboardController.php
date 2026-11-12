<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index(): View
    {
        // Get statistics
        $totalEnquiries = Enquiry::count();
        $newEnquiries = Enquiry::where('status', 'new')->count();
        $confirmedBookings = Enquiry::where('status', 'booking_confirmed')->count();
        $totalRoomTypes = RoomType::where('is_active', true)->count();
        
        // Get recent enquiries (last 10)
        $recentEnquiries = Enquiry::with('roomType')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get enquiry status breakdown
        $enquiryStatuses = Enquiry::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get booking trend (last 7 days)
        $bookingTrend = Enquiry::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.dashboard', [
            'totalEnquiries' => $totalEnquiries,
            'newEnquiries' => $newEnquiries,
            'confirmedBookings' => $confirmedBookings,
            'totalRoomTypes' => $totalRoomTypes,
            'recentEnquiries' => $recentEnquiries,
            'enquiryStatuses' => $enquiryStatuses,
            'bookingTrend' => $bookingTrend,
        ]);
    }
}
