@extends('admin.layouts.app')

@section('title', 'Manage Rooms')
@section('page-title', 'Manage Rooms')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-bed me-2"></i> All Rooms</h5>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Room
        </a>
    </div>

    @if($rooms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Floor</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Availability</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td><strong>{{ $room->room_number }}</strong></td>
                        <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                        <td>Floor {{ $room->floor }}</td>
                        <td>₹{{ number_format($room->current_price) }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'available' => 'success',
                                    'occupied' => 'danger',
                                    'maintenance' => 'warning',
                                    'reserved' => 'info'
                                ];
                                $color = $statusColors[$room->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ ucfirst($room->status) }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.rooms.toggle-availability', $room) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $room->is_available ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $room->is_available ? 'check' : 'times' }}"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $room->images->count() }} images</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure? This will delete all room images.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Add First Room
            </a>
        </div>
    @endif
</div>
@endsection
