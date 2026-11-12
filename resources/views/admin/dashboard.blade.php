@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Statistics Cards Row -->
<div class="row g-4 mb-4">
    <!-- Total Enquiries -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-gold-light">
                <i class="fas fa-envelope"></i>
            </div>
            <h3>{{ $stats['total_enquiries'] }}</h3>
            <p>Total Enquiries</p>
        </div>
    </div>

    <!-- New Enquiries -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <i class="fas fa-envelope-open"></i>
            </div>
            <h3>{{ $stats['new_enquiries'] }}</h3>
            <p>New Enquiries</p>
        </div>
    </div>

    <!-- Total Rooms -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <i class="fas fa-bed"></i>
            </div>
            <h3>{{ $stats['total_rooms'] }}</h3>
            <p>Total Rooms</p>
        </div>
    </div>

    <!-- Available Rooms -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-red-light">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>{{ $stats['available_rooms'] }}</h3>
            <p>Available Rooms</p>
        </div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="row g-4 mb-4">
    <!-- Room Types -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <i class="fas fa-layer-group"></i>
            </div>
            <h3>{{ $stats['total_room_types'] }}</h3>
            <p>Room Categories</p>
        </div>
    </div>

    <!-- Gallery Images -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-gold-light">
                <i class="fas fa-images"></i>
            </div>
            <h3>{{ $stats['gallery_images'] }}</h3>
            <p>Gallery Images</p>
        </div>
    </div>

    <!-- Last Login -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <i class="fas fa-clock"></i>
            </div>
            <h3 style="font-size: 18px;">{{ Auth::user()->last_login_at?->format('M d, H:i') ?? 'First Login' }}</h3>
            <p>Last Login</p>
        </div>
    </div>
</div>

<!-- Charts and Tables Row -->
<div class="row g-4">
    <!-- Recent Enquiries -->
    <div class="col-md-8">
        <div class="table-card">
            <h5><i class="fas fa-envelope me-2"></i> Recent Enquiries</h5>
            
            @if($recentEnquiries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Guest</th>
                                <th>Room Type</th>
                                <th>Check-in</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEnquiries as $enquiry)
                            <tr>
                                <td><strong>{{ $enquiry->reference_id }}</strong></td>
                                <td>
                                    {{ $enquiry->guest_name }}<br>
                                    <small class="text-muted">{{ $enquiry->guest_email }}</small>
                                </td>
                                <td>{{ $enquiry->roomType->name ?? 'N/A' }}</td>
                                <td>{{ $enquiry->check_in_date->format('M d, Y') }}</td>
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

                <div class="text-center mt-3">
                    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-primary">
                        View All Enquiries <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>No enquiries yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Enquiries by Status -->
    <div class="col-md-4">
        <div class="table-card">
            <h5><i class="fas fa-chart-pie me-2"></i> Enquiries by Status</h5>
            
            @if(count($enquiriesByStatus) > 0)
                <div class="list-group list-group-flush">
                    @foreach($enquiriesByStatus as $status => $count)
                        @php
                            $statusColors = [
                                'new' => 'primary',
                                'contacted' => 'info',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'secondary'
                            ];
                            $color = $statusColors[$status] ?? 'secondary';
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <span class="badge bg-{{ $color }} me-2">{{ ucfirst($status) }}</span>
                            </span>
                            <strong>{{ $count }}</strong>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <p>No data available</p>
                </div>
            @endif
        </div>

        <!-- Top Room Types -->
        <div class="table-card mt-4">
            <h5><i class="fas fa-star me-2"></i> Popular Room Types</h5>
            
            @if(count($enquiriesByRoomType) > 0)
                <div class="list-group list-group-flush">
                    @foreach($enquiriesByRoomType as $roomType => $count)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $roomType }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <p>No data available</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="table-card">
            <h5><i class="fas fa-bolt me-2"></i> Quick Actions</h5>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-primary">
                    <i class="fas fa-envelope me-2"></i> Manage Enquiries
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-success">
                    <i class="fas fa-bed me-2"></i> Manage Rooms
                </a>
                <a href="{{ route('admin.room-types.index') }}" class="btn btn-info">
                    <i class="fas fa-layer-group me-2"></i> Manage Room Types
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-warning">
                    <i class="fas fa-cog me-2"></i> Website Settings
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary" target="_blank">
                    <i class="fas fa-globe me-2"></i> View Website
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
