@extends('layouts.admin')

@section('page_title', 'Enquiries Management')

@section('content')

<div class="admin-card">
    <h5><i class="fas fa-inbox"></i> Enquiries List</h5>
    
    @if($enquiries->count() > 0)
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Guest</th>
                        <th>Room Type</th>
                        <th>Check-in</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enquiries as $enquiry)
                        <tr>
                            <td><strong style="color: var(--gold);">{{ $enquiry->reference_id }}</strong></td>
                            <td>{{ $enquiry->customer_name }}</td>
                            <td>{{ $enquiry->roomType->name }}</td>
                            <td>{{ $enquiry->check_in_date->format('d M, Y') }}</td>
                            <td>
                                <span class="badge bg-primary">{{ ucfirst($enquiry->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 11px;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $enquiries->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: #999;">
            <p>No enquiries found</p>
        </div>
    @endif
</div>

@endsection
