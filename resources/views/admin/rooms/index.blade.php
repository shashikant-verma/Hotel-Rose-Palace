@extends('admin.layouts.app')

@section('title', 'Manage Rooms & Housekeeping')
@section('page-title', 'Manage Rooms & Housekeeping')

@section('content')
<div class="table-card">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h5 class="mb-1" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
                <i class="fas fa-bed me-2"></i> Physical Room Inventory (15 Rooms)
            </h5>
            <div class="text-muted small">Manage all 15 physical rooms across Deluxe Family (5) and Executive (10) categories.</div>
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

    {{-- Room Inventory Stats Ribbon --}}
    @if(isset($stats))
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card p-3 border-0 shadow-sm" style="background: rgba(110,44,58,0.06); border-left: 4px solid var(--color-burgundy-rose) !important;">
                <span class="text-muted small text-uppercase fw-bold">Total Rooms</span>
                <div class="fs-4 fw-bold" style="color: var(--color-burgundy-rose);">{{ $stats['total'] }}</div>
                <small class="text-muted">15 Physical Units</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 border-0 shadow-sm" style="background: rgba(184,138,68,0.08); border-left: 4px solid var(--color-gold) !important;">
                <span class="text-muted small text-uppercase fw-bold">Deluxe Family</span>
                <div class="fs-4 fw-bold" style="color: var(--color-burgundy-rose);">{{ $stats['deluxe'] }}</div>
                <small class="text-muted">₹1,200/night (Rooms 101–105)</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 border-0 shadow-sm" style="background: rgba(184,138,68,0.08); border-left: 4px solid var(--color-gold) !important;">
                <span class="text-muted small text-uppercase fw-bold">Executive Room</span>
                <div class="fs-4 fw-bold" style="color: var(--color-burgundy-rose);">{{ $stats['executive'] }}</div>
                <small class="text-muted">₹1,100/night (Rooms 106–115)</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 border-0 shadow-sm" style="background: rgba(40,167,69,0.08); border-left: 4px solid #28a745 !important;">
                <span class="text-muted small text-uppercase fw-bold">Available Now</span>
                <div class="fs-4 fw-bold text-success">{{ $stats['available'] }}</div>
                <small class="text-muted">{{ $stats['occupied'] }} occupied · {{ $stats['maintenance'] }} maint.</small>
            </div>
        </div>
    </div>
    @endif

    {{-- Filter Toolbar --}}
    <form method="GET" action="{{ route('admin.rooms.index') }}" class="card p-3 mb-4 bg-light border-0">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <label class="form-label small fw-bold mb-1 text-muted">Filter by Room Category</label>
                <select name="room_type_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Categories (Deluxe & Executive)</option>
                    @if(isset($roomTypes))
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ request('room_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} (₹{{ number_format($type->base_price, 0) }})
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold mb-1 text-muted">Filter by Status</label>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </div>
            <div class="col-md-5 d-flex align-items-end gap-2 mt-md-0 mt-2">
                <button type="submit" class="btn btn-sm btn-dark px-3">
                    <i class="fas fa-filter me-1"></i> Apply Filters
                </button>
                @if(request()->hasAny(['room_type_id', 'status']))
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Reset
                    </a>
                @endif
            </div>
        </div>
    </form>

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
