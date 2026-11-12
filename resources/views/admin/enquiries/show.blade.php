@extends('admin.layouts.app')

@section('title', 'Enquiry Details')
@section('page-title', 'Enquiry Details - ' . $enquiry->reference_id)

@section('content')
<div class="row g-4">
    <!-- Enquiry Information -->
    <div class="col-md-8">
        <!-- Customer & Booking Details -->
        <div class="table-card mb-4">
            <h5><i class="fas fa-info-circle me-2"></i> Enquiry Information</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Reference ID:</strong>
                    <p class="text-muted">{{ $enquiry->reference_id }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>
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
                        <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}</span>
                    </p>
                </div>
            </div>

            <hr>

            <h6>Customer Details</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <p class="text-muted">{{ $enquiry->customer_name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    <p class="text-muted">{{ $enquiry->customer_email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Phone:</strong>
                    <p class="text-muted">{{ $enquiry->customer_phone }}</p>
                </div>
            </div>

            <hr>

            <h6>Booking Details</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Room Type:</strong>
                    <p class="text-muted">{{ $enquiry->roomType->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Room Price:</strong>
                    <p class="text-muted">₹{{ number_format($enquiry->roomType->base_price ?? 0) }}/night</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Check-in Date:</strong>
                    <p class="text-muted">{{ $enquiry->check_in_date->format('M d, Y (l)') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Check-out Date:</strong>
                    <p class="text-muted">{{ $enquiry->check_out_date->format('M d, Y (l)') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Number of Nights:</strong>
                    <p class="text-muted">{{ $enquiry->check_in_date->diffInDays($enquiry->check_out_date) }} nights</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Estimated Total:</strong>
                    <p class="text-muted">
                        ₹{{ number_format(($enquiry->roomType->base_price ?? 0) * $enquiry->check_in_date->diffInDays($enquiry->check_out_date)) }}
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Adults:</strong>
                    <p class="text-muted"><i class="fas fa-user me-1"></i> {{ $enquiry->num_adults }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Children:</strong>
                    <p class="text-muted"><i class="fas fa-child me-1"></i> {{ $enquiry->num_children }}</p>
                </div>
            </div>

            @if($enquiry->special_requests)
                <hr>
                <h6>Special Requests</h6>
                <p class="text-muted">{{ $enquiry->special_requests }}</p>
            @endif
        </div>

        <!-- Internal Notes -->
        <div class="table-card">
            <h5><i class="fas fa-sticky-note me-2"></i> Internal Notes</h5>
            
            <form action="{{ route('admin.enquiries.update-notes', $enquiry) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-3">
                    <textarea 
                        class="form-control" 
                        name="internal_notes" 
                        rows="4" 
                        placeholder="Add notes about this enquiry (not visible to customer)..."
                    >{{ old('internal_notes', $enquiry->internal_notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Notes
                </button>
            </form>
        </div>
    </div>

    <!-- Actions & Timeline -->
    <div class="col-md-4">
        <!-- Status Management -->
        <div class="table-card mb-4">
            <h5><i class="fas fa-tasks me-2"></i> Update Status</h5>
            
            <form action="{{ route('admin.enquiries.update-status', $enquiry) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-3">
                    <select class="form-select" name="status" required>
                        <option value="">Select new status...</option>
                        <option value="new" {{ $enquiry->status == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ $enquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="availability_confirmed" {{ $enquiry->status == 'availability_confirmed' ? 'selected' : '' }}>Availability Confirmed</option>
                        <option value="booking_confirmed" {{ $enquiry->status == 'booking_confirmed' ? 'selected' : '' }}>Booking Confirmed</option>
                        <option value="cancelled" {{ $enquiry->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="closed" {{ $enquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-check me-2"></i> Update Status
                </button>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="table-card mb-4">
            <h5><i class="fas fa-tools me-2"></i> Quick Actions</h5>
            
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('hotel.whatsapp_number', '')) }}?text=Regarding%20{{ $enquiry->reference_id }}%20-%20{{ urlencode($enquiry->customer_name) }}" 
               target="_blank" 
               class="btn btn-success w-100 mb-2">
                <i class="fab fa-whatsapp me-2"></i> WhatsApp Customer
            </a>

            <a href="mailto:{{ $enquiry->customer_email }}?subject=Regarding%20{{ $enquiry->reference_id }}" class="btn btn-primary w-100 mb-2">
                <i class="fas fa-envelope me-2"></i> Send Email
            </a>

            <a href="tel:{{ $enquiry->customer_phone }}" class="btn btn-info w-100 mb-2">
                <i class="fas fa-phone me-2"></i> Call Customer
            </a>

            <hr>

            <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="fas fa-trash me-2"></i> Delete Enquiry
                </button>
            </form>
        </div>

        <!-- Timeline -->
        <div class="table-card">
            <h5><i class="fas fa-clock me-2"></i> Timeline</h5>
            
            <div class="timeline">
                <div class="timeline-item">
                    <strong>Created:</strong>
                    <p class="text-muted mb-0">{{ $enquiry->created_at->format('M d, Y H:i') }}</p>
                    <small class="text-muted">{{ $enquiry->created_at->diffForHumans() }}</small>
                </div>

                @if($enquiry->whatsapp_message_sent_at)
                    <div class="timeline-item mt-3">
                        <strong>WhatsApp Sent:</strong>
                        <p class="text-muted mb-0">{{ $enquiry->whatsapp_message_sent_at->format('M d, Y H:i') }}</p>
                        <small class="text-muted">{{ $enquiry->whatsapp_message_sent_at->diffForHumans() }}</small>
                    </div>
                @endif

                @if($enquiry->contacted_at)
                    <div class="timeline-item mt-3">
                        <strong>Customer Contacted:</strong>
                        <p class="text-muted mb-0">{{ $enquiry->contacted_at->format('M d, Y H:i') }}</p>
                        <small class="text-muted">{{ $enquiry->contacted_at->diffForHumans() }}</small>
                    </div>
                @endif

                @if($enquiry->confirmed_at)
                    <div class="timeline-item mt-3">
                        <strong>Booking Confirmed:</strong>
                        <p class="text-muted mb-0">{{ $enquiry->confirmed_at->format('M d, Y H:i') }}</p>
                        <small class="text-muted">{{ $enquiry->confirmed_at->diffForHumans() }}</small>
                    </div>
                @endif

                <div class="timeline-item mt-3">
                    <strong>Last Updated:</strong>
                    <p class="text-muted mb-0">{{ $enquiry->updated_at->format('M d, Y H:i') }}</p>
                    <small class="text-muted">{{ $enquiry->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary w-100 mt-3">
            <i class="fas fa-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

<style>
.timeline-item {
    border-left: 3px solid #d4af37;
    padding-left: 15px;
}
</style>
@endsection
