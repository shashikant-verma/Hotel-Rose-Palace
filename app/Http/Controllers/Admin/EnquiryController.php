<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnquiryController extends Controller
{
    /**
     * Display a listing of enquiries with search and filters
     */
    public function index(Request $request)
    {
        $query = Enquiry::with(['roomType', 'room']);

        // Search by reference, name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by room type
        if ($request->filled('room_type')) {
            $query->where('room_type_id', $request->room_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('check_in_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('check_in_date', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $enquiries = $query->paginate(20)->appends($request->except('page'));

        $roomTypes = RoomType::orderBy('name')->get();
        $rooms = Room::with('roomType')->orderBy('room_number')->get();
        $statuses = Enquiry::getStatuses();

        return view('admin.enquiries.index', compact('enquiries', 'roomTypes', 'rooms', 'statuses'));
    }

    /**
     * Store a new walk-in / phone reservation from reception
     */
    public function storeWalkIn(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'room_id' => 'required|exists:rooms,id',
            'room_type_id' => 'nullable|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'num_adults' => 'required|integer|min:1|max:10',
            'num_children' => 'nullable|integer|min:0|max:10',
            'id_proof_type' => 'required|string|max:50',
            'id_proof_number' => 'required|string|max:50',
            'booking_type' => 'required|in:walk_in,phone,corporate,website',
            'payment_mode' => 'required|string|max:50',
            'payment_status' => 'required|in:paid,partial,pending',
            'total_tariff' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'special_requests' => 'nullable|string|max:1000',
            'internal_notes' => 'nullable|string|max:1000',
            'instant_action' => 'required|in:reserve,check_in',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $roomTypeId = $validated['room_type_id'] ?? $room->room_type_id;

        // Auto-generate reference id HRP-YYYY-XXXXX
        $refNumber = str_pad((string)(Enquiry::max('id') + 1), 5, '0', STR_PAD_LEFT);
        $referenceId = 'HRP-' . date('Y') . '-' . $refNumber;

        $paidAmount = (float)($validated['paid_amount'] ?? 0);
        $status = ($validated['instant_action'] === 'check_in') ? 'checked_in' : 'booking_confirmed';

        $enquiry = Enquiry::create([
            'reference_id' => $referenceId,
            'room_type_id' => $roomTypeId,
            'room_id' => $room->id,
            'booking_type' => $validated['booking_type'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'id_proof_type' => $validated['id_proof_type'],
            'id_proof_number' => $validated['id_proof_number'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'num_adults' => $validated['num_adults'],
            'num_children' => $validated['num_children'] ?? 0,
            'special_requests' => $validated['special_requests'],
            'payment_mode' => $validated['payment_mode'],
            'payment_status' => $validated['payment_status'],
            'paid_amount' => $paidAmount,
            'total_tariff' => $validated['total_tariff'],
            'status' => $status,
            'internal_notes' => $validated['internal_notes'],
            'confirmed_at' => now(),
            'checked_in_at' => ($status === 'checked_in') ? now() : null,
        ]);

        if ($status === 'checked_in') {
            $room->update([
                'status' => 'occupied',
                'is_available' => false,
            ]);
        } else {
            $room->update([
                'status' => 'reserved',
            ]);
        }

        return redirect()->route('admin.enquiries.show', $enquiry)
            ->with('success', "Booking {$referenceId} created successfully for {$enquiry->customer_name}!");
    }

    /**
     * Display the specified enquiry
     */
    public function show(Enquiry $enquiry)
    {
        $enquiry->load(['roomType', 'room']);
        $rooms = Room::with('roomType')->orderBy('room_number')->get();
        
        return view('admin.enquiries.show', compact('enquiry', 'rooms'));
    }

    /**
     * 1-Click Check In Guest
     */
    public function checkIn(Enquiry $enquiry)
    {
        $enquiry->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        if ($enquiry->room) {
            $enquiry->room->update([
                'status' => 'occupied',
                'is_available' => false,
            ]);
        }

        return back()->with('success', "Guest {$enquiry->customer_name} has been Checked-In to Room " . ($enquiry->room->room_number ?? 'N/A') . ".");
    }

    /**
     * 1-Click Check Out Guest & Auto-flag Housekeeping Dirty
     */
    public function checkOut(Enquiry $enquiry)
    {
        $enquiry->update([
            'status' => 'checked_out',
            'checked_out_at' => now(),
        ]);

        if ($enquiry->room) {
            $enquiry->room->update([
                'status' => 'available',
                'is_available' => true,
                'housekeeping_status' => 'dirty',
            ]);
        }

        return back()->with('success', "Guest {$enquiry->customer_name} has been Checked-Out. Room marked as 'Dirty' for Housekeeping.");
    }

    /**
     * Printable GST Receipt / Invoice (A4 & Thermal friendly)
     */
    public function printInvoice(Enquiry $enquiry)
    {
        $enquiry->load(['roomType', 'room']);
        return view('admin.invoices.receipt', compact('enquiry'));
    }

    /**
     * Update enquiry status
     */
    public function updateStatus(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,availability_confirmed,booking_confirmed,checked_in,checked_out,cancelled,closed',
        ]);

        $oldStatus = $enquiry->status;
        $enquiry->status = $validated['status'];

        // Update timestamps based on status
        if ($validated['status'] === 'contacted' && !$enquiry->contacted_at) {
            $enquiry->contacted_at = now();
        }
        if (in_array($validated['status'], ['booking_confirmed', 'availability_confirmed']) && !$enquiry->confirmed_at) {
            $enquiry->confirmed_at = now();
        }
        if ($validated['status'] === 'checked_in' && !$enquiry->checked_in_at) {
            $enquiry->checked_in_at = now();
            if ($enquiry->room) {
                $enquiry->room->update(['status' => 'occupied', 'is_available' => false]);
            }
        }
        if ($validated['status'] === 'checked_out') {
            $enquiry->checked_out_at = now();
            if ($enquiry->room) {
                $enquiry->room->update([
                    'status' => 'available',
                    'is_available' => true,
                    'housekeeping_status' => 'dirty'
                ]);
            }
        }

        $enquiry->save();

        return back()->with('success', "Status updated from '{$oldStatus}' to '{$validated['status']}'");
    }

    /**
     * Update internal notes
     */
    public function updateNotes(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'internal_notes' => 'nullable|string|max:5000',
        ]);

        $enquiry->update($validated);

        return back()->with('success', 'Notes updated successfully!');
    }

    /**
     * Delete an enquiry
     */
    public function destroy(Enquiry $enquiry)
    {
        $reference = $enquiry->reference_id;
        $enquiry->delete();

        return redirect()
            ->route('admin.enquiries.index')
            ->with('success', "Enquiry {$reference} deleted successfully!");
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'enquiry_ids' => 'required|array',
            'enquiry_ids.*' => 'exists:enquiries,id',
            'status' => 'required|in:new,contacted,availability_confirmed,booking_confirmed,checked_in,checked_out,cancelled,closed',
        ]);

        $count = Enquiry::whereIn('id', $validated['enquiry_ids'])
            ->update(['status' => $validated['status']]);

        return back()->with('success', "{$count} enquiries updated to status: {$validated['status']}");
    }

    /**
     * Bulk delete enquiries
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'enquiry_ids' => 'required|array',
            'enquiry_ids.*' => 'exists:enquiries,id',
        ]);

        $count = Enquiry::whereIn('id', $validated['enquiry_ids'])->delete();

        return back()->with('success', "{$count} enquiries deleted successfully!");
    }

    /**
     * Export enquiries to CSV
     */
    public function export(Request $request)
    {
        $query = Enquiry::with('roomType');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_type')) {
            $query->where('room_type_id', $request->room_type);
        }

        $enquiries = $query->orderBy('created_at', 'desc')->get();

        $filename = 'enquiries_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($enquiries) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Reference ID',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Room Type',
                'Check-in Date',
                'Check-out Date',
                'Adults',
                'Children',
                'Status',
                'Special Requests',
                'Internal Notes',
                'Created At',
            ]);

            // Data rows
            foreach ($enquiries as $enquiry) {
                fputcsv($file, [
                    $enquiry->reference_id,
                    $enquiry->customer_name,
                    $enquiry->customer_email,
                    $enquiry->customer_phone,
                    $enquiry->roomType->name ?? 'N/A',
                    $enquiry->check_in_date->format('Y-m-d'),
                    $enquiry->check_out_date->format('Y-m-d'),
                    $enquiry->num_adults,
                    $enquiry->num_children,
                    $enquiry->status,
                    $enquiry->special_requests,
                    $enquiry->internal_notes,
                    $enquiry->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics()
    {
        $stats = [
            'total' => Enquiry::count(),
            'new' => Enquiry::where('status', 'new')->count(),
            'contacted' => Enquiry::where('status', 'contacted')->count(),
            'confirmed' => Enquiry::whereIn('status', ['availability_confirmed', 'booking_confirmed'])->count(),
            'cancelled' => Enquiry::where('status', 'cancelled')->count(),
            'today' => Enquiry::whereDate('created_at', today())->count(),
            'this_week' => Enquiry::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Enquiry::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json($stats);
    }
}
