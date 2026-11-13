<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BanquetController extends Controller
{
    /**
     * Display a listing of banquet / event bookings
     */
    public function index(Request $request)
    {
        $query = BanquetBooking::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('slot')) {
            $query->where('slot', $request->slot);
        }

        if ($request->filled('date_from')) {
            $query->where('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('event_date', '<=', $request->date_to);
        }

        $banquets = $query->orderBy('event_date', 'asc')->paginate(15)->appends($request->except('page'));

        // Stats
        $stats = [
            'total' => BanquetBooking::count(),
            'upcoming' => BanquetBooking::where('event_date', '>=', today())->where('status', 'confirmed')->count(),
            'this_month' => BanquetBooking::whereMonth('event_date', now()->month)->count(),
            'revenue_advance' => BanquetBooking::sum('advance_paid'),
        ];

        return view('admin.banquets.index', compact('banquets', 'stats'));
    }

    /**
     * Store a newly created banquet booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'event_date' => 'required|date',
            'slot' => 'required|in:morning,evening,full_day',
            'event_type' => 'required|string|max:100',
            'guest_count' => 'required|integer|min:10|max:1500',
            'catering_package' => 'required|string|max:150',
            'total_amount' => 'required|numeric|min:0',
            'advance_paid' => 'nullable|numeric|min:0',
            'payment_mode' => 'required|string|max:50',
            'payment_status' => 'required|in:paid,partial,pending',
            'status' => 'required|in:inquiry,confirmed,completed,cancelled',
            'special_notes' => 'nullable|string|max:1500',
        ]);

        // Check potential double booking on same date and overlapping slot
        $existing = BanquetBooking::where('event_date', $validated['event_date'])
            ->where('status', 'confirmed')
            ->where(function ($q) use ($validated) {
                if ($validated['slot'] === 'full_day') {
                    $q->whereIn('slot', ['morning', 'evening', 'full_day']);
                } else {
                    $q->whereIn('slot', [$validated['slot'], 'full_day']);
                }
            })
            ->first();

        if ($existing && $validated['status'] === 'confirmed') {
            return back()->withInput()->with('error', "Conflict: A confirmed banquet already exists on {$validated['event_date']} ({$existing->slot} slot: {$existing->event_type} - Ref #{$existing->reference_id}). Please choose another date or slot.");
        }

        $refNumber = str_pad((string)(BanquetBooking::max('id') + 1), 4, '0', STR_PAD_LEFT);
        $referenceId = 'HRP-BNQ-' . date('Y') . '-' . $refNumber;

        $validated['reference_id'] = $referenceId;
        $validated['advance_paid'] = $validated['advance_paid'] ?? 0;

        $banquet = BanquetBooking::create($validated);

        return redirect()->route('admin.banquets.index')
            ->with('success', "Banquet booking {$referenceId} for {$banquet->customer_name} created successfully!");
    }

    /**
     * Display the specified banquet booking
     */
    public function show(BanquetBooking $banquet)
    {
        return view('admin.banquets.show', compact('banquet'));
    }

    /**
     * Update banquet booking
     */
    public function update(Request $request, BanquetBooking $banquet)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'event_date' => 'required|date',
            'slot' => 'required|in:morning,evening,full_day',
            'event_type' => 'required|string|max:100',
            'guest_count' => 'required|integer|min:10|max:1500',
            'catering_package' => 'required|string|max:150',
            'total_amount' => 'required|numeric|min:0',
            'advance_paid' => 'nullable|numeric|min:0',
            'payment_mode' => 'required|string|max:50',
            'payment_status' => 'required|in:paid,partial,pending',
            'status' => 'required|in:inquiry,confirmed,completed,cancelled',
            'special_notes' => 'nullable|string|max:1500',
        ]);

        $banquet->update($validated);

        return back()->with('success', "Banquet booking {$banquet->reference_id} updated successfully!");
    }

    /**
     * Quick status update
     */
    public function updateStatus(Request $request, BanquetBooking $banquet)
    {
        $validated = $request->validate([
            'status' => 'required|in:inquiry,confirmed,completed,cancelled',
        ]);

        $banquet->update($validated);

        return back()->with('success', "Banquet status changed to " . ucfirst($validated['status']) . ".");
    }

    /**
     * Delete banquet booking
     */
    public function destroy(BanquetBooking $banquet)
    {
        $ref = $banquet->reference_id;
        $banquet->delete();

        return redirect()->route('admin.banquets.index')
            ->with('success', "Banquet booking {$ref} deleted successfully!");
    }
}
