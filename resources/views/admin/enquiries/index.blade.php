@extends('admin.layouts.app')

@section('title', 'Manage Enquiries')
@section('page-title', 'Manage Enquiries')

@section('content')
<!-- Filters and Search -->
<div class="table-card mb-4">
    <form method="GET" action="{{ route('admin.enquiries.index') }}" id="filter-form">
        <div class="row g-3">
            <!-- Search -->
            <div class="col-md-3">
                <input 
                    type="text" 
                    class="form-control" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search reference, name, email, phone..."
                >
            </div>

            <!-- Status Filter -->
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Room Type Filter -->
            <div class="col-md-2">
                <select class="form-select" name="room_type">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}" {{ request('room_type') == $roomType->id ? 'selected' : '' }}>
                            {{ $roomType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div class="col-md-2">
                <input 
                    type="date" 
                    class="form-control" 
                    name="date_from" 
                    value="{{ request('date_from') }}" 
                    placeholder="Check-in from"
                >
            </div>

            <!-- Date To -->
            <div class="col-md-2">
                <input 
                    type="date" 
                    class="form-control" 
                    name="date_to" 
                    value="{{ request('date_to') }}" 
                    placeholder="Check-in to"
                >
            </div>

            <!-- Buttons -->
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex gap-3 flex-wrap">
                    <small class="text-muted">
                        <strong>Total:</strong> {{ $enquiries->total() }}
                    </small>
                    @if(request()->hasAny(['search', 'status', 'room_type', 'date_from', 'date_to']))
                        <a href="{{ route('admin.enquiries.index') }}" class="text-primary small">
                            <i class="fas fa-times-circle me-1"></i> Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Bulk Actions -->
<form method="POST" id="bulk-form">
    @csrf
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0"><i class="fas fa-envelope me-2"></i> Enquiries List</h5>
            
            <div class="d-flex gap-2">
                <!-- Export -->
                <a href="{{ route('admin.enquiries.export', request()->all()) }}" class="btn btn-success">
                    <i class="fas fa-file-export me-2"></i> Export CSV
                </a>

                <!-- Bulk Actions -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-tasks me-2"></i> Bulk Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li><h6 class="dropdown-header">Update Status</h6></li>
                        @foreach($statuses as $value => $label)
                            <li>
                                <a class="dropdown-item" href="#" onclick="bulkAction('status', '{{ $value }}')">
                                    Set as {{ $label }}
                                </a>
                            </li>
                        @endforeach
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                                <i class="fas fa-trash me-2"></i> Delete Selected
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if($enquiries->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>Reference</th>
                            <th>Customer Details</th>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $enquiry)
                        <tr>
                            <td>
                                <input 
                                    type="checkbox" 
                                    class="form-check-input enquiry-checkbox" 
                                    name="enquiry_ids[]" 
                                    value="{{ $enquiry->id }}"
                                >
                            </td>
                            <td><strong>{{ $enquiry->reference_id }}</strong></td>
                            <td>
                                <strong>{{ $enquiry->customer_name }}</strong><br>
                                <small class="text-muted">{{ $enquiry->customer_email }}</small><br>
                                <small class="text-muted">{{ $enquiry->customer_phone }}</small>
                            </td>
                            <td>{{ $enquiry->roomType->name ?? 'N/A' }}</td>
                            <td>
                                {{ $enquiry->check_in_date->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $enquiry->check_in_date->diffInDays($enquiry->check_out_date) }} nights</small>
                            </td>
                            <td>
                                <i class="fas fa-user"></i> {{ $enquiry->num_adults }}<br>
                                <small class="text-muted"><i class="fas fa-child"></i> {{ $enquiry->num_children }}</small>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'new' => 'primary',
                                        'contacted' => 'info',
                                        'availability_confirmed' => 'warning',
                                        'booking_confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        'closed' => 'secondary'
                                    ];
                                    $color = $statusColors[$enquiry->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $statuses[$enquiry->status] ?? ucfirst($enquiry->status) }}</span>
                            </td>
                            <td>{{ $enquiry->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $enquiries->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>No enquiries found</p>
                @if(request()->hasAny(['search', 'status', 'room_type', 'date_from', 'date_to']))
                    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-primary">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</form>
@endsection

@push('scripts')
<script>
// Select all checkboxes
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.enquiry-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Bulk actions
function bulkAction(action, value = null) {
    const checkboxes = document.querySelectorAll('.enquiry-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Please select at least one enquiry');
        return false;
    }

    const form = document.getElementById('bulk-form');
    
    if (action === 'status') {
        if (confirm(`Update ${checkboxes.length} enquiry(ies) to status: ${value}?`)) {
            form.action = '{{ route("admin.enquiries.bulk-status") }}';
            
            // Add status hidden input
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = value;
            form.appendChild(statusInput);
            
            form.submit();
        }
    } else if (action === 'delete') {
        if (confirm(`Are you sure you want to delete ${checkboxes.length} enquiry(ies)? This cannot be undone.`)) {
            form.action = '{{ route("admin.enquiries.bulk-delete") }}';
            form.submit();
        }
    }
    
    return false;
}

// Auto-submit filters on change
document.querySelectorAll('#filter-form select').forEach(select => {
    select.addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });
});
</script>
@endpush
