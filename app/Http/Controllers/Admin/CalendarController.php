<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a 14-day visual room occupancy matrix
     */
    public function index(Request $request)
    {
        $startInput = $request->get('start_date', now()->format('Y-m-d'));
        try {
            $startDate = Carbon::parse($startInput)->startOfDay();
        } catch (\Exception $e) {
            $startDate = now()->startOfDay();
        }

        $endDate = $startDate->copy()->addDays(13)->endOfDay();

        // 14 days list
        $dates = [];
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dates[] = $current->copy();
            $current->addDay();
        }

        // Rooms with room types
        $rooms = Room::with('roomType')->orderBy('room_number')->get();

        // Bookings in this 14-day window
        $bookings = Enquiry::with(['roomType', 'room'])
            ->whereNotNull('room_id')
            ->whereNotIn('status', ['cancelled', 'closed'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                  ->orWhereBetween('check_out_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                  ->orWhere(function ($sub) use ($startDate, $endDate) {
                      $sub->where('check_in_date', '<=', $startDate->format('Y-m-d'))
                          ->where('check_out_date', '>=', $endDate->format('Y-m-d'));
                  });
            })
            ->get();

        // Pre-map bookings: [room_id][date_string] => booking
        $calendarGrid = [];
        foreach ($rooms as $room) {
            $calendarGrid[$room->id] = [];
            foreach ($dates as $date) {
                $calendarGrid[$room->id][$date->format('Y-m-d')] = null;
            }
        }

        foreach ($bookings as $b) {
            if (!$b->room_id || !isset($calendarGrid[$b->room_id])) continue;
            $bStart = Carbon::parse($b->check_in_date)->startOfDay();
            $bEnd = Carbon::parse($b->check_out_date)->startOfDay();

            $cursor = $bStart->copy();
            while ($cursor->lte($bEnd)) {
                $dateKey = $cursor->format('Y-m-d');
                if (isset($calendarGrid[$b->room_id][$dateKey])) {
                    $calendarGrid[$b->room_id][$dateKey] = $b;
                }
                $cursor->addDay();
            }
        }

        // Summary KPI calculations
        $totalRooms = $rooms->count();
        $cleanRoomsCount = $rooms->where('housekeeping_status', 'clean')->count();
        $dirtyRoomsCount = $rooms->where('housekeeping_status', 'dirty')->count();
        $maintRoomsCount = $rooms->where('housekeeping_status', 'maintenance')->count();

        return view('admin.calendar.index', compact(
            'startDate',
            'endDate',
            'dates',
            'rooms',
            'calendarGrid',
            'totalRooms',
            'cleanRoomsCount',
            'dirtyRoomsCount',
            'maintRoomsCount'
        ));
    }
}
