@extends('admin.layouts.app')

@section('title', 'General Customer Inquiries')
@section('page-title', 'Concierge & General Inquiries')

@section('content')
<!-- Header & Summary Strip -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h5 class="mb-1" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
            <i class="fas fa-envelope-open-text me-2"></i> General Contact Inquiries
        </h5>
        <div class="text-muted small">Manage website inquiries, guest requests, and concierge communication.</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </a>
    </div>
</div>

<!-- Status Tabs / Counters -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: {{ !request('status') || request('status') == 'all' ? 'var(--color-champagne)' : '#FFFFFF' }}; border: {{ !request('status') || request('status') == 'all' ? '1.5px solid var(--color-brass-gold)' : '1px solid #E2D5C3' }};">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">All Inquiries</span>
                        <h4 class="mb-0 mt-1 fw-bold text-dark">{{ $counts['total'] }}</h4>
                    </div>
                    <div class="rounded-circle p-2" style="background: rgba(110, 44, 58, 0.1); color: var(--color-burgundy-rose);">
                        <i class="fas fa-inbox fs-5"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.contact-messages.index', ['status' => 'new']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: {{ request('status') == 'new' ? 'var(--color-champagne)' : '#FFFFFF' }}; border: {{ request('status') == 'new' ? '1.5px solid var(--color-burgundy-rose)' : '1px solid #E2D5C3' }};">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">New / Unread</span>
                        <h4 class="mb-0 mt-1 fw-bold text-danger">{{ $counts['new'] }}</h4>
                    </div>
                    <div class="rounded-circle p-2" style="background: rgba(231, 76, 60, 0.1); color: #E74C3C;">
                        <i class="fas fa-envelope fs-5"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.contact-messages.index', ['status' => 'read']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: {{ request('status') == 'read' ? 'var(--color-champagne)' : '#FFFFFF' }}; border: {{ request('status') == 'read' ? '1.5px solid var(--color-info)' : '1px solid #E2D5C3' }};">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Read / In Review</span>
                        <h4 class="mb-0 mt-1 fw-bold text-primary">{{ $counts['read'] }}</h4>
                    </div>
                    <div class="rounded-circle p-2" style="background: rgba(52, 152, 219, 0.1); color: #3498DB;">
                        <i class="fas fa-envelope-open fs-5"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.contact-messages.index', ['status' => 'replied']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: {{ request('status') == 'replied' ? 'var(--color-champagne)' : '#FFFFFF' }}; border: {{ request('status') == 'replied' ? '1.5px solid var(--color-success)' : '1px solid #E2D5C3' }};">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Replied / Closed</span>
                        <h4 class="mb-0 mt-1 fw-bold text-success">{{ $counts['replied'] }}</h4>
                    </div>
                    <div class="rounded-circle p-2" style="background: rgba(39, 174, 96, 0.1); color: #27AE60;">
                        <i class="fas fa-check-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Filters Form -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}">
            <div class="row g-2 align-items-center">
                
                <!-- Search query -->
                <div class="col-md-4">
                    <input 
                        type="text" 
                        class="form-control form-control-sm" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search guest name, email, phone, subject..."
                    >
                </div>

                <!-- Status Filter -->
                <div class="col-md-3">
                    <select class="form-select form-select-sm" name="status">
                        <option value="">All Statuses</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New / Unread</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="col-md-2">
                    <input 
                        type="date" 
                        class="form-control form-control-sm" 
                        name="date_from" 
                        value="{{ request('date_from') }}" 
                        title="From Date"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        type="date" 
                        class="form-control form-control-sm" 
                        name="date_to" 
                        value="{{ request('date_to') }}" 
                        title="To Date"
                    >
                </div>

                <!-- Submit Filter -->
                <div class="col-md-1">
                    <button type="submit" class="btn btn-sm btn-dark w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Inquiries Table Card -->
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background-color: var(--color-champagne); color: var(--color-charcoal-deep); font-size: 13px;">
                <tr>
                    <th class="ps-3 py-3">Guest Details</th>
                    <th class="py-3">Contact Info</th>
                    <th class="py-3">Subject / Purpose</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Received At</th>
                    <th class="pe-3 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody style="font-size: 13.5px;">
                @forelse($inquiries as $inquiry)
                    <tr style="{{ $inquiry->status == 'new' ? 'background-color: rgba(247, 241, 232, 0.45); font-weight: 500;' : '' }}">
                        <td class="ps-3 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; background-color: var(--color-burgundy-rose); font-size: 13px; flex-shrink: 0;">
                                    {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="d-block text-dark fw-bold">{{ $inquiry->name }}</span>
                                    <span class="text-muted small">ID #{{ $inquiry->id }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3">
                            <div><i class="fas fa-envelope text-muted me-1 small"></i> <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none text-dark">{{ $inquiry->email }}</a></div>
                            @if($inquiry->phone)
                                <div class="mt-1"><i class="fas fa-phone text-muted me-1 small"></i> <a href="tel:{{ $inquiry->phone }}" class="text-decoration-none text-muted small">{{ $inquiry->phone }}</a></div>
                            @endif
                        </td>

                        <td class="py-3">
                            <span class="badge px-2 py-1" style="background-color: rgba(184, 138, 68, 0.15); color: #7A5618; border: 1px solid rgba(184, 138, 68, 0.3);">
                                {{ $inquiry->subject ?: 'General Question' }}
                            </span>
                            <div class="text-muted small text-truncate mt-1" style="max-width: 260px;" title="{{ $inquiry->message }}">
                                {{ Str::limit($inquiry->message, 50) }}
                            </div>
                        </td>

                        <td class="py-3">
                            @if($inquiry->status == 'new' || (!$inquiry->status && !$inquiry->is_read))
                                <span class="badge bg-danger rounded-pill px-2 py-1">
                                    <i class="fas fa-circle me-1" style="font-size: 7px;"></i> New
                                </span>
                            @elseif($inquiry->status == 'replied' || $inquiry->is_replied)
                                <span class="badge bg-success rounded-pill px-2 py-1">
                                    <i class="fas fa-check-circle me-1"></i> Replied
                                </span>
                            @else
                                <span class="badge bg-primary rounded-pill px-2 py-1">
                                    <i class="fas fa-envelope-open me-1"></i> Read
                                </span>
                            @endif
                        </td>

                        <td class="py-3 text-muted small">
                            <div>{{ $inquiry->created_at ? $inquiry->created_at->format('d M Y') : 'N/A' }}</div>
                            <div class="small">{{ $inquiry->created_at ? $inquiry->created_at->format('h:i A') : '' }}</div>
                        </td>

                        <td class="pe-3 py-3 text-end">
                            <div class="dropdown d-inline-block">
                                <a href="{{ route('admin.contact-messages.show', $inquiry->id) }}" class="btn btn-sm btn-outline-dark me-1" title="View Full Details">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Status
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 13px;">
                                    <li>
                                        <form method="POST" action="{{ route('admin.contact-messages.update-status', $inquiry->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="new">
                                            <button type="submit" class="dropdown-item {{ $inquiry->status == 'new' ? 'active' : '' }}">
                                                <i class="fas fa-envelope text-danger me-2"></i> Mark as New
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.contact-messages.update-status', $inquiry->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="read">
                                            <button type="submit" class="dropdown-item {{ $inquiry->status == 'read' ? 'active' : '' }}">
                                                <i class="fas fa-envelope-open text-primary me-2"></i> Mark as Read
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.contact-messages.update-status', $inquiry->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="replied">
                                            <button type="submit" class="dropdown-item {{ $inquiry->status == 'replied' ? 'active' : '' }}">
                                                <i class="fas fa-check-circle text-success me-2"></i> Mark as Replied
                                            </button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.contact-messages.destroy', $inquiry->id) }}" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i> Delete Inquiry
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-inbox text-muted mb-3" style="font-size: 48px; opacity: 0.5;"></i>
                                <h5 class="text-muted fw-normal">No customer inquiries found.</h5>
                                <p class="text-muted small mb-0">When guests send an inquiry via the website contact form, it will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inquiries->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                Showing {{ $inquiries->firstItem() }} to {{ $inquiries->lastItem() }} of {{ $inquiries->total() }} inquiries
            </span>
            <div>
                {{ $inquiries->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
