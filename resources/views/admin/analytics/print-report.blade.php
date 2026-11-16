<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }} - Hotel Rose Palace</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --hrp-canvas: #EDE4D8;
            --hrp-surface: #F7F1E8;
            --hrp-border: #D8CBB8;
            --hrp-burgundy: #6E2C3A;
            --hrp-gold: #B88A44;
            --hrp-plum: #2E1F22;
            --hrp-mauve: #5E4B4E;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #FAFAFA;
            color: var(--hrp-plum);
            padding: 24px;
            font-size: 13px;
            line-height: 1.5;
        }

        .report-container {
            max-width: 1050px;
            margin: 0 auto;
            background: #FFFFFF;
            border: 1px solid var(--hrp-border);
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--hrp-burgundy);
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .brand-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--hrp-burgundy);
            letter-spacing: 0.5px;
        }

        .hotel-meta {
            font-size: 11px;
            color: var(--hrp-mauve);
            line-height: 1.4;
            margin-top: 4px;
        }

        .report-meta {
            text-align: right;
        }

        .report-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--hrp-plum);
            font-family: 'Playfair Display', Georgia, serif;
        }

        .report-dates {
            font-size: 12px;
            color: var(--hrp-mauve);
            margin-top: 4px;
        }

        .kpi-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            background-color: var(--hrp-surface);
            border: 1px solid var(--hrp-border);
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 24px;
        }

        .kpi-item .kpi-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--hrp-mauve);
            letter-spacing: 0.5px;
        }

        .kpi-item .kpi-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--hrp-burgundy);
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 12px;
        }

        th {
            background-color: #F4EFEB;
            color: var(--hrp-plum);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 8px 10px;
            border-bottom: 1px solid var(--hrp-border);
            text-align: left;
        }

        td {
            padding: 8px 10px;
            border-bottom: 1px solid #EFEFEF;
            vertical-align: middle;
        }

        tr:nth-child(even) td {
            background-color: #FCFAF8;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid var(--hrp-border);
            font-size: 11px;
            color: var(--hrp-mauve);
            display: flex;
            justify-content: space-between;
        }

        .no-print-bar {
            background: #2E1F22;
            color: #FFFFFF;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            border-radius: 6px;
        }

        .btn {
            background: var(--hrp-burgundy);
            color: #FFFFFF;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .btn-light {
            background: #FFFFFF;
            color: #2E1F22;
            margin-left: 8px;
        }

        @media print {
            body {
                background: #FFFFFF;
                padding: 0;
            }
            .no-print-bar {
                display: none;
            }
            .report-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div>
            <strong>Report Preview:</strong> {{ $reportTitle }}
            <span style="opacity: 0.7; margin-left: 8px;">({{ $range['start_local']->format('d M Y') }} - {{ $range['end_local']->format('d M Y') }})</span>
        </div>
        <div>
            <button onclick="window.print()" class="btn">Print / Save as PDF</button>
            <button onclick="window.close()" class="btn btn-light">Close Window</button>
        </div>
    </div>

    <div class="report-container">
        <!-- Header -->
        <div class="header-bar">
            <div>
                <div class="brand-title">Hotel Rose Palace</div>
                <div class="hotel-meta">
                    4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007<br>
                    Phone: +91 88667 71900 &bull; Email: Hotelrosepalacesurat@gmail.com
                </div>
            </div>
            <div class="report-meta">
                <div class="report-name">{{ $reportTitle }}</div>
                <div class="report-dates">
                    Period: <strong>{{ $range['start_local']->format('d M Y') }}</strong> to <strong>{{ $range['end_local']->format('d M Y') }}</strong> ({{ (int) $range['days_count'] }} {{ Str::plural('day', (int) $range['days_count']) }})<br>
                    Generated: {{ now()->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }} (IST)
                </div>
            </div>
        </div>

        <!-- Executive Summary Strip -->
        <div class="kpi-strip">
            <div class="kpi-item">
                <div class="kpi-label">Gross Captured</div>
                <div class="kpi-value">₹{{ number_format($kpis['gross_revenue'], 2) }}</div>
            </div>
            <div class="kpi-item">
                <div class="kpi-label">Net Collected</div>
                <div class="kpi-value" style="{{ $kpis['net_revenue'] < 0 ? 'color: #dc3545;' : '' }}">
                    {{ $kpis['net_revenue'] < 0 ? '-₹' . number_format(abs($kpis['net_revenue']), 2) : '₹' . number_format($kpis['net_revenue'], 2) }}
                </div>
            </div>
            <div class="kpi-item">
                <div class="kpi-label">Confirmed Bookings</div>
                <div class="kpi-value">{{ $kpis['confirmed_bookings'] }}</div>
            </div>
            <div class="kpi-item">
                <div class="kpi-label">Room Occupancy</div>
                <div class="kpi-value">{{ $kpis['occupancy_percentage'] }}%</div>
            </div>
        </div>

        <!-- Dynamic Content Body -->
        @if($type === 'bookings')
            <table>
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest Name</th>
                        <th>Category</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th class="text-center">Nts</th>
                        <th class="text-center">Rooms</th>
                        <th class="text-right">Total (₹)</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $b)
                        <tr>
                            <td><strong>{{ $b->booking_reference }}</strong></td>
                            <td>{{ $b->customer_name }}</td>
                            <td>{{ $b->roomType->name ?? 'Room #' . $b->room_type_id }}</td>
                            <td>{{ $b->check_in_date ? $b->check_in_date->format('d M Y') : '' }}</td>
                            <td>{{ $b->check_out_date ? $b->check_out_date->format('d M Y') : '' }}</td>
                            <td class="text-center">{{ $b->nights }}</td>
                            <td class="text-center">{{ $b->room_quantity }}</td>
                            <td class="text-right fw-bold">₹{{ number_format($b->total_amount, 2) }}</td>
                            <td class="text-center">
                                <span style="font-size: 10px; padding: 2px 6px; border-radius: 3px; font-weight: 700; background: #EEE;">
                                    {{ strtoupper($b->booking_status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center" style="padding: 24px; color: #777;">No booking records found for the selected period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        @elseif($type === 'revenue')
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-right">Gross Captured (₹)</th>
                        <th class="text-right">Processed Refunds (₹)</th>
                        <th class="text-right">Net Revenue (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records['revenue_timeline'] as $day)
                        <tr>
                            <td>{{ $day['display'] }} ({{ $day['date'] }})</td>
                            <td class="text-right">₹{{ number_format($day['gross'], 2) }}</td>
                            <td class="text-right" style="color: #c00;">₹{{ number_format($day['refunds'], 2) }}</td>
                            <td class="text-right" style="font-weight: 700; color: {{ $day['net'] < 0 ? '#dc3545' : 'var(--hrp-burgundy)' }};">{{ $day['net'] < 0 ? '-₹' . number_format(abs($day['net']), 2) : '₹' . number_format($day['net'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($type === 'payments')
            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Order ID</th>
                        <th>Booking Ref</th>
                        <th>Guest Name</th>
                        <th class="text-right">Amount (₹)</th>
                        <th class="text-center">Method</th>
                        <th class="text-center">Status</th>
                        <th>Captured At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $p)
                        <tr>
                            <td>{{ $p->razorpay_payment_id ?? 'N/A' }}</td>
                            <td>{{ $p->razorpay_order_id }}</td>
                            <td>{{ $p->booking->booking_reference ?? 'N/A' }}</td>
                            <td>{{ $p->booking->customer_name ?? 'N/A' }}</td>
                            <td class="text-right fw-bold">₹{{ number_format($p->amount, 2) }}</td>
                            <td class="text-center">{{ strtoupper($p->method ?? 'N/A') }}</td>
                            <td class="text-center">{{ strtoupper($p->status) }}</td>
                            <td>{{ $p->captured_at ? $p->captured_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 24px; color: #777;">No payment transactions recorded in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        @elseif($type === 'occupancy')
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-center">Total Rooms</th>
                        <th class="text-center">Occupied Rooms</th>
                        <th class="text-center">Available Rooms</th>
                        <th class="text-right">Occupancy %</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records['daily_occupancy'] as $dateStr => $day)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($dateStr)->format('d M Y (D)') }}</td>
                            <td class="text-center">{{ $records['total_rooms'] }}</td>
                            <td class="text-center">{{ $day['occupied'] }}</td>
                            <td class="text-center">{{ $day['available'] }}</td>
                            <td class="text-right fw-bold">{{ $day['rate'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($type === 'cancellations')
            <table>
                <thead>
                    <tr>
                        <th>Booking Ref</th>
                        <th>Customer</th>
                        <th class="text-right">Total Amount (₹)</th>
                        <th>Cancelled At</th>
                        <th>Reason</th>
                        <th class="text-center">Refund %</th>
                        <th class="text-right">Refund Amount (₹)</th>
                        <th class="text-center">Refund Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $b)
                        <tr>
                            <td><strong>{{ $b->booking_reference }}</strong></td>
                            <td>{{ $b->customer_name }}</td>
                            <td class="text-right">₹{{ number_format($b->total_amount, 2) }}</td>
                            <td>{{ $b->cancelled_at ? $b->cancelled_at->setTimezone('Asia/Kolkata')->format('d M Y') : 'N/A' }}</td>
                            <td>{{ $b->cancellation_reason ?? 'Customer request' }}</td>
                            <td class="text-center">{{ $b->eligible_refund_percentage ?? 0 }}%</td>
                            <td class="text-right fw-bold">₹{{ number_format($b->eligible_refund_amount ?? 0, 2) }}</td>
                            <td class="text-center">{{ strtoupper($b->refund_status ?? 'N/A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 24px; color: #777;">No cancellations recorded in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        @elseif($type === 'inquiries')
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th class="text-center">Status</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $inq)
                        <tr>
                            <td>#{{ $inq->id }}</td>
                            <td>{{ $inq->name }}</td>
                            <td>{{ $inq->email }}</td>
                            <td>{{ $inq->phone }}</td>
                            <td>{{ $inq->subject ?? 'General Inquiry' }}</td>
                            <td class="text-center">{{ strtoupper($inq->status ?? 'new') }}</td>
                            <td>{{ $inq->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 24px; color: #777;">No inquiries found for this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div>Hotel Rose Palace &bull; Confidential Business Analytics Document</div>
            <div>Report verified against active database records &bull; Page 1 of 1</div>
        </div>
    </div>

</body>
</html>
