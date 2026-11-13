@extends('admin.layouts.app')

@section('title', 'Occupancy Calendar')
@section('page-title', '14-Day Visual Room Occupancy Calendar')

@section('content')
<div class="calendar-wrapper">
    <!-- Header Control Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 bg-white p-3 rounded-3 shadow-sm border" style="border-color: var(--color-border-subtle) !important;">
        <div class="d-flex align-items-center gap-2">
            @php
                $prevStart = $startDate->copy()->subDays(14)->format('Y-m-d');
                $nextStart = $startDate->copy()->addDays(14)->format('Y-m-d');
                $todayDate = now()->format('Y-m-d');
            @endphp
            <a href="{{ route('admin.calendar', ['start_date' => $prevStart]) }}" class="btn btn-outline-secondary btn-sm px-3">
                <i class="fas fa-chevron-left me-1"></i> Prev 14 Days
            </a>
            <a href="{{ route('admin.calendar', ['start_date' => $todayDate]) }}" class="btn btn-sm {{ $startDate->isToday() ? 'btn-secondary text-white' : 'btn-outline-secondary' }}">
                Today
            </a>
            <a href="{{ route('admin.calendar', ['start_date' => $nextStart]) }}" class="btn btn-outline-secondary btn-sm px-3">
                Next 14 Days <i class="fas fa-chevron-right ms-1"></i>
            </a>

            <form action="{{ route('admin.calendar') }}" method="GET" class="d-flex align-items-center gap-2 ms-2">
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="form-control form-control-sm" style="width: 150px;">
                <button type="submit" class="btn btn-sm btn-outline-dark">Jump</button>
            </form>
        </div>

        <!-- PMS Mini Status Counters -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="fas fa-bed me-1 text-primary"></i> <strong>{{ $totalRooms }}</strong> Rooms
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                <i class="fas fa-sparkles me-1"></i> <strong>{{ $cleanRoomsCount }}</strong> Clean
            </span>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
                <i class="fas fa-broom me-1"></i> <strong>{{ $dirtyRoomsCount }}</strong> Dirty
            </span>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                <i class="fas fa-tools me-1"></i> <strong>{{ $maintRoomsCount }}</strong> Maint.
            </span>
            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-burgundy text-white px-3 ms-2" style="background-color: var(--color-burgundy-rose);">
                <i class="fas fa-plus me-1"></i> New Walk-In
            </a>
        </div>
    </div>

    <!-- Calendar Matrix Container -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 75vh;">
                <table class="table table-bordered mb-0 align-middle calendar-grid-table">
                    <thead class="sticky-top bg-light" style="z-index: 10;">
                        <tr>
                            <!-- Room Header -->
                            <th class="p-3 text-start bg-light" style="min-width: 180px; width: 180px; position: sticky; left: 0; z-index: 11; border-right: 2px solid var(--color-border-subtle);">
                                <span class="text-uppercase small text-muted fw-bold">Room & Status</span>
                            </th>

                            <!-- 14 Date Columns -->
                            @foreach($dates as $date)
                                @php
                                    $isToday = $date->isToday();
                                    $isWeekend = $date->isWeekend();
                                @endphp
                                <th class="text-center p-2 {{ $isToday ? 'bg-primary-subtle border-primary' : ($isWeekend ? 'bg-light-subtle' : '') }}" 
                                    style="min-width: 110px; width: 110px;">
                                    <div class="fw-bold small {{ $isToday ? 'text-primary' : 'text-dark' }}">
                                        {{ $date->format('D') }}
                                    </div>
                                    <div class="fs-6 {{ $isToday ? 'fw-bolder text-primary' : 'fw-semibold text-secondary' }}">
                                        {{ $date->format('d M') }}
                                    </div>
                                    @if($isToday)
                                        <span class="badge bg-primary text-white" style="font-size: 9px; padding: 2px 6px;">TODAY</span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <!-- Sticky Left Room Identifier -->
                                <td class="p-2 ps-3 bg-white" style="position: sticky; left: 0; z-index: 5; border-right: 2px solid var(--color-border-subtle); background-color: var(--color-champagne) !important;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fs-6 fw-bold" style="color: var(--color-burgundy-rose);">Room {{ $room->room_number }}</span>
                                            <div class="small text-muted" style="font-size: 11px;">
                                                {{ $room->roomType->name ?? 'Standard' }} &bull; F{{ $room->floor }}
                                            </div>
                                        </div>
                                        
                                        <!-- Housekeeping Quick Status Badge -->
                                        <span class="badge-housekeeping badge-housekeeping-{{ $room->housekeeping_status ?? 'clean' }}" title="Housekeeping: {{ ucfirst($room->housekeeping_status ?? 'clean') }}">
                                            @if(($room->housekeeping_status ?? 'clean') === 'clean')
                                                <i class="fas fa-check-circle"></i>
                                            @elseif(($room->housekeeping_status ?? 'clean') === 'dirty')
                                                <i class="fas fa-broom"></i>
                                            @else
                                                <i class="fas fa-wrench"></i>
                                            @endif
                                            {{ ucfirst(substr($room->housekeeping_status ?? 'clean', 0, 1)) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- 14 Date Day Cells -->
                                @foreach($dates as $date)
                                    @php
                                        $dateKey = $date->format('Y-m-d');
                                        $booking = $calendarGrid[$room->id][$dateKey] ?? null;
                                        $isToday = $date->isToday();
                                    @endphp

                                    <td class="p-1 text-center {{ $isToday ? 'bg-primary-subtle bg-opacity-25' : '' }}" style="height: 60px; vertical-align: middle;">
                                        @if($booking)
                                            @php
                                                $statusColor = match($booking->status) {
                                                    'checked_in' => '#27ae60',
                                                    'booking_confirmed' => '#6E2C3A',
                                                    'availability_confirmed' => '#B88A44',
                                                    default => '#5E4B4E'
                                                };
                                            @endphp
                                            <a href="{{ route('admin.enquiries.show', $booking) }}" 
                                               class="d-block text-white text-decoration-none p-1 rounded-2 text-truncate text-start shadow-sm"
                                               style="background-color: {{ $statusColor }}; font-size: 11px; line-height: 1.2;"
                                               title="{{ $booking->customer_name }} ({{ $booking->reference_id }}) - {{ ucfirst(str_replace('_', ' ', $booking->status)) }}">
                                                <div class="fw-bold text-truncate">{{ $booking->customer_name }}</div>
                                                <div style="font-size: 9px; opacity: 0.9;">
                                                    {{ $booking->status === 'checked_in' ? '● In-House' : '● Confirmed' }}
                                                </div>
                                            </a>
                                        @else
                                            <span class="text-muted d-block py-2 rounded" style="font-size: 11px; opacity: 0.3;">
                                                &mdash;
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center py-4 text-muted">
                                    No rooms configured yet. <a href="{{ route('admin.rooms.create') }}">Add a room</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Calendar Legend & Help -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 p-3 bg-white rounded-3 border" style="border-color: var(--color-border-subtle) !important;">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="small fw-bold text-muted text-uppercase">Booking Legend:</span>
            <div class="d-flex align-items-center gap-1 small">
                <span style="display:inline-block; width: 14px; height: 14px; background-color: #27ae60; border-radius: 3px;"></span>
                <span>In-House (Checked-In)</span>
            </div>
            <div class="d-flex align-items-center gap-1 small">
                <span style="display:inline-block; width: 14px; height: 14px; background-color: #6E2C3A; border-radius: 3px;"></span>
                <span>Confirmed Reservation</span>
            </div>
            <div class="d-flex align-items-center gap-1 small">
                <span style="display:inline-block; width: 14px; height: 14px; background-color: #B88A44; border-radius: 3px;"></span>
                <span>Hold / Enquiry</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap mt-2 mt-md-0">
            <span class="small fw-bold text-muted text-uppercase">Housekeeping:</span>
            <span class="badge-housekeeping badge-housekeeping-clean"><i class="fas fa-check-circle"></i> Clean</span>
            <span class="badge-housekeeping badge-housekeeping-dirty"><i class="fas fa-broom"></i> Dirty</span>
            <span class="badge-housekeeping badge-housekeeping-maintenance"><i class="fas fa-wrench"></i> Maintenance</span>
        </div>
    </div>
</div>
@endsection
