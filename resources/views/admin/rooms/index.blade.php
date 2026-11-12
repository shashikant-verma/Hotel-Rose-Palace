@extends('layouts.admin')

@section('page_title', 'Rooms Management')

@section('content')

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5><i class="fas fa-door-open"></i> Rooms List</h5>
        <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Add Room</a>
    </div>
    
    @if($rooms->count() > 0)
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td><strong>{{ $room->room_number }}</strong></td>
                            <td>{{ $room->roomType->name }}</td>
                            <td>₹{{ number_format($room->current_price) }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $room->is_available ? '#28a745' : '#e74c3c' }};">
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary" style="padding: 4px 8px; font-size: 11px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $rooms->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: #999;">
            <p>No rooms found</p>
        </div>
    @endif
</div>

@endsection
