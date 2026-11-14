<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of general customer inquiries
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        // Search by name, email, phone, subject, or message text
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status (new, read, replied)
        if ($request->filled('status') && in_array($request->status, ['new', 'read', 'replied'])) {
            $query->where('status', $request->status);
        }

        // Date range filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $inquiries = $query->paginate(15)->appends($request->except('page'));

        // Counter statistics for tabs/badges
        $counts = [
            'total'   => ContactMessage::count(),
            'new'     => ContactMessage::where('status', 'new')->count(),
            'read'    => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
        ];

        return view('admin.contact-messages.index', compact('inquiries', 'counts'));
    }

    /**
     * Display single inquiry details
     */
    public function show($id): View
    {
        $inquiry = ContactMessage::findOrFail($id);

        // Auto-mark as read when opened by manager if currently new
        if ($inquiry->status === 'new' || (!$inquiry->status && !$inquiry->is_read)) {
            $inquiry->markAsRead();
        }

        return view('admin.contact-messages.show', compact('inquiry'));
    }

    /**
     * Update the status of an inquiry (new, read, replied)
     */
    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied',
        ]);

        $inquiry = ContactMessage::findOrFail($id);

        switch ($validated['status']) {
            case 'replied':
                $inquiry->markAsReplied();
                break;
            case 'read':
                $inquiry->markAsRead();
                break;
            case 'new':
            default:
                $inquiry->markAsNew();
                break;
        }

        return redirect()->back()->with('success', "Inquiry marked as '" . ucfirst($validated['status']) . "' successfully.");
    }

    /**
     * Delete an inquiry record
     */
    public function destroy($id): RedirectResponse
    {
        $inquiry = ContactMessage::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Inquiry deleted successfully.');
    }
}
