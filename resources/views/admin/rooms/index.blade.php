@extends('admin.layouts.app')

@section('title', 'Manage Rooms & Housekeeping')
@section('page-title', 'Manage Rooms & Housekeeping')

@section('content')
<div class="table-card">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h5 class="mb-1" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
                <i class="fas fa-bed me-2"></i> All Hotel Rooms
            </h5>
            <div class="text-muted small">Monitor real-time room availability and housekeeping hygiene states.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.calendar') }}" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-calendar-alt me-1"></i> Occupancy Calendar
            </a>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-sm text-white px-3" style="background-color: var(--color-burgundy-rose);">
                <i class="fas fa-plus me-1"></i> Add New Room
            </a>
        </div>
    </div>

    @if($rooms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Floor</th>
                        <th>Price</th>
                        <th>Room Status</th>
                        <th>Housekeeping</th>
                        <th>Online Availability</th>
                        <th>Images</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td>
                            <strong class="fs-6" style="color: var(--color-burgundy-rose);">{{ $room->room_number }}</strong>
                        </td>
                        <td>
                            <span class="fw-semibold">{{ $room->roomType->name ?? 'N/A' }}</span>
                        </td>
                        <td>Floor {{ $room->floor }}</td>
                        <td>
                            <span class="fw-bold">₹{{ number_format($room->current_price) }}</span>
                            <small class="text-muted">/night</small>
                        </td>
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
                            <!-- 1-Click Housekeeping Status Toggle Dropdown / Buttons -->
                            <div class="dropdown d-inline-block">
                                @php
                                    $hk = $room->housekeeping_status ?? 'clean';
                                @endphp
                                <button class="badge-housekeeping badge-housekeeping-{{ $hk }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if($hk === 'clean')
                                        <i class="fas fa-sparkles"></i> Clean
                                    @elseif($hk === 'dirty')
                                        <i class="fas fa-broom"></i> Dirty
                                    @else
                                        <i class="fas fa-tools"></i> Maint.
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border p-1" style="font-size: 12px; min-width: 140px;">
                                    <li>
                                        <form action="{{ route('admin.rooms.update-housekeeping', $room) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="housekeeping_status" value="clean">
                                            <button type="submit" class="dropdown-item py-2 text-success {{ $hk === 'clean' ? 'fw-bold bg-light' : '' }}">
                                                <i class="fas fa-check-circle me-2"></i> Mark Clean
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.rooms.update-housekeeping', $room) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="housekeeping_status" value="dirty">
                                            <button type="submit" class="dropdown-item py-2 text-warning-emphasis {{ $hk === 'dirty' ? 'fw-bold bg-light' : '' }}">
                                                <i class="fas fa-broom me-2"></i> Mark Dirty
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.rooms.update-housekeeping', $room) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="housekeeping_status" value="maintenance">
                                            <button type="submit" class="dropdown-item py-2 text-danger {{ $hk === 'maintenance' ? 'fw-bold bg-light' : '' }}">
                                                <i class="fas fa-tools me-2"></i> Maintenance
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.rooms.toggle-availability', $room) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $room->is_available ? 'success' : 'danger' }}" title="Toggle Live Availability">
                                    <i class="fas fa-{{ $room->is_available ? 'check' : 'times' }}"></i>
                                    {{ $room->is_available ? 'Active' : 'Hidden' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($room->image_path && file_exists(public_path($room->image_path)))
                                    <img src="{{ asset($room->image_path) }}" alt="Room {{ $room->room_number }}" class="rounded shadow-sm" style="width: 44px; height: 34px; object-fit: cover; border: 1px solid var(--color-border-subtle);">
                                @endif
                                <span class="badge bg-light text-dark border" style="font-size: 11px;">
                                    {{ $room->images->count() > 0 ? $room->images->count() . ' photo(s)' : ($room->image_path ? 'Photo Linked' : 'No photo') }}
                                </span>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary" title="Edit Room">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure? This will delete all room images.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Room">
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
            <i class="fas fa-bed fa-3x mb-3 text-muted"></i>
            <p>No rooms found. Add your first room to get started.</p>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Add First Room
            </a>
        </div>
    @endif
</div>
@endsection
