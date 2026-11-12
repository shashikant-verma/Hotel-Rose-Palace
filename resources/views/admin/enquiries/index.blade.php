@extends('admin.layouts.app')

@section('title', 'Manage Enquiries')
@section('page-title', 'Manage Enquiries')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-envelope me-2"></i> All Enquiries</h5>
        <div>
            <input type="text" class="form-control" placeholder="Search enquiries..." style="min-width: 250px;">
        </div>
    </div>

    @if($enquiries->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Guest Details</th>
                        <th>Room Type</th>
                        <th>Dates</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enquiries as $enquiry)
                    <tr>
                        <td><strong>{{ $enquiry->reference_id }}</strong></td>
                        <td>
                            {{ $enquiry->guest_name }}<br>
                            <small class="text-muted">{{ $enquiry->guest_email }}</small><br>
                            <small class="text-muted">{{ $enquiry->guest_phone }}</small>
                        </td>
                        <td>{{ $enquiry->roomType->name ?? 'N/A' }}</td>
                        <td>
                            <strong>In:</strong> {{ $enquiry->check_in_date->format('M d, Y') }}<br>
                            <strong>Out:</strong> {{ $enquiry->check_out_date->format('M d, Y') }}
                        </td>
                        <td>
                            Adults: {{ $enquiry->adults }}<br>
                            Children: {{ $enquiry->children }}
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'new' => 'primary',
                                    'contacted' => 'info',
                                    'confirmed' => 'success',
                                    'cancelled' => 'danger',
                                    'completed' => 'secondary'
                                ];
                                $color = $statusColors[$enquiry->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ ucfirst($enquiry->status) }}</span>
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
        </div>
    @endif
</div>
@endsection
