<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice #{{ $enquiry->reference_id }} - Hotel Rose Palace</title>
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
            background-color: var(--hrp-canvas);
            color: var(--hrp-plum);
            padding: 30px 15px;
            font-size: 13px;
            line-height: 1.5;
        }

        .no-print-bar {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--hrp-surface);
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid var(--hrp-border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }

        .btn-burgundy {
            background-color: var(--hrp-burgundy);
            color: #ffffff;
        }
        .btn-burgundy:hover {
            background-color: #58222E;
        }

        .btn-outline {
            background: transparent;
            color: var(--hrp-plum);
            border: 1px solid var(--hrp-border);
        }
        .btn-outline:hover {
            background: rgba(110, 44, 58, 0.08);
        }

        .invoice-card {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid var(--hrp-border);
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(46, 31, 34, 0.08);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid var(--hrp-burgundy);
            margin-bottom: 24px;
        }

        .brand-col h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 24px;
            color: var(--hrp-burgundy);
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .brand-col p {
            color: var(--hrp-mauve);
            font-size: 12px;
            line-height: 1.4;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-title-badge {
            display: inline-block;
            background: var(--hrp-surface);
            color: var(--hrp-burgundy);
            border: 1px solid var(--hrp-border);
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .meta-row {
            font-size: 12px;
            margin-bottom: 3px;
        }
        .meta-row strong {
            color: var(--hrp-plum);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
            background: var(--hrp-surface);
            padding: 16px 20px;
            border-radius: 6px;
            border: 1px solid var(--hrp-border);
        }

        .info-block h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--hrp-gold);
            font-weight: 700;
            margin-bottom: 8px;
            border-bottom: 1px dashed var(--hrp-border);
            padding-bottom: 4px;
        }

        .info-block p {
            font-size: 12px;
            margin-bottom: 4px;
            color: var(--hrp-plum);
        }

        .table-invoice {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .table-invoice th {
            background-color: var(--hrp-burgundy);
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            text-align: left;
        }
        .table-invoice th.text-end {
            text-align: right;
        }

        .table-invoice td {
            padding: 12px;
            border-bottom: 1px solid var(--hrp-border);
            font-size: 12px;
        }
        .table-invoice td.text-end {
            text-align: right;
        }

        .totals-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .totals-box {
            width: 320px;
            background: var(--hrp-surface);
            border: 1px solid var(--hrp-border);
            border-radius: 6px;
            padding: 14px 18px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 6px;
            color: var(--hrp-mauve);
        }

        .total-row.highlight {
            font-size: 14px;
            font-weight: 700;
            color: var(--hrp-burgundy);
            border-top: 1px solid var(--hrp-border);
            border-bottom: 1px solid var(--hrp-border);
            padding: 8px 0;
            margin: 8px 0;
        }

        .payment-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .payment-badge-paid {
            background: #d4edda;
            color: #155724;
        }
        .payment-badge-partial {
            background: #fff3cd;
            color: #856404;
        }
        .payment-badge-pending {
            background: #f8d7da;
            color: #721c24;
        }

        .footer-terms {
            border-top: 1px solid var(--hrp-border);
            padding-top: 16px;
            font-size: 11px;
            color: var(--hrp-mauve);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-box {
            text-align: center;
            min-width: 180px;
        }
        .signature-line {
            border-bottom: 1px solid var(--hrp-plum);
            margin-top: 40px;
            margin-bottom: 4px;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
                font-size: 11pt;
            }
            .no-print-bar {
                display: none !important;
            }
            .invoice-card {
                border: none;
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div style="font-weight: 600;">
            Receipt for: <span style="color: var(--hrp-burgundy);">{{ $enquiry->customer_name }}</span> ({{ $enquiry->reference_id }})
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="btn btn-outline">
                &larr; Back to Booking
            </a>
            <button onclick="window.print()" class="btn btn-burgundy">
                🖨️ Print Receipt / Save PDF
            </button>
        </div>
    </div>

    <div class="invoice-card">
        <!-- Header -->
        <div class="invoice-header">
            <div class="brand-col">
                <h1>HOTEL ROSE PALACE</h1>
                <p>VIP Road, Near Vesu Canal Road, Vesu, Surat, Gujarat 395007</p>
                <p>Phone: +91 98765 43210 &bull; Email: reservations@hotelrosepalace.com</p>
                <p><strong>GSTIN:</strong> 24AAACH7890K1Z5 &bull; <strong>PAN:</strong> AAACH7890K</p>
            </div>
            <div class="invoice-meta">
                <div class="invoice-title-badge">OFFICIAL GST RECEIPT</div>
                <div class="meta-row"><strong>Invoice No:</strong> INV-{{ $enquiry->reference_id }}</div>
                <div class="meta-row"><strong>Date:</strong> {{ now()->format('d M, Y') }}</div>
                <div class="meta-row"><strong>Booking Ref:</strong> {{ $enquiry->reference_id }}</div>
                <div class="meta-row"><strong>Source:</strong> {{ ucfirst($enquiry->booking_type ?? 'Reception Walk-In') }}</div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-block">
                <h3>Billed To (Guest Details)</h3>
                <p><strong>Name:</strong> {{ $enquiry->customer_name }}</p>
                <p><strong>Phone:</strong> {{ $enquiry->customer_phone }}</p>
                @if($enquiry->customer_email)
                    <p><strong>Email:</strong> {{ $enquiry->customer_email }}</p>
                @endif
                <p><strong>ID Proof:</strong> {{ $enquiry->id_proof_type ?? 'Aadhaar Card' }} ({{ $enquiry->id_proof_number ?? 'Verified at Desk' }})</p>
            </div>
            <div class="info-block">
                <h3>Stay & Room Assignment</h3>
                <p><strong>Assigned Room:</strong> Room #{{ $enquiry->room->room_number ?? 'Allocated at Desk' }} (Floor {{ $enquiry->room->floor ?? '1' }})</p>
                <p><strong>Room Category:</strong> {{ $enquiry->roomType->name ?? 'Deluxe Room' }}</p>
                <p><strong>Check-In:</strong> {{ $enquiry->check_in_date ? $enquiry->check_in_date->format('d M, Y') : 'N/A' }} (12:00 PM)</p>
                <p><strong>Check-Out:</strong> {{ $enquiry->check_out_date ? $enquiry->check_out_date->format('d M, Y') : 'N/A' }} (11:00 AM)</p>
                <p><strong>Duration / Guests:</strong> {{ $enquiry->nights }} Night(s) &bull; {{ $enquiry->num_adults }} Adult(s), {{ $enquiry->num_children }} Child</p>
            </div>
        </div>

        <!-- Tariff Table -->
        <table class="table-invoice">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>HSN / SAC</th>
                    <th>Duration / Qty</th>
                    <th class="text-end">Tariff Rate</th>
                    <th class="text-end">Taxable Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Room Stay — {{ $enquiry->roomType->name ?? 'Deluxe Room' }}</strong><br>
                        <span style="color: var(--hrp-mauve); font-size: 11px;">
                            Stay from {{ $enquiry->check_in_date ? $enquiry->check_in_date->format('d M Y') : '' }} to {{ $enquiry->check_out_date ? $enquiry->check_out_date->format('d M Y') : '' }}
                        </span>
                    </td>
                    <td>996311</td>
                    <td>{{ $enquiry->nights }} Night(s)</td>
                    <td class="text-end">₹{{ number_format((float)$enquiry->total_tariff / max(1, $enquiry->nights), 2) }}</td>
                    <td class="text-end">₹{{ number_format((float)$enquiry->total_tariff, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals & Offline Payment Mode -->
        <div class="totals-container">
            <div class="totals-box">
                <div class="total-row">
                    <span>Taxable Base Value:</span>
                    <span>₹{{ number_format((float)$enquiry->total_tariff, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>CGST (6%):</span>
                    <span>₹{{ number_format($enquiry->cgst, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>SGST (6%):</span>
                    <span>₹{{ number_format($enquiry->sgst, 2) }}</span>
                </div>
                <div class="total-row highlight">
                    <span>Grand Total:</span>
                    <span>₹{{ number_format($enquiry->grand_total, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Payment Mode:</span>
                    <strong>{{ $enquiry->payment_mode ?? 'Cash at Reception' }}</strong>
                </div>
                <div class="total-row">
                    <span>Payment Status:</span>
                    @php
                        $pStatus = $enquiry->payment_status ?? 'paid';
                    @endphp
                    <span class="payment-badge payment-badge-{{ $pStatus }}">
                        {{ strtoupper($pStatus) }}
                    </span>
                </div>
                <div class="total-row">
                    <span>Amount Recorded:</span>
                    <strong style="color: #27ae60;">₹{{ number_format((float)$enquiry->paid_amount, 2) }}</strong>
                </div>
                <div class="total-row" style="font-size: 13px; font-weight: 700; color: {{ $enquiry->balance_due > 0 ? '#E74C3C' : '#27ae60' }};">
                    <span>Balance Due:</span>
                    <span>₹{{ number_format($enquiry->balance_due, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Terms & Signature -->
        <div class="footer-terms">
            <div>
                <strong style="color: var(--hrp-plum); display: block; margin-bottom: 4px;">Terms & Conditions:</strong>
                <ol style="padding-left: 14px; line-height: 1.4;">
                    <li>Standard check-in time is 12:00 PM and check-out time is 11:00 AM.</li>
                    <li>This receipt confirms direct offline settlement at hotel reception.</li>
                    <li>All dispute resolutions are subject to Surat jurisdiction.</li>
                    <li>100% Pure Vegetarian kitchen. Outside food and consumption of alcohol strictly prohibited.</li>
                </ol>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <span>Authorized Signatory / Front Desk</span>
            </div>
        </div>
    </div>

</body>
</html>
