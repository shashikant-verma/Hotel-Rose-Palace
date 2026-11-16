<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Business reporting timezone.
     */
    protected string $timezone = 'Asia/Kolkata';

    /**
     * Resolve date range from request filter.
     * Returns array [Carbon $startDateUtc, Carbon $endDateUtc, string $preset, Carbon $startDateLocal, Carbon $endDateLocal]
     *
     * @param string|null $preset
     * @param string|null $customStart
     * @param string|null $customEnd
     * @return array
     */
    public function resolveDateRange(?string $preset = 'last_30_days', ?string $customStart = null, ?string $customEnd = null): array
    {
        $now = Carbon::now($this->timezone);

        switch ($preset) {
            case 'today':
                $startLocal = $now->copy()->startOfDay();
                $endLocal = $now->copy()->endOfDay();
                $resolvedPreset = 'today';
                break;

            case 'yesterday':
                $startLocal = $now->copy()->subDay()->startOfDay();
                $endLocal = $now->copy()->subDay()->endOfDay();
                $resolvedPreset = 'yesterday';
                break;

            case 'last_7_days':
                $startLocal = $now->copy()->subDays(6)->startOfDay();
                $endLocal = $now->copy()->endOfDay();
                $resolvedPreset = 'last_7_days';
                break;

            case 'this_month':
                $startLocal = $now->copy()->startOfMonth()->startOfDay();
                $endLocal = $now->copy()->endOfDay();
                $resolvedPreset = 'this_month';
                break;

            case 'last_month':
                $startLocal = $now->copy()->subMonth()->startOfMonth()->startOfDay();
                $endLocal = $now->copy()->subMonth()->endOfMonth()->endOfDay();
                $resolvedPreset = 'last_month';
                break;

            case 'this_year':
                $startLocal = $now->copy()->startOfYear()->startOfDay();
                $endLocal = $now->copy()->endOfDay();
                $resolvedPreset = 'this_year';
                break;

            case 'custom':
                if ($customStart && $customEnd) {
                    try {
                        $startLocal = Carbon::createFromFormat('Y-m-d', $customStart, $this->timezone)->startOfDay();
                        $endLocal = Carbon::createFromFormat('Y-m-d', $customEnd, $this->timezone)->endOfDay();
                        if ($endLocal < $startLocal) {
                            $temp = $startLocal;
                            $startLocal = $endLocal->copy()->startOfDay();
                            $endLocal = $temp->copy()->endOfDay();
                        }
                        $resolvedPreset = 'custom';
                        break;
                    } catch (\Throwable $e) {
                        // fallback to last_30_days on invalid format
                    }
                }
                // Fallthrough if custom dates invalid
            case 'last_30_days':
            default:
                $startLocal = $now->copy()->subDays(29)->startOfDay();
                $endLocal = $now->copy()->endOfDay();
                $resolvedPreset = 'last_30_days';
                break;
        }

        // Convert to UTC for database timestamp comparisons (MySQL stores UTC)
        $startUtc = $startLocal->copy()->setTimezone('UTC');
        $endUtc = $endLocal->copy()->setTimezone('UTC');

        return [
            'start_utc' => $startUtc,
            'end_utc' => $endUtc,
            'start_local' => $startLocal,
            'end_local' => $endLocal,
            'preset' => $resolvedPreset,
            'days_count' => max(1, (int) round($startLocal->copy()->startOfDay()->diffInDays($endLocal->copy()->startOfDay()) + 1)),
        ];
    }

    /**
     * Get primary executive KPI metrics.
     *
     * @param array $range
     * @return array
     */
    public function getKpiSummary(array $range): array
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];

        // 1. Bookings KPIs (uses bookings.created_at)
        $totalBookings = Booking::whereBetween('created_at', [$startUtc, $endUtc])->count();

        $confirmedBookings = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->where('payment_status', 'paid')
            ->whereNull('cancelled_at')
            ->count();

        $pendingBookings = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->where('payment_status', 'pending')
            ->whereNull('cancelled_at')
            ->count();

        $cancelledBookings = Booking::where(function ($q) use ($startUtc, $endUtc) {
            $q->whereBetween('cancelled_at', [$startUtc, $endUtc])
              ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                  $sub->whereNull('cancelled_at')
                      ->where('booking_status', 'cancelled')
                      ->whereBetween('updated_at', [$startUtc, $endUtc]);
              });
        })->count();

        // 2. Revenue KPIs (uses payments.captured_at and payments.refunded_at)
        // Gross captured revenue: strictly payments with status 'captured'
        $grossRevenue = (float) Payment::where('status', 'captured')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('captured_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('captured_at')
                          ->whereBetween('created_at', [$startUtc, $endUtc]);
                  });
            })
            ->sum('amount');

        // Total refunds: strictly payments with refund_status 'processed'
        $totalRefunds = (float) Payment::where('refund_status', 'processed')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('refunded_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('refunded_at')
                          ->whereBetween('updated_at', [$startUtc, $endUtc]);
                  });
            })
            ->sum('refund_amount');

        // Net collected revenue: gross captured payments minus processed refunds (negative net revenue preserved)
        $netRevenue = (float) ($grossRevenue - $totalRefunds);

        // Total payments received count
        $totalPaymentsCount = Payment::where('status', 'captured')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('captured_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('captured_at')
                          ->whereBetween('created_at', [$startUtc, $endUtc]);
                  });
            })
            ->count();

        // Average Booking Value (ABV): Confirmed paid bookings
        // Approved Business Definition: Sum of bookings.total_amount for confirmed paid bookings / Count of confirmed paid bookings
        // Uses booking timestamp: bookings.created_at within [$startUtc, $endUtc]
        $confirmedTotalAmount = (float) Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->where('payment_status', 'paid')
            ->whereNull('cancelled_at')
            ->sum('total_amount');

        $averageBookingValue = $confirmedBookings > 0
            ? round($confirmedTotalAmount / $confirmedBookings, 2)
            : 0.00;

        // 3. Occupancy KPI
        $occupancyData = $this->calculateOccupancyMetrics($range);

        // 4. Inquiries
        $totalInquiries = ContactMessage::whereBetween('created_at', [$startUtc, $endUtc])->count();

        return [
            'total_bookings' => $totalBookings,
            'confirmed_bookings' => $confirmedBookings,
            'pending_bookings' => $pendingBookings,
            'cancelled_bookings' => $cancelledBookings,
            'gross_revenue' => $grossRevenue,
            'total_refunds' => $totalRefunds,
            'net_revenue' => $netRevenue,
            'total_payments_count' => $totalPaymentsCount,
            'average_booking_value' => $averageBookingValue,
            'occupancy_percentage' => $occupancyData['occupancy_rate'],
            'total_rooms' => $occupancyData['total_rooms'],
            'occupied_room_nights' => $occupancyData['occupied_room_nights'],
            'available_room_nights' => $occupancyData['available_room_nights'],
            'active_temporary_holds' => $occupancyData['active_temporary_holds'],
            'total_inquiries' => $totalInquiries,
        ];
    }

    /**
     * Calculate room occupancy using distinct room allocations and room nights.
     * Respects 30-minute hold cutoff and exclusive checkout dates.
     *
     * @param array $range
     * @return array
     */
    public function calculateOccupancyMetrics(array $range): array
    {
        $startLocal = $range['start_local'];
        $endLocal = $range['end_local'];

        // Total active physical rooms
        $totalRooms = Room::count();
        if ($totalRooms === 0) {
            $totalRooms = 15; // default inventory fallback
        }

        $holdMinutes = (int) config('razorpay.reservation_duration_minutes', 30);
        $holdCutoff = now()->subMinutes($holdMinutes);

        // Days in date range
        $period = CarbonPeriod::create($startLocal->copy()->startOfDay(), $endLocal->copy()->startOfDay());
        $daysCount = count($period);
        $availableRoomNights = $totalRooms * $daysCount;

        // Fetch valid room allocations intersecting the date range
        // Check-in and check-out dates are stored as Y-m-d
        $rangeStartStr = $startLocal->format('Y-m-d');
        $rangeEndExclusiveStr = $endLocal->copy()->addDay()->format('Y-m-d');

        // Confirmed Allocations: linked to active/confirmed bookings (not cancelled)
        $confirmedAllocations = RoomAllocation::query()
            ->where('allocation_status', 'confirmed')
            ->where('check_in_date', '<', $rangeEndExclusiveStr)
            ->where('check_out_date', '>', $rangeStartStr)
            ->whereHas('booking', function ($q) {
                $q->whereNull('cancelled_at')
                  ->where('booking_status', '!=', 'cancelled');
            })
            ->get();

        // Calculate occupied room-nights for confirmed allocations
        $occupiedRoomNights = 0;
        $dailyOccupancy = [];

        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $distinctOccupiedRooms = [];

            foreach ($confirmedAllocations as $alloc) {
                $allocCheckIn = $alloc->check_in_date->format('Y-m-d');
                $allocCheckOut = $alloc->check_out_date->format('Y-m-d');

                // Check-in inclusive, Check-out exclusive: allocCheckIn <= date < allocCheckOut
                if ($allocCheckIn <= $dateStr && $allocCheckOut > $dateStr) {
                    $distinctOccupiedRooms[$alloc->room_id] = true;
                }
            }

            $occupiedCount = count($distinctOccupiedRooms);
            $occupiedRoomNights += $occupiedCount;
            $dailyOccupancy[$dateStr] = [
                'occupied' => $occupiedCount,
                'available' => max(0, $totalRooms - $occupiedCount),
                'rate' => $totalRooms > 0 ? round(($occupiedCount / $totalRooms) * 100, 1) : 0,
            ];
        }

        $occupancyRate = $availableRoomNights > 0
            ? round(($occupiedRoomNights / $availableRoomNights) * 100, 1)
            : 0.0;

        // Active temporary holds currently in place (real-time 30-min window)
        $activeTemporaryHolds = RoomAllocation::query()
            ->where('allocation_status', 'temporary')
            ->where(function ($q) use ($holdCutoff) {
                $q->where('allocated_at', '>=', $holdCutoff)
                  ->orWhere(function ($sub) use ($holdCutoff) {
                      $sub->whereNull('allocated_at')
                          ->where('created_at', '>=', $holdCutoff);
                  });
            })
            ->distinct('room_id')
            ->count('room_id');

        return [
            'total_rooms' => $totalRooms,
            'days_count' => $daysCount,
            'available_room_nights' => $availableRoomNights,
            'occupied_room_nights' => $occupiedRoomNights,
            'occupancy_rate' => $occupancyRate,
            'active_temporary_holds' => $activeTemporaryHolds,
            'daily_occupancy' => $dailyOccupancy,
        ];
    }

    /**
     * Get detailed revenue & payment analytics including breakdown and daily trends.
     *
     * @param array $range
     * @return array
     */
    public function getRevenueAnalytics(array $range): array
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];
        $startLocal = $range['start_local'];
        $endLocal = $range['end_local'];

        // Payments counts by status
        $successfulCount = Payment::where('status', 'captured')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('captured_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('captured_at')->whereBetween('created_at', [$startUtc, $endUtc]);
                  });
            })->count();

        $failedCount = Payment::where('status', 'failed')
            ->whereBetween('created_at', [$startUtc, $endUtc])
            ->count();

        $pendingCount = Payment::whereIn('status', ['created', 'authorized', 'refund_pending'])
            ->whereBetween('created_at', [$startUtc, $endUtc])
            ->count();

        $grossAmount = (float) Payment::where('status', 'captured')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('captured_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('captured_at')->whereBetween('created_at', [$startUtc, $endUtc]);
                  });
            })->sum('amount');

        $refundAmount = (float) Payment::where('refund_status', 'processed')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('refunded_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('refunded_at')->whereBetween('updated_at', [$startUtc, $endUtc]);
                  });
            })->sum('refund_amount');

        // Net collected revenue: gross minus processed refunds (negative net revenue preserved)
        $netAmount = (float) ($grossAmount - $refundAmount);
        $averagePayment = $successfulCount > 0 ? round($grossAmount / $successfulCount, 2) : 0.00;

        // Payment method breakdown
        $methodBreakdown = Payment::where('status', 'captured')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('captured_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('captured_at')->whereBetween('created_at', [$startUtc, $endUtc]);
                  });
            })
            ->select('method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('method')
            ->get()
            ->mapWithKeys(function ($item) {
                $methodKey = !empty($item->method) ? strtolower($item->method) : 'other';
                return [$methodKey => [
                    'label' => strtoupper($methodKey),
                    'count' => (int) $item->count,
                    'total' => (float) $item->total,
                ]];
            })
            ->toArray();

        // Daily trend timeline for Chart.js
        $period = CarbonPeriod::create($startLocal->copy()->startOfDay(), $endLocal->copy()->startOfDay());
        $revenueTimeline = [];

        foreach ($period as $date) {
            $dayStartUtc = $date->copy()->startOfDay()->setTimezone('UTC');
            $dayEndUtc = $date->copy()->endOfDay()->setTimezone('UTC');
            $dateLabel = $date->format('Y-m-d');

            $dayGross = (float) Payment::where('status', 'captured')
                ->where(function ($q) use ($dayStartUtc, $dayEndUtc) {
                    $q->whereBetween('captured_at', [$dayStartUtc, $dayEndUtc])
                      ->orWhere(function ($sub) use ($dayStartUtc, $dayEndUtc) {
                          $sub->whereNull('captured_at')->whereBetween('created_at', [$dayStartUtc, $dayEndUtc]);
                      });
                })->sum('amount');

            $dayRefunds = (float) Payment::where('refund_status', 'processed')
                ->where(function ($q) use ($dayStartUtc, $dayEndUtc) {
                    $q->whereBetween('refunded_at', [$dayStartUtc, $dayEndUtc])
                      ->orWhere(function ($sub) use ($dayStartUtc, $dayEndUtc) {
                          $sub->whereNull('refunded_at')->whereBetween('updated_at', [$dayStartUtc, $dayEndUtc]);
                      });
                })->sum('refund_amount');

            $revenueTimeline[$dateLabel] = [
                'date' => $dateLabel,
                'display' => $date->format('d M'),
                'gross' => $dayGross,
                'refunds' => $dayRefunds,
                'net' => (float) ($dayGross - $dayRefunds),
            ];
        }

        return [
            'gross_amount' => $grossAmount,
            'refund_amount' => $refundAmount,
            'net_amount' => $netAmount,
            'successful_count' => $successfulCount,
            'failed_count' => $failedCount,
            'pending_count' => $pendingCount,
            'average_payment' => $averagePayment,
            'method_breakdown' => $methodBreakdown,
            'revenue_timeline' => $revenueTimeline,
        ];
    }

    /**
     * Get booking trends, room category popularity, and guest demographics.
     *
     * @param array $range
     * @return array
     */
    public function getBookingAnalytics(array $range): array
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];
        $startLocal = $range['start_local'];
        $endLocal = $range['end_local'];

        // Status breakdown
        $statusBreakdown = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->select('booking_status', DB::raw('count(*) as count'))
            ->groupBy('booking_status')
            ->pluck('count', 'booking_status')
            ->toArray();

        // Room category popularity
        $categoryBreakdown = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->whereNull('cancelled_at')
            ->with('roomType:id,name')
            ->select('room_type_id', DB::raw('count(*) as bookings_count'), DB::raw('sum(room_quantity) as total_rooms'), DB::raw('sum(total_amount) as total_revenue'))
            ->groupBy('room_type_id')
            ->get()
            ->map(function ($item) {
                return [
                    'room_type_id' => $item->room_type_id,
                    'name' => $item->roomType->name ?? 'Room Category #' . $item->room_type_id,
                    'bookings_count' => (int) $item->bookings_count,
                    'total_rooms' => (int) $item->total_rooms,
                    'total_revenue' => (float) $item->total_revenue,
                ];
            })
            ->sortByDesc('bookings_count')
            ->values()
            ->toArray();

        // Stay Duration & Demographics (confirmed bookings)
        $confirmedBookings = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
            ->whereNull('cancelled_at')
            ->get();

        $totalNights = 0;
        $totalGuests = 0;
        $totalLeadTimeDays = 0;

        foreach ($confirmedBookings as $b) {
            $nights = max(1, $b->check_out_date->diffInDays($b->check_in_date));
            $totalNights += $nights;
            $totalGuests += ($b->num_adults + $b->num_children);

            // Lead time: days between booking creation and check-in
            $leadDays = max(0, $b->created_at->diffInDays($b->check_in_date, false));
            $totalLeadTimeDays += $leadDays;
        }

        $count = $confirmedBookings->count();
        $averageStayDuration = $count > 0 ? round($totalNights / $count, 1) : 0;
        $averageGuests = $count > 0 ? round($totalGuests / $count, 1) : 0;
        $averageLeadTime = $count > 0 ? round($totalLeadTimeDays / $count, 1) : 0;

        // Booking Trends by Day of Week (0 = Sunday, 6 = Saturday)
        $dayOfWeekTrends = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
        ];

        $bookingsByDay = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->select('created_at')
            ->get();

        foreach ($bookingsByDay as $b) {
            $dayName = $b->created_at->setTimezone($this->timezone)->format('l');
            if (isset($dayOfWeekTrends[$dayName])) {
                $dayOfWeekTrends[$dayName]++;
            }
        }

        // Daily booking volume timeline
        $period = CarbonPeriod::create($startLocal->copy()->startOfDay(), $endLocal->copy()->startOfDay());
        $bookingTimeline = [];

        foreach ($period as $date) {
            $dayStartUtc = $date->copy()->startOfDay()->setTimezone('UTC');
            $dayEndUtc = $date->copy()->endOfDay()->setTimezone('UTC');
            $dateLabel = $date->format('Y-m-d');

            $dayTotal = Booking::whereBetween('created_at', [$dayStartUtc, $dayEndUtc])->count();
            $dayConfirmed = Booking::whereBetween('created_at', [$dayStartUtc, $dayEndUtc])
                ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
                ->where('payment_status', 'paid')
                ->whereNull('cancelled_at')
                ->count();

            $bookingTimeline[$dateLabel] = [
                'date' => $dateLabel,
                'display' => $date->format('d M'),
                'total' => $dayTotal,
                'confirmed' => $dayConfirmed,
            ];
        }

        // Customer Retention (New vs Returning within/before period)
        $customerAnalysis = $this->analyzeCustomerRetention($range);

        return [
            'status_breakdown' => $statusBreakdown,
            'category_breakdown' => $categoryBreakdown,
            'average_stay_duration' => $averageStayDuration,
            'average_guests' => $averageGuests,
            'average_lead_time' => $averageLeadTime,
            'day_of_week_trends' => $dayOfWeekTrends,
            'booking_timeline' => $bookingTimeline,
            'new_customers' => $customerAnalysis['new_customers'],
            'returning_customers' => $customerAnalysis['returning_customers'],
        ];
    }

    /**
     * Analyze customer retention (New vs Returning) based on booking email/phone history.
     */
    protected function analyzeCustomerRetention(array $range): array
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];

        $distinctBookings = Booking::whereBetween('created_at', [$startUtc, $endUtc])
            ->whereNotNull('customer_email')
            ->select('id', 'customer_email', 'created_at')
            ->get();

        $newCustomers = 0;
        $returningCustomers = 0;
        $seenEmails = [];

        foreach ($distinctBookings as $b) {
            $email = strtolower(trim($b->customer_email));
            if (isset($seenEmails[$email])) {
                continue;
            }
            $seenEmails[$email] = true;

            // Check if there was any prior booking before this period
            $priorBookingExists = Booking::where('customer_email', $email)
                ->where('created_at', '<', $startUtc)
                ->where('id', '!=', $b->id)
                ->exists();

            if ($priorBookingExists) {
                $returningCustomers++;
            } else {
                $newCustomers++;
            }
        }

        return [
            'new_customers' => $newCustomers,
            'returning_customers' => $returningCustomers,
        ];
    }

    /**
     * Get cancellation and refund analytics.
     *
     * @param array $range
     * @return array
     */
    public function getCancellationAnalytics(array $range): array
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];

        $totalCancellations = Booking::where(function ($q) use ($startUtc, $endUtc) {
            $q->whereBetween('cancelled_at', [$startUtc, $endUtc])
              ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                  $sub->whereNull('cancelled_at')
                      ->where('booking_status', 'cancelled')
                      ->whereBetween('updated_at', [$startUtc, $endUtc]);
              });
        })->count();

        $totalBookings = Booking::whereBetween('created_at', [$startUtc, $endUtc])->count();
        $cancellationRate = $totalBookings > 0 ? round(($totalCancellations / $totalBookings) * 100, 1) : 0.0;

        // Refund counts and amounts: strictly payments with refund_status 'processed'
        $refundCompletedCount = Payment::where('refund_status', 'processed')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('refunded_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('refunded_at')->whereBetween('updated_at', [$startUtc, $endUtc]);
                  });
            })->count();

        $refundPendingCount = Payment::where('refund_status', 'pending')
            ->whereBetween('created_at', [$startUtc, $endUtc])
            ->count();

        $refundFailedCount = Payment::where('refund_status', 'failed')
            ->whereBetween('created_at', [$startUtc, $endUtc])
            ->count();

        $totalRefundAmount = (float) Payment::where('refund_status', 'processed')
            ->where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('refunded_at', [$startUtc, $endUtc])
                  ->orWhere(function ($sub) use ($startUtc, $endUtc) {
                      $sub->whereNull('refunded_at')->whereBetween('updated_at', [$startUtc, $endUtc]);
                  });
            })->sum('refund_amount');

        $nonRefundableCancellations = Booking::where(function ($q) use ($startUtc, $endUtc) {
                $q->whereBetween('cancelled_at', [$startUtc, $endUtc])
                  ->orWhereBetween('updated_at', [$startUtc, $endUtc]);
            })
            ->where('cancellation_status', 'approved')
            ->where('refund_status', 'not_applicable')
            ->count();

        return [
            'total_cancellations' => $totalCancellations,
            'cancellation_rate' => $cancellationRate,
            'refund_completed_count' => $refundCompletedCount,
            'refund_pending_count' => $refundPendingCount,
            'refund_failed_count' => $refundFailedCount,
            'total_refund_amount' => $totalRefundAmount,
            'non_refundable_cancellations' => $nonRefundableCancellations,
        ];
    }

    /**
     * Get inquiry metrics and identity-matched conversion tracking.
     * Note: This is an identity-based 30-day matching mechanism, not a guaranteed causal attribution.
     *
     * @param array $range
     * @return array
     */
    public function getInquiryAnalytics(array $range): array
    {
        $startUtc = $range['start_utc'];
        $endUtc = $range['end_utc'];

        $inquiries = ContactMessage::whereBetween('created_at', [$startUtc, $endUtc])
            ->orderBy('created_at', 'asc')
            ->get();

        $totalInquiries = $inquiries->count();
        $newCount = $inquiries->where('status', 'new')->count();
        $readCount = $inquiries->where('status', 'read')->count();
        $repliedCount = $inquiries->where('status', 'replied')->count();

        // Identity-based matching: Match normalized email or phone to a confirmed booking within 30 days
        $matchedConversions = 0;
        $matchedBookingIds = [];

        foreach ($inquiries as $inquiry) {
            $normEmail = !empty($inquiry->email) ? strtolower(trim($inquiry->email)) : null;
            $normPhone = !empty($inquiry->phone) ? preg_replace('/[^0-9]/', '', $inquiry->phone) : null;
            if (strlen((string) $normPhone) >= 10) {
                $normPhone = substr((string) $normPhone, -10);
            }

            $inquiryCreated = $inquiry->created_at;
            $windowEnd = $inquiryCreated->copy()->addDays(30);

            $matchedBooking = Booking::query()
                ->whereIn('booking_status', ['confirmed', 'checked_in', 'checked_out'])
                ->where('payment_status', 'paid')
                ->whereNull('cancelled_at')
                ->where('created_at', '>=', $inquiryCreated)
                ->where('created_at', '<=', $windowEnd)
                ->whereNotIn('id', $matchedBookingIds)
                ->where(function ($q) use ($normEmail, $normPhone) {
                    if ($normEmail) {
                        $q->whereRaw('LOWER(TRIM(customer_email)) = ?', [$normEmail]);
                    }
                    if ($normPhone) {
                        $last10 = substr($normPhone, -10);
                        $q->orWhere('customer_mobile', 'like', "%{$last10}");
                    }
                })
                ->first();

            if ($matchedBooking) {
                $matchedConversions++;
                $matchedBookingIds[] = $matchedBooking->id;
            }
        }

        $conversionRate = $totalInquiries > 0
            ? round(($matchedConversions / $totalInquiries) * 100, 1)
            : 0.0;

        return [
            'total_inquiries' => $totalInquiries,
            'new_inquiries' => $newCount,
            'read_inquiries' => $readCount,
            'replied_inquiries' => $repliedCount,
            'matched_conversions' => $matchedConversions,
            'unconverted_inquiries' => max(0, $totalInquiries - $matchedConversions),
            'conversion_rate' => $conversionRate,
            'attribution_disclaimer' => 'Matched Inquiry-to-Booking Conversions use normalized email/phone correlation within 30 days of inquiry submission. This represents identity-based matching, not guaranteed causal attribution.',
        ];
    }
}
