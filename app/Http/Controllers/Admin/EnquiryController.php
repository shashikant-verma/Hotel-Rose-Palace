<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
    /**
     * Display a listing of enquiries with search and filters
     */
    public function index(Request $request)
    {
        $query = Enquiry::with('roomType');

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
        $statuses = Enquiry::getStatuses();

        return view('admin.enquiries.index', compact('enquiries', 'roomTypes', 'statuses'));
    }

    /**
     * Display the specified enquiry
     */
    public function show(Enquiry $enquiry)
    {
        $enquiry->load('roomType');
        
        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Update enquiry status
     */
    public function updateStatus(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,availability_confirmed,booking_confirmed,cancelled,closed',
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
            'status' => 'required|in:new,contacted,availability_confirmed,booking_confirmed,cancelled,closed',
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
