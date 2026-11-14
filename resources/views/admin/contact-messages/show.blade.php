@extends('admin.layouts.app')

@section('title', 'Inquiry Details #' . $inquiry->id)
@section('page-title', 'Inquiry Details #' . $inquiry->id)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-dark btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Inquiries List
    </a>
</div>

<div class="row g-4">
    
    <!-- Left Column: Guest Message Details -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 12px;">
            
            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4 flex-wrap gap-2">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Subject / Purpose</span>
                    <h4 class="mb-0 mt-1" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
                        {{ $inquiry->subject ?: 'General Question' }}
                    </h4>
                </div>
                <div>
                    @if($inquiry->status == 'new' || (!$inquiry->status && !$inquiry->is_read))
                        <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">
                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> New Inquiry
                        </span>
                    @elseif($inquiry->status == 'replied' || $inquiry->is_replied)
                        <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                            <i class="fas fa-check-circle me-1"></i> Replied
                        </span>
                    @else
                        <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                            <i class="fas fa-envelope-open me-1"></i> Read / In Review
                        </span>
                    @endif
                </div>
            </div>

            <!-- Message Content -->
            <div class="mb-4">
                <span class="text-muted small text-uppercase fw-bold d-block mb-2" style="letter-spacing: 0.5px;">Message &amp; Special Requirements:</span>
                <div class="p-3 rounded" style="background-color: var(--color-champagne); border: 1px solid #D8CBB8; border-left: 4px solid var(--color-burgundy-rose); font-size: 14.5px; line-height: 1.8; color: var(--color-charcoal-deep); white-space: pre-line;">
{{ $inquiry->message }}
                </div>
            </div>

            <!-- Fast Contact Actions Strip -->
            <div class="pt-3 border-top mt-auto">
                <span class="text-muted small text-uppercase fw-bold d-block mb-2" style="letter-spacing: 0.5px;">Direct Guest Communication:</span>
                <div class="d-flex flex-wrap gap-2">
                    <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: Hotel Rose Palace Inquiry - ' . ($inquiry->subject ?: 'General Inquiry')) }}" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-envelope me-1"></i> Reply via Email
                    </a>
                    @if($inquiry->phone)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $inquiry->phone) }}?text={{ urlencode('Hello ' . $inquiry->name . ', greetings from Hotel Rose Palace, Surat. Regarding your inquiry...') }}" target="_blank" class="btn btn-sm text-white" style="background-color: #25D366;">
                            <i class="fab fa-whatsapp me-1"></i> Reply on WhatsApp
                        </a>
                        <a href="tel:{{ $inquiry->phone }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-phone me-1"></i> Call {{ $inquiry->phone }}
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Right Column: Guest Information & Management -->
    <div class="col-lg-4">
        
        <!-- Guest Details Card -->
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 12px;">
            <h6 class="border-bottom pb-2 mb-3 fw-bold" style="color: var(--color-charcoal-deep);">
                <i class="fas fa-user me-2 text-muted"></i> Guest Information
            </h6>
            
            <div class="mb-3">
                <span class="text-muted small d-block">Full Name</span>
                <strong class="fs-6 text-dark">{{ $inquiry->name }}</strong>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Email Address</span>
                <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none" style="color: var(--color-burgundy-rose);">{{ $inquiry->email }}</a>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Phone / WhatsApp</span>
                @if($inquiry->phone)
                    <a href="tel:{{ $inquiry->phone }}" class="text-decoration-none text-dark">{{ $inquiry->phone }}</a>
                @else
                    <span class="text-muted small fst-italic">Not provided</span>
                @endif
            </div>

            <div class="mb-0">
                <span class="text-muted small d-block">Received On</span>
                <span class="text-dark small">{{ $inquiry->created_at ? $inquiry->created_at->format('d M Y, h:i A') : 'N/A' }}</span>
                @if($inquiry->created_at)
                    <div class="text-muted" style="font-size: 11px;">({{ $inquiry->created_at->diffForHumans() }})</div>
                @endif
            </div>
        </div>

        <!-- Status Management Card -->
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 12px; background-color: var(--color-champagne); border: 1px solid var(--color-border-subtle);">
            <h6 class="border-bottom pb-2 mb-3 fw-bold" style="color: var(--color-burgundy-rose);">
                <i class="fas fa-tasks me-2"></i> Update Status
            </h6>

            <form method="POST" action="{{ route('admin.contact-messages.update-status', $inquiry->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Current Workflow Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>New / Unread</option>
                        <option value="read" {{ $inquiry->status == 'read' ? 'selected' : '' }}>Read / In Review</option>
                        <option value="replied" {{ $inquiry->status == 'replied' ? 'selected' : '' }}>Replied / Resolved</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-sm text-white w-100" style="background-color: var(--color-burgundy-rose);">
                    <i class="fas fa-save me-1"></i> Update Status
                </button>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="card border-0 shadow-sm p-3" style="border-radius: 12px;">
            <form method="POST" action="{{ route('admin.contact-messages.destroy', $inquiry->id) }}" onsubmit="return confirm('Are you sure you want to permanently delete this inquiry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                    <i class="fas fa-trash me-1"></i> Delete Inquiry
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
