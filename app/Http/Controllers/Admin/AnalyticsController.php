<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Services\AnalyticsService;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    protected AnalyticsService $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display the analytics dashboard.
     */
    public function index(Request $request)
    {
        $preset = $request->input('preset', 'last_30_days');
        $customStart = $request->input('start_date');
        $customEnd = $request->input('end_date');

        $range = $this->analyticsService->resolveDateRange($preset, $customStart, $customEnd);

        $kpis = $this->analyticsService->getKpiSummary($range);
        $occupancy = $this->analyticsService->calculateOccupancyMetrics($range);
        $revenue = $this->analyticsService->getRevenueAnalytics($range);
        $bookings = $this->analyticsService->getBookingAnalytics($range);
        $cancellations = $this->analyticsService->getCancellationAnalytics($range);
        $inquiries = $this->analyticsService->getInquiryAnalytics($range);

        return view('admin.analytics.index', compact(
            'range',
            'kpis',
            'occupancy',
            'revenue',
            'bookings',
            'cancellations',
            'inquiries'
        ));
    }

    /**
     * Export reports in CSV format or printable view.
     *
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\Response|StreamedResponse|\Illuminate\View\View
     */
    public function export(Request $request, string $type)
    {
        $validTypes = ['bookings', 'revenue', 'payments', 'cancellations', 'occupancy', 'inquiries'];
        if (!in_array($type, $validTypes, true)) {
            abort(404, 'Invalid report type requested.');
        }

        $preset = $request->input('preset', 'last_30_days');
        $customStart = $request->input('start_date');
        $customEnd = $request->input('end_date');
        $format = $request->input('format', 'csv');

        $range = $this->analyticsService->resolveDateRange($preset, $customStart, $customEnd);

        if ($format === 'print') {
            return $this->renderPrintableReport($type, $range);
        }

        return $this->streamCsvReport($type, $range);
    }

    /**
     * Stream CSV report for Excel compatibility without high memory consumption.
     */
    protected function streamCsvReport(string $type, array $range): StreamedResponse
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];
        $startLocalStr = $range['start_local']->format('Ymd');
        $endLocalStr = $range['end_local']->format('Ymd');
        $filename = "hotel_rose_palace_{$type}_report_{$startLocalStr}_to_{$endLocalStr}.csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($type, $range, $startUtc, $endUtc) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            switch ($type) {
                case 'bookings':
                    fputcsv($handle, [
                        'Booking Reference',
                        'Customer Name',
                        'Customer Email',
                        'Customer Mobile',
                        'Room Category',
                        'Check-In Date',
                        'Check-Out Date',
                        'Nights',
                        'Rooms Quantity',
                        'Adults',
                        'Children',
                        'Base Amount (INR)',
                        'Tax Amount (INR)',
                        'Total Amount (INR)',
                        'Booking Status',
                        'Payment Status',
                        'Created At (IST)',
                    ]);

                    Booking::with('roomType')
                        ->whereBetween('created_at', [$startUtc, $endUtc])
                        ->orderBy('created_at', 'desc')
                        ->chunk(100, function ($chunk) use ($handle) {
                            foreach ($chunk as $b) {
                                fputcsv($handle, $this->sanitizeCsvRow([
                                    $b->booking_reference,
                                    $b->customer_name,
                                    $b->customer_email,
                                    $b->customer_mobile,
                                    $b->roomType->name ?? 'Room #' . $b->room_type_id,
                                    $b->check_in_date ? $b->check_in_date->format('Y-m-d') : '',
                                    $b->check_out_date ? $b->check_out_date->format('Y-m-d') : '',
                                    $b->nights,
                                    $b->room_quantity,
                                    $b->num_adults,
                                    $b->num_children,
                                    number_format((float) $b->base_amount, 2, '.', ''),
                                    number_format((float) $b->tax_amount, 2, '.', ''),
                                    number_format((float) $b->total_amount, 2, '.', ''),
                                    strtoupper($b->booking_status),
                                    strtoupper($b->payment_status),
                                    $b->created_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
                                ]));
                            }
                        });
                    break;

                case 'revenue':
                    fputcsv($handle, [
                        'Date',
                        'Gross Captured Revenue (INR)',
                        'Processed Refunds (INR)',
                        'Net Collected Revenue (INR)',
                    ]);

                    $revAnalytics = $this->analyticsService->getRevenueAnalytics($range);
                    foreach ($revAnalytics['revenue_timeline'] as $day) {
                        fputcsv($handle, $this->sanitizeCsvRow([
                            $day['date'],
                            number_format($day['gross'], 2, '.', ''),
                            number_format($day['refunds'], 2, '.', ''),
                            number_format($day['net'], 2, '.', ''),
                        ]));
                    }
                    break;

                case 'payments':
                    fputcsv($handle, [
                        'Payment ID',
                        'Order ID',
                        'Booking Reference',
                        'Customer Name',
                        'Customer Email',
                        'Amount (INR)',
                        'Gateway Status',
                        'Payment Method',
                        'Card Network',
                        'Card Last 4',
                        'UPI / VPA',
                        'Captured At (IST)',
                    ]);

                    Payment::with('booking')
                        ->where(function ($q) use ($startUtc, $endUtc) {
                            $q->whereBetween('captured_at', [$startUtc, $endUtc])
                              ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                                  $sub->whereNull('captured_at')->whereBetween('created_at', [$startUtc, $endUtc]);
                              });
                        })
                        ->orderBy('created_at', 'desc')
                        ->chunk(100, function ($chunk) use ($handle) {
                            foreach ($chunk as $p) {
                                fputcsv($handle, $this->sanitizeCsvRow([
                                    $p->razorpay_payment_id ?? 'N/A',
                                    $p->razorpay_order_id,
                                    $p->booking->booking_reference ?? 'N/A',
                                    $p->booking->customer_name ?? 'N/A',
                                    $p->booking->customer_email ?? 'N/A',
                                    number_format((float) $p->amount, 2, '.', ''),
                                    strtoupper($p->status),
                                    strtoupper($p->method ?? 'N/A'),
                                    $p->card_network ?? 'N/A',
                                    $p->card_last4 ?? 'N/A',
                                    $p->vpa ?? 'N/A',
                                    $p->captured_at ? $p->captured_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : ($p->created_at ? $p->created_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : 'N/A'),
                                ]));
                            }
                        });
                    break;

                case 'cancellations':
                    fputcsv($handle, [
                        'Booking Reference',
                        'Customer Name',
                        'Customer Mobile',
                        'Total Amount (INR)',
                        'Cancellation Status',
                        'Cancelled At (IST)',
                        'Cancellation Reason',
                        'Eligible Refund %',
                        'Refund Amount (INR)',
                        'Refund Status',
                        'Refund ID',
                    ]);

                    Booking::where(function ($q) use ($startUtc, $endUtc) {
                            $q->whereBetween('cancelled_at', [$startUtc, $endUtc])
                              ->orWhereBetween('updated_at', [$startUtc, $endUtc]);
                        })
                        ->where(function ($q) {
                            $q->whereNotNull('cancelled_at')
                              ->orWhere('cancellation_status', 'approved')
                              ->orWhere('booking_status', 'cancelled');
                        })
                        ->orderBy('updated_at', 'desc')
                        ->chunk(100, function ($chunk) use ($handle) {
                            foreach ($chunk as $b) {
                                fputcsv($handle, $this->sanitizeCsvRow([
                                    $b->booking_reference,
                                    $b->customer_name,
                                    $b->customer_mobile,
                                    number_format((float) $b->total_amount, 2, '.', ''),
                                    strtoupper($b->cancellation_status ?? 'approved'),
                                    $b->cancelled_at ? $b->cancelled_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : 'N/A',
                                    $b->cancellation_reason ?? 'Customer requested cancellation',
                                    $b->eligible_refund_percentage ?? 0,
                                    number_format((float) ($b->eligible_refund_amount ?? 0), 2, '.', ''),
                                    strtoupper($b->refund_status ?? 'N/A'),
                                    $b->successfulPayment->refund_id ?? 'N/A',
                                ]));
                            }
                        });
                    break;

                case 'occupancy':
                    fputcsv($handle, [
                        'Date',
                        'Total Physical Rooms',
                        'Occupied Rooms Count',
                        'Available Rooms Count',
                        'Occupancy Rate (%)',
                    ]);

                    $occData = $this->analyticsService->calculateOccupancyMetrics($range);
                    foreach ($occData['daily_occupancy'] as $dateStr => $day) {
                        fputcsv($handle, $this->sanitizeCsvRow([
                            $dateStr,
                            $occData['total_rooms'],
                            $day['occupied'],
                            $day['available'],
                            $day['rate'] . '%',
                        ]));
                    }
                    break;

                case 'inquiries':
                    fputcsv($handle, [
                        'Inquiry ID',
                        'Customer Name',
                        'Email',
                        'Phone',
                        'Subject',
                        'Status',
                        'Submitted At (IST)',
                        'Conversion Attribution',
                    ]);

                    ContactMessage::whereBetween('created_at', [$startUtc, $endUtc])
                        ->orderBy('created_at', 'desc')
                        ->chunk(100, function ($chunk) use ($handle) {
                            foreach ($chunk as $inq) {
                                $normEmail = strtolower(trim((string) $inq->email));
                                $normPhone = preg_replace('/[^0-9]/', '', (string) $inq->phone);
                                $last10 = strlen($normPhone) >= 10 ? substr($normPhone, -10) : $normPhone;

                                $hasMatch = Booking::whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
                                    ->where('payment_status', 'paid')
                                    ->whereNull('cancelled_at')
                                    ->where('created_at', '>=', $inq->created_at)
                                    ->where('created_at', '<=', $inq->created_at->copy()->addDays(30))
                                    ->where(function ($q) use ($normEmail, $last10) {
                                        if ($normEmail) {
                                            $q->whereRaw('LOWER(TRIM(customer_email)) = ?', [$normEmail]);
                                        }
                                        if ($last10) {
                                            $q->orWhere('customer_mobile', 'like', "%{$last10}");
                                        }
                                    })
                                    ->first();

                                fputcsv($handle, $this->sanitizeCsvRow([
                                    $inq->id,
                                    $inq->name,
                                    $inq->email,
                                    $inq->phone,
                                    $inq->subject ?? 'General Inquiry',
                                    strtoupper($inq->status ?? 'new'),
                                    $inq->created_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
                                    $hasMatch ? "Converted (Booking: {$hasMatch->booking_reference})" : 'Unconverted',
                                ]));
                            }
                        });
                    break;
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Render a clean luxury-styled printable report suitable for printing or saving to PDF.
     */
    protected function renderPrintableReport(string $type, array $range)
    {
        $kpis = $this->analyticsService->getKpiSummary($range);
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];

        $titleMap = [
            'bookings' => 'Bookings Master Report',
            'revenue' => 'Revenue & Performance Report',
            'payments' => 'Payment Transactions Report',
            'cancellations' => 'Cancellations & Refunds Report',
            'occupancy' => 'Room Occupancy & Inventory Report',
            'inquiries' => 'General Inquiries & Attribution Report',
        ];

        $reportTitle = $titleMap[$type] ?? 'Hotel Business Report';

        // Load data based on type
        $records = [];
        switch ($type) {
            case 'bookings':
                $records = Booking::with('roomType')
                    ->whereBetween('created_at', [$startUtc, $endUtc])
                    ->orderBy('created_at', 'desc')
                    ->take(300)
                    ->get();
                break;

            case 'revenue':
                $records = $this->analyticsService->getRevenueAnalytics($range);
                break;

            case 'payments':
                $records = Payment::with('booking')
                    ->where(function ($q) use ($startUtc, $endUtc) {
                        $q->whereBetween('captured_at', [$startUtc, $endUtc])
                          ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                              $sub->whereNull('captured_at')->whereBetween('created_at', [$startUtc, $endUtc]);
                          });
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(300)
                    ->get();
                break;

            case 'cancellations':
                $records = Booking::where(function ($q) use ($startUtc, $endUtc) {
                        $q->whereBetween('cancelled_at', [$startUtc, $endUtc])
                          ->orWhereBetween('updated_at', [$startUtc, $endUtc]);
                    })
                    ->where(function ($q) {
                        $q->whereNotNull('cancelled_at')
                          ->orWhere('cancellation_status', 'approved')
                          ->orWhere('booking_status', 'cancelled');
                    })
                    ->orderBy('updated_at', 'desc')
                    ->take(300)
                    ->get();
                break;

            case 'occupancy':
                $records = $this->analyticsService->calculateOccupancyMetrics($range);
                break;

            case 'inquiries':
                $records = ContactMessage::whereBetween('created_at', [$startUtc, $endUtc])
                    ->orderBy('created_at', 'desc')
                    ->take(300)
                    ->get();
                break;
        }

        return view('admin.analytics.print-report', compact(
            'type',
            'reportTitle',
            'range',
            'kpis',
            'records'
        ));
    }

    /**
     * Sanitize a single CSV value against spreadsheet formula injection.
     * Escapes text starting with '=', '+', '-', or '@' (including after leading whitespace, tabs, or newlines)
     * by prepending a single quote ('), while strictly preserving numbers, dates, nulls, and standard text.
     *
     * @param mixed $value
     * @return mixed
     */
    public function sanitizeCsvValue(mixed $value): mixed
    {
        if ($value === null || is_int($value) || is_float($value) || is_bool($value)) {
            return $value;
        }

        $str = (string) $value;

        // Preserve strictly numeric values (e.g. "123", "-1500.00", "+500.00", "0.00")
        if (is_numeric($str)) {
            return $str;
        }

        // Check for formula trigger characters (=, +, -, @) after any leading whitespace, tabs, CR, or LF
        if (preg_match('/^\s*[=\+\-@]/u', $str)) {
            return "'" . $str;
        }

        return $str;
    }

    /**
     * Sanitize an entire CSV record row before passing to fputcsv.
     *
     * @param array $row
     * @return array
     */
    public function sanitizeCsvRow(array $row): array
    {
        return array_map([$this, 'sanitizeCsvValue'], $row);
    }
}
