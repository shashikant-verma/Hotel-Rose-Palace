@extends('admin.layouts.app')

@section('title', 'Analytics & Performance Tracking')
@section('page-title', 'Business Analytics & Performance Intelligence')

@section('content')
<div class="container-fluid px-0">

    <!-- ═══════════════════════════════════════════════════════════════════════
         1. TOP HEADER & DATE RANGE FILTER BAR
         ═══════════════════════════════════════════════════════════════════════ -->
    <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border mb-4" style="border-color: var(--color-border-subtle) !important;">
        <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-3">
            <div>
                <h4 class="mb-1 fw-bold" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
                    <i class="fas fa-chart-pie me-2"></i> Hotel Performance Analytics
                </h4>
                <div class="text-muted small">
                    <span class="badge text-dark bg-light border me-2">
                        <i class="fas fa-clock text-secondary me-1"></i> Timezone: Asia/Kolkata (IST)
                    </span>
                    <span>
                        Reporting Period: <strong>{{ $range['start_local']->format('d M Y') }}</strong> to <strong>{{ $range['end_local']->format('d M Y') }}</strong>
                        ({{ (int) $range['days_count'] }} {{ Str::plural('day', (int) $range['days_count']) }})
                    </span>
                </div>
            </div>

            <!-- Export Buttons Dropdown -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-sm text-white dropdown-toggle px-3" type="button" data-bs-toggle="dropdown" style="background-color: var(--color-burgundy-rose);">
                        <i class="fas fa-file-export me-1"></i> Download Reports
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 260px;">
                        <li><h6 class="dropdown-header text-uppercase text-muted small fw-bold">CSV Reports (Excel)</h6></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.analytics.export', ['type' => 'bookings'] + request()->all()) }}"><i class="fas fa-concierge-bell me-2 text-primary"></i> Bookings Master CSV</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.analytics.export', ['type' => 'revenue'] + request()->all()) }}"><i class="fas fa-coins me-2 text-success"></i> Daily Revenue CSV</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.analytics.export', ['type' => 'payments'] + request()->all()) }}"><i class="fas fa-credit-card me-2 text-info"></i> Payment Transactions CSV</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.analytics.export', ['type' => 'cancellations'] + request()->all()) }}"><i class="fas fa-undo-alt me-2 text-danger"></i> Cancellations &amp; Refunds CSV</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.analytics.export', ['type' => 'occupancy'] + request()->all()) }}"><i class="fas fa-bed me-2 text-warning"></i> Room Occupancy CSV</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.analytics.export', ['type' => 'inquiries'] + request()->all()) }}"><i class="fas fa-envelope-open-text me-2 text-secondary"></i> Inquiries &amp; Attribution CSV</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header text-uppercase text-muted small fw-bold">Printable PDF Layouts</h6></li>
                        <li><a class="dropdown-item py-2" target="_blank" href="{{ route('admin.analytics.export', ['type' => 'bookings', 'format' => 'print'] + request()->all()) }}"><i class="fas fa-print me-2 text-dark"></i> Print Bookings Summary</a></li>
                        <li><a class="dropdown-item py-2" target="_blank" href="{{ route('admin.analytics.export', ['type' => 'revenue', 'format' => 'print'] + request()->all()) }}"><i class="fas fa-print me-2 text-dark"></i> Print Financial Summary</a></li>
                        <li><a class="dropdown-item py-2" target="_blank" href="{{ route('admin.analytics.export', ['type' => 'occupancy', 'format' => 'print'] + request()->all()) }}"><i class="fas fa-print me-2 text-dark"></i> Print Occupancy Summary</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="my-3 text-muted opacity-25">

        <!-- Date Range Filter Form -->
        <form method="GET" action="{{ route('admin.analytics.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-auto d-flex flex-wrap gap-1">
                @php
                    $presets = [
                        'today' => 'Today',
                        'yesterday' => 'Yesterday',
                        'last_7_days' => 'Last 7 Days',
                        'last_30_days' => 'Last 30 Days',
                        'this_month' => 'This Month',
                        'last_month' => 'Last Month',
                        'this_year' => 'This Year',
                    ];
                @endphp
                @foreach($presets as $key => $label)
                    <a href="{{ route('admin.analytics.index', ['preset' => $key]) }}"
                       class="btn btn-sm {{ $range['preset'] === $key ? 'text-white' : 'btn-outline-secondary' }}"
                       style="{{ $range['preset'] === $key ? 'background-color: var(--color-burgundy-rose); border-color: var(--color-burgundy-rose);' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="col-12 col-md-auto ms-xl-auto d-flex flex-wrap align-items-center gap-2">
                <input type="hidden" name="preset" value="custom">
                <div class="input-group input-group-sm" style="max-width: 160px;">
                    <span class="input-group-text bg-light border"><i class="fas fa-calendar fa-xs text-muted"></i></span>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', $range['start_local']->format('Y-m-d')) }}" required>
                </div>
                <span class="text-muted small">to</span>
                <div class="input-group input-group-sm" style="max-width: 160px;">
                    <span class="input-group-text bg-light border"><i class="fas fa-calendar fa-xs text-muted"></i></span>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', $range['end_local']->format('Y-m-d')) }}" required>
                </div>
                <button type="submit" class="btn btn-sm btn-dark px-3">
                    <i class="fas fa-filter fa-xs me-1"></i> Filter
                </button>
                @if(request()->hasAny(['preset', 'start_date', 'end_date']))
                    <a href="{{ route('admin.analytics.index') }}" class="btn btn-sm btn-outline-danger" title="Reset filter to default 30 days">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════════
         2. PRIMARY EXECUTIVE KPI CARDS (ROWS 1 & 2)
         ═══════════════════════════════════════════════════════════════════════ -->
    <div class="row g-3 mb-4">
        <!-- Net Collected Revenue -->
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Net Revenue</div>
                        <div class="fs-3 fw-bold mt-1 {{ $kpis['net_revenue'] < 0 ? 'text-danger' : '' }}" style="{{ $kpis['net_revenue'] >= 0 ? 'color: var(--color-burgundy-rose);' : '' }}">
                            {{ $kpis['net_revenue'] < 0 ? '-₹' . number_format(abs($kpis['net_revenue']), 2) : '₹' . number_format($kpis['net_revenue'], 2) }}
                        </div>
                        <div class="small text-muted mt-1">
                            Gross: ₹{{ number_format($kpis['gross_revenue'], 0) }} &bull; Ref: ₹{{ number_format($kpis['total_refunds'], 0) }}
                            @if($kpis['net_revenue'] < 0)
                                <span class="badge bg-danger-subtle text-danger ms-1">Net Outflow</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-3 rounded-circle text-white shadow-sm" style="background-color: var(--color-burgundy-rose);">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Confirmed Bookings -->
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Confirmed Bookings</div>
                        <div class="fs-3 fw-bold mt-1 text-success">
                            {{ $kpis['confirmed_bookings'] }}
                            <span class="fs-6 text-muted fw-normal">/ {{ $kpis['total_bookings'] }} total</span>
                        </div>
                        <div class="small text-muted mt-1">
                            <span class="text-warning-emphasis fw-semibold">{{ $kpis['pending_bookings'] }} Pending</span> &bull;
                            <span class="text-danger fw-semibold">{{ $kpis['cancelled_bookings'] }} Cancelled</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-circle bg-success-subtle text-success">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Occupancy % -->
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Room Occupancy</div>
                        <div class="fs-3 fw-bold mt-1" style="color: var(--color-brass-gold);">
                            {{ $kpis['occupancy_percentage'] }}%
                        </div>
                        <div class="small text-muted mt-1">
                            {{ $kpis['occupied_room_nights'] }} of {{ $kpis['available_room_nights'] }} room-nights
                        </div>
                    </div>
                    <div class="p-3 rounded-circle text-white" style="background-color: var(--color-brass-gold);">
                        <i class="fas fa-hotel fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Booking Value (ABV) -->
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-white rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Avg Booking Value</div>
                        <div class="fs-3 fw-bold mt-1 text-primary">
                            ₹{{ number_format($kpis['average_booking_value'], 2) }}
                        </div>
                        <div class="small text-muted mt-1">
                            Per confirmed paid reservation
                        </div>
                    </div>
                    <div class="p-3 rounded-circle bg-primary-subtle text-primary">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Metric Badges Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="p-2 px-3 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fas fa-receipt me-1 text-success"></i> Captured Payments:</span>
                <span class="fw-bold">{{ $kpis['total_payments_count'] }} transactions</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-2 px-3 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fas fa-stopwatch me-1 text-warning"></i> Active Holds (30m):</span>
                <span class="badge bg-warning text-dark">{{ $kpis['active_temporary_holds'] }} rooms held</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-2 px-3 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fas fa-envelope me-1 text-info"></i> Total Inquiries:</span>
                <span class="fw-bold">{{ $kpis['total_inquiries'] }} messages</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-2 px-3 bg-white rounded-3 border d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="fas fa-link me-1 text-purple" style="color: #6f42c1;"></i> Matched Conversions:</span>
                <span class="badge text-white" style="background-color: #6f42c1;">{{ $inquiries['matched_conversions'] }} ({{ $inquiries['conversion_rate'] }}%)</span>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════════
         3. REVENUE & PAYMENT ANALYTICS (CHART & BREAKDOWN)
         ═══════════════════════════════════════════════════════════════════════ -->
    <div class="row g-4 mb-4">
        <!-- Revenue Timeline Chart -->
        <div class="col-lg-8">
            <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: var(--color-charcoal-deep); font-family: var(--font-heading);">
                        <i class="fas fa-chart-area me-2" style="color: var(--color-burgundy-rose);"></i> Revenue &amp; Cash Flow Timeline
                    </h5>
                    <span class="badge bg-light text-muted border">Daily Trend</span>
                </div>
                <div style="position: relative; height: 310px;">
                    <canvas id="revenueTimelineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Breakdown Cards -->
        <div class="col-lg-4">
            <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <h5 class="fw-bold mb-3" style="color: var(--color-charcoal-deep); font-family: var(--font-heading);">
                    <i class="fas fa-credit-card me-2" style="color: var(--color-burgundy-rose);"></i> Gateway Payment Stats
                </h5>

                <div class="list-group list-group-flush mb-3">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="small"><i class="fas fa-check-circle text-success me-2"></i> Successful Payments</span>
                        <span class="badge bg-success-subtle text-success fw-bold">{{ $revenue['successful_count'] }} (₹{{ number_format($revenue['gross_amount'], 2) }})</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="small"><i class="fas fa-clock text-warning me-2"></i> Pending / Authorized</span>
                        <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">{{ $revenue['pending_count'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="small"><i class="fas fa-times-circle text-danger me-2"></i> Failed Gateway Attempts</span>
                        <span class="badge bg-danger-subtle text-danger fw-bold">{{ $revenue['failed_count'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="small"><i class="fas fa-calculator text-primary me-2"></i> Average Transaction Ticket</span>
                        <span class="fw-bold">₹{{ number_format($revenue['average_payment'], 2) }}</span>
                    </div>
                </div>

                <h6 class="fw-bold small text-muted text-uppercase mb-2" style="letter-spacing: 0.5px;">Payment Method Breakdown</h6>
                @if(count($revenue['method_breakdown']) > 0)
                    <div style="position: relative; height: 140px;">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted small py-4 bg-light rounded-3">
                        <i class="fas fa-info-circle me-1"></i> No captured payments in selected period.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════════
         4. OCCUPANCY & ROOM INVENTORY PERFORMANCE
         ═══════════════════════════════════════════════════════════════════════ -->
    <div class="row g-4 mb-4">
        <!-- Room Category Popularity & Revenue -->
        <div class="col-lg-7">
            <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: var(--color-charcoal-deep); font-family: var(--font-heading);">
                        <i class="fas fa-layer-group me-2" style="color: var(--color-burgundy-rose);"></i> Room Category Performance
                    </h5>
                    <span class="badge bg-light text-muted border">Confirmed Bookings</span>
                </div>

                @if(count($bookings['category_breakdown']) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase small text-muted">
                                    <th>Room Category</th>
                                    <th class="text-center">Bookings</th>
                                    <th class="text-center">Rooms Reserved</th>
                                    <th class="text-end">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings['category_breakdown'] as $cat)
                                    <tr>
                                        <td class="fw-semibold">
                                            <i class="fas fa-door-open text-muted me-2"></i>{{ $cat['name'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">{{ $cat['bookings_count'] }}</span>
                                        </td>
                                        <td class="text-center">{{ $cat['total_rooms'] }}</td>
                                        <td class="text-end fw-bold" style="color: var(--color-burgundy-rose);">
                                            ₹{{ number_format($cat['total_revenue'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-5 bg-light rounded-3">
                        <i class="fas fa-bed fa-2x mb-2 text-secondary"></i>
                        <p class="mb-0">No confirmed bookings recorded in this date range.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Occupancy Breakdown & Policy Notice -->
        <div class="col-lg-5">
            <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <h5 class="fw-bold mb-3" style="color: var(--color-charcoal-deep); font-family: var(--font-heading);">
                    <i class="fas fa-bed me-2" style="color: var(--color-burgundy-rose);"></i> Room Occupancy &amp; Policy
                </h5>

                <div class="p-3 rounded-3 mb-3" style="background-color: var(--color-champagne); border: 1px solid var(--color-border-subtle);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-uppercase" style="color: var(--color-burgundy-rose);">Physical Room Inventory</span>
                        <span class="badge bg-dark">{{ $occupancy['total_rooms'] }} Rooms</span>
                    </div>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ min(100, $occupancy['occupancy_rate']) }}%; background-color: var(--color-burgundy-rose);"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small">
                        <span>Rate: <strong>{{ $occupancy['occupancy_rate'] }}%</strong></span>
                        <span>{{ $occupancy['occupied_room_nights'] }} / {{ $occupancy['available_room_nights'] }} Room-Nights</span>
                    </div>
                </div>

                <div class="alert alert-warning py-2 px-3 small border-0 mb-3" style="background-color: #FFF9E6; color: #8A6D3B;">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Hold Policy:</strong> Active 30-minute holds ({{ $occupancy['active_temporary_holds'] }} active) are displayed separately from confirmed occupied room-nights. Expired holds and cancelled bookings never dilute occupancy accuracy.
                </div>

                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="text-muted small">Avg Stay</div>
                            <div class="fw-bold fs-6">{{ $bookings['average_stay_duration'] }} nts</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="text-muted small">Avg Guests</div>
                            <div class="fw-bold fs-6">{{ $bookings['average_guests'] }} guests</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light">
                            <div class="text-muted small">Avg Lead</div>
                            <div class="fw-bold fs-6">{{ $bookings['average_lead_time'] }} days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════════
         5. CANCELLATION, REFUND & INQUIRY CONVERSIONS
         ═══════════════════════════════════════════════════════════════════════ -->
    <div class="row g-4 mb-4">
        <!-- Cancellations & Refunds Breakdown -->
        <div class="col-lg-6">
            <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: var(--color-charcoal-deep); font-family: var(--font-heading);">
                        <i class="fas fa-undo-alt me-2" style="color: var(--color-burgundy-rose);"></i> Cancellations &amp; Refund Analytics
                    </h5>
                    <span class="badge bg-danger-subtle text-danger">{{ $cancellations['cancellation_rate'] }}% Cancellation Rate</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="text-muted small">Total Cancellations</div>
                            <div class="fs-4 fw-bold text-danger">{{ $cancellations['total_cancellations'] }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="text-muted small">Processed Refunds</div>
                            <div class="fs-4 fw-bold text-danger">₹{{ number_format($cancellations['total_refund_amount'], 2) }}</div>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span><i class="fas fa-check-circle text-success me-2"></i> Completed Gateway Refunds:</span>
                        <span class="fw-bold text-success">{{ $cancellations['refund_completed_count'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span><i class="fas fa-clock text-warning me-2"></i> Pending Banking Clearance:</span>
                        <span class="fw-bold text-warning-emphasis">{{ $cancellations['refund_pending_count'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span><i class="fas fa-ban text-secondary me-2"></i> Non-Refundable (0% Policy Tier):</span>
                        <span class="fw-bold">{{ $cancellations['non_refundable_cancellations'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span><i class="fas fa-exclamation-triangle text-danger me-2"></i> Failed Gateway Retries:</span>
                        <span class="fw-bold text-danger">{{ $cancellations['refund_failed_count'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Inquiries & Matched Conversions -->
        <div class="col-lg-6">
            <div class="bg-white p-3 p-lg-4 rounded-3 shadow-sm border h-100" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: var(--color-charcoal-deep); font-family: var(--font-heading);">
                        <i class="fas fa-envelope-open-text me-2" style="color: var(--color-burgundy-rose);"></i> Inquiries &amp; Matched Conversions
                    </h5>
                    <span class="badge text-white" style="background-color: var(--color-burgundy-rose);">
                        {{ $inquiries['conversion_rate'] }}% Matched
                    </span>
                </div>

                <div class="row g-3 mb-3 text-center">
                    <div class="col-3">
                        <div class="p-2 border rounded bg-light">
                            <div class="text-muted small">Total</div>
                            <div class="fw-bold fs-5">{{ $inquiries['total_inquiries'] }}</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-2 border rounded bg-light">
                            <div class="text-muted small">New</div>
                            <div class="fw-bold fs-5 text-primary">{{ $inquiries['new_inquiries'] }}</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-2 border rounded bg-light">
                            <div class="text-muted small">Replied</div>
                            <div class="fw-bold fs-5 text-success">{{ $inquiries['replied_inquiries'] }}</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-2 border rounded" style="background-color: #F3E8FF;">
                            <div class="text-muted small">Matched</div>
                            <div class="fw-bold fs-5" style="color: #6F42C1;">{{ $inquiries['matched_conversions'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Attribution Note (Transparent Disclaimer) -->
                <div class="p-3 rounded-3 small border" style="background-color: var(--color-champagne); border-color: var(--color-border-subtle) !important;">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1" style="color: var(--color-burgundy-rose);"></i>
                        <div>
                            <strong>Matched Inquiry-to-Booking Conversions:</strong>
                            <p class="mb-0 text-muted" style="line-height: 1.5;">
                                Identifies inquiries where the customer's normalized email or mobile number corresponds to a confirmed, paid reservation created within 30 days of inquiry submission.
                                <em>This represents identity-based matching, not guaranteed causal attribution.</em>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Pinned Chart.js v4.4.7 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Revenue Timeline Chart
    const revenueCtx = document.getElementById('revenueTimelineChart');
    if (revenueCtx) {
        const timelineData = @json(array_values($revenue['revenue_timeline']));
        const labels = timelineData.map(d => d.display);
        const grossValues = timelineData.map(d => d.gross);
        const netValues = timelineData.map(d => d.net);
        const refundValues = timelineData.map(d => d.refunds);

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Net Revenue (₹)',
                        data: netValues,
                        borderColor: '#6E2C3A',
                        backgroundColor: 'rgba(110, 44, 58, 0.1)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 3
                    },
                    {
                        label: 'Gross Captured (₹)',
                        data: grossValues,
                        borderColor: '#B88A44',
                        backgroundColor: 'transparent',
                        borderDash: [4, 4],
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 2
                    },
                    {
                        label: 'Processed Refunds (₹)',
                        data: refundValues,
                        borderColor: '#dc3545',
                        backgroundColor: 'transparent',
                        tension: 0.3,
                        borderWidth: 1.5,
                        pointRadius: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                const val = Number(ctx.parsed.y);
                                const formatted = Math.abs(val).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                                return ctx.dataset.label + ': ' + (val < 0 ? '-₹' + formatted : '₹' + formatted);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val) {
                                const num = Number(val);
                                return num < 0 ? '-₹' + Math.abs(num).toLocaleString('en-IN') : '₹' + num.toLocaleString('en-IN');
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Payment Method Doughnut Chart
    const methodCtx = document.getElementById('paymentMethodChart');
    if (methodCtx) {
        const methodData = @json($revenue['method_breakdown']);
        const labels = Object.values(methodData).map(m => m.label);
        const counts = Object.values(methodData).map(m => m.count);

        new Chart(methodCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: ['#6E2C3A', '#B88A44', '#2E7D32', '#0288D1', '#7B1FA2'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { boxWidth: 10, font: { size: 10 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush
