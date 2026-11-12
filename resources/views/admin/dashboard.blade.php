@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<!-- Statistics Row -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #999; margin: 0 0 5px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Total Enquiries</p>
                    <h3 style="margin: 0; color: var(--primary-navy); font-size: 32px; font-weight: 700;">{{ $totalEnquiries }}</h3>
                </div>
                <div style="font-size: 32px; color: var(--gold); opacity: 0.2;">
                    <i class="fas fa-inbox"></i>
                </div>
            </div>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; font-size: 13px; color: #999;">
                <i class="fas fa-arrow-up" style="color: #27ae60;"></i> All time
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #999; margin: 0 0 5px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">New Enquiries</p>
                    <h3 style="margin: 0; color: #e74c3c; font-size: 32px; font-weight: 700;">{{ $newEnquiries }}</h3>
                </div>
                <div style="font-size: 32px; color: #e74c3c; opacity: 0.2;">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; font-size: 13px; color: #999;">
                <i class="fas fa-clock"></i> Pending response
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #999; margin: 0 0 5px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Confirmed</p>
                    <h3 style="margin: 0; color: #27ae60; font-size: 32px; font-weight: 700;">{{ $confirmedBookings }}</h3>
                </div>
                <div style="font-size: 32px; color: #27ae60; opacity: 0.2;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; font-size: 13px; color: #999;">
                <i class="fas fa-calendar-check"></i> Booking confirmed
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #999; margin: 0 0 5px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Room Types</p>
                    <h3 style="margin: 0; color: var(--gold); font-size: 32px; font-weight: 700;">{{ $totalRoomTypes }}</h3>
                </div>
                <div style="font-size: 32px; color: var(--gold); opacity: 0.2;">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; font-size: 13px; color: #999;">
                <i class="fas fa-th-large"></i> Active rooms
            </div>
        </div>
    </div>
</div>

<!-- Recent Enquiries Section -->
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h5><i class="fas fa-inbox"></i> Recent Enquiries</h5>
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if($recentEnquiries->count() > 0)
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
                            @foreach($recentEnquiries as $enquiry)
                                <tr>
                                    <td>
                                        <strong style="color: var(--gold);">{{ $enquiry->reference_id }}</strong>
                                    </td>
                                    <td>
                                        {{ $enquiry->customer_name }}<br>
                                        <small style="color: #999;">{{ $enquiry->customer_phone }}</small>
                                    </td>
                                    <td>{{ $enquiry->roomType->name }}</td>
                                    <td>{{ $enquiry->check_in_date->format('d M, Y') }}</td>
                                    <td>
                                        @php
                                            $statusBadges = [
                                                'new' => 'badge bg-primary',
                                                'contacted' => 'badge bg-info',
                                                'availability_confirmed' => 'badge bg-warning text-dark',
                                                'booking_confirmed' => 'badge bg-success',
                                                'cancelled' => 'badge bg-danger',
                                                'closed' => 'badge bg-secondary',
                                            ];
                                        @endphp
                                        <span class="{{ $statusBadges[$enquiry->status] ?? 'badge bg-secondary' }}">
                                            {{ str_replace('_', ' ', ucfirst($enquiry->status)) }}
                                        </span>
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
            @else
                <div style="text-align: center; padding: 40px; color: #999;">
                    <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.2; display: block; margin-bottom: 10px;"></i>
                    <p>No enquiries yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="col-lg-4">
        <div class="admin-card">
            <h5><i class="fas fa-chart-pie"></i> Enquiry Status</h5>

            @if(count($enquiryStatuses) > 0)
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @php
                        $statusLabels = [
                            'new' => 'New',
                            'contacted' => 'Contacted',
                            'availability_confirmed' => 'Availability Confirmed',
                            'booking_confirmed' => 'Booking Confirmed',
                            'cancelled' => 'Cancelled',
                            'closed' => 'Closed',
                        ];
                        
                        $statusColors = [
                            'new' => '#007bff',
                            'contacted' => '#17a2b8',
                            'availability_confirmed' => '#ffc107',
                            'booking_confirmed' => '#28a745',
                            'cancelled' => '#dc3545',
                            'closed' => '#6c757d',
                        ];
                        
                        $total = array_sum($enquiryStatuses);
                    @endphp

                    @foreach($enquiryStatuses as $status => $count)
                        @php $percentage = $total > 0 ? round(($count / $total) * 100) : 0; @endphp
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span style="font-size: 13px;">{{ $statusLabels[$status] ?? $status }}</span>
                                <strong style="font-size: 13px;">{{ $count }} ({{ $percentage }}%)</strong>
                            </div>
                            <div style="width: 100%; height: 8px; background-color: #f0f0f0; border-radius: 4px; overflow: hidden;">
                                <div style="height: 100%; width: {{ $percentage }}%; background-color: {{ $statusColors[$status] ?? '#999' }}; transition: width 0.3s ease;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 20px; color: #999;">
                    <p>No data available</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="admin-card">
            <h5><i class="fas fa-rocket"></i> Quick Actions</h5>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-primary" style="text-align: left; justify-content: flex-start;">
                    <i class="fas fa-envelope"></i> View All Enquiries
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary" style="text-align: left; justify-content: flex-start;">
                    <i class="fas fa-door-open"></i> Manage Rooms
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-primary" style="text-align: left; justify-content: flex-start;">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
