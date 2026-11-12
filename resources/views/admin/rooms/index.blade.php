@extends('admin.layouts.app')

@section('title', 'Manage Rooms')
@section('page-title', 'Manage Rooms')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-bed me-2"></i> All Rooms</h5>
        <button class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Room
        </button>
    </div>

    @if($rooms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Floor</th>
                        <th>Availability</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td><strong>{{ $room->room_number }}</strong></td>
                        <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>
                            @if($room->is_available)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">Not Available</span>
                            @endif
                        </td>
                        <td>{{ $room->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $rooms->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bed fa-3x mb-3"></i>
            <p>No rooms found. Add your first room to get started.</p>
            <button class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Add First Room
            </button>
        </div>
    @endif
</div>
@endsection
