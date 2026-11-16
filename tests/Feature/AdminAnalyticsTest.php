<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\User;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected RoomType $roomType;
    protected Room $room101;
    protected Room $room102;
    protected AnalyticsService $analyticsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@hotelrosepalace.com',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->roomType = RoomType::create([
            'name' => 'Royal Heritage Suite',
            'slug' => 'royal-heritage-suite',
            'description' => 'Opulent suite with terrace',
            'base_price' => 5000,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        $this->room101 = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '101',
            'current_price' => 5000,
            'is_available' => true,
        ]);

        $this->room102 = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '102',
            'current_price' => 5000,
            'is_available' => true,
        ]);

        $this->analyticsService = app(AnalyticsService::class);
    }

    /**
     * Helper to create test booking
     */
    protected function createTestBooking(array $overrides = []): Booking
    {
        static $seq = 1000;
        $seq++;

        $checkIn = Carbon::now('Asia/Kolkata')->startOfDay();
        $checkOut = Carbon::now('Asia/Kolkata')->addDays(2)->startOfDay();

        return Booking::create(array_merge([
            'booking_reference' => 'BK_AN_' . $seq,
            'customer_name' => 'Rohan Varma',
            'customer_email' => 'rohan@example.com',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'num_adults' => 2,
            'num_children' => 0,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'base_amount' => 10000.00,
            'tax_amount' => 1200.00,
            'total_amount' => 11200.00,
            'razorpay_order_id' => 'order_an_' . $seq,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'created_at' => Carbon::now('Asia/Kolkata')->setTimezone('UTC'),
        ], $overrides));
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 1. SECURITY & ACCESS CONTROL TESTS
    // ═══════════════════════════════════════════════════════════════════════

    public function test_unauthenticated_user_cannot_access_analytics_dashboard(): void
    {
        $response = $this->get(route('admin.analytics.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_admin_can_access_analytics_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.analytics.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.analytics.index');
        $response->assertViewHasAll(['range', 'kpis', 'occupancy', 'revenue', 'bookings', 'cancellations', 'inquiries']);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 2. BOOKING ANALYTICS TESTS
    // ═══════════════════════════════════════════════════════════════════════

    public function test_booking_kpis_accurately_count_total_confirmed_and_pending(): void
    {
        // 1 confirmed paid booking
        $this->createTestBooking([
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'total_amount' => 11200.00,
        ]);

        // 1 pending booking
        $this->createTestBooking([
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
            'total_amount' => 5000.00,
        ]);

        // 1 cancelled booking
        $this->createTestBooking([
            'booking_status' => 'cancelled',
            'payment_status' => 'paid',
            'cancelled_at' => now(),
            'total_amount' => 7000.00,
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $kpis = $this->analyticsService->getKpiSummary($range);

        $this->assertEquals(3, $kpis['total_bookings']);
        $this->assertEquals(1, $kpis['confirmed_bookings']);
        $this->assertEquals(1, $kpis['pending_bookings']);
        $this->assertEquals(1, $kpis['cancelled_bookings']);
        $this->assertEquals(11200.00, $kpis['average_booking_value']);
    }

    public function test_date_range_filtering_respects_time_boundaries(): void
    {
        // Booking created 45 days ago (outside 30-day window)
        $pastBooking = $this->createTestBooking();
        Booking::where('id', $pastBooking->id)->update([
            'created_at' => Carbon::now('Asia/Kolkata')->subDays(45)->setTimezone('UTC'),
        ]);

        // Booking created today (inside 30-day window)
        $this->createTestBooking();

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $kpis = $this->analyticsService->getKpiSummary($range);

        $this->assertEquals(1, $kpis['total_bookings']);
    }

    public function test_reporting_period_display_duration_is_an_exact_integer_without_floating_point_imprecision(): void
    {
        // Custom date range from 01 Nov 2026 to 15 Nov 2026
        $range = $this->analyticsService->resolveDateRange('custom', '2026-11-01', '2026-11-15');

        $this->assertIsInt($range['days_count']);
        $this->assertEquals(15, $range['days_count']);

        // Check dashboard output
        $response = $this->actingAs($this->adminUser)->get(route('admin.analytics.index', [
            'preset' => 'custom',
            'start_date' => '2026-11-01',
            'end_date' => '2026-11-15',
        ]));
        $response->assertStatus(200);
        $response->assertSee('Reporting Period: <strong>01 Nov 2026</strong> to <strong>15 Nov 2026</strong>', false);
        $response->assertSee('(15 days)');
        $response->assertDontSee('15.999999999988');

        // Check printable report output
        $printResponse = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', [
            'type' => 'revenue',
            'format' => 'print',
            'preset' => 'custom',
            'start_date' => '2026-11-01',
            'end_date' => '2026-11-15',
        ]));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('(15 days)');
        $printResponse->assertDontSee('15.999999999988');
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 3. REVENUE & PAYMENT ANALYTICS TESTS
    // ═══════════════════════════════════════════════════════════════════════

    public function test_revenue_aggregates_captured_payments_and_deducts_processed_refunds(): void
    {
        $booking = $this->createTestBooking();

        // Successful captured payment
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_success_1',
            'amount' => 10000.00,
            'status' => 'captured',
            'captured_at' => now(),
            'method' => 'card',
        ]);

        // Failed payment attempt (must NOT be counted in revenue)
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_failed_1',
            'amount' => 10000.00,
            'status' => 'failed',
            'method' => 'card',
        ]);

        // Processed refund
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_refunded_1',
            'amount' => 2000.00,
            'status' => 'refunded',
            'refund_status' => 'processed',
            'refund_amount' => 2000.00,
            'refunded_at' => now(),
            'method' => 'upi',
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $kpis = $this->analyticsService->getKpiSummary($range);
        $revenue = $this->analyticsService->getRevenueAnalytics($range);

        $this->assertEquals(10000.00, $kpis['gross_revenue']);
        $this->assertEquals(2000.00, $kpis['total_refunds']);
        $this->assertEquals(8000.00, $kpis['net_revenue']);
        $this->assertEquals(1, $revenue['successful_count']);
        $this->assertEquals(1, $revenue['failed_count']);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 4. ROOM OCCUPANCY ANALYTICS TESTS
    // ═══════════════════════════════════════════════════════════════════════

    public function test_room_occupancy_calculates_distinct_room_nights_and_exclusive_checkout(): void
    {
        $today = Carbon::now('Asia/Kolkata')->startOfDay();
        $tomorrow = $today->copy()->addDay();
        $dayAfter = $today->copy()->addDays(2);

        $booking = $this->createTestBooking([
            'check_in_date' => $today,
            'check_out_date' => $dayAfter, // 2 nights
            'booking_status' => 'confirmed',
        ]);

        // Confirmed allocation for room101
        RoomAllocation::create([
            'booking_id' => $booking->id,
            'room_id' => $this->room101->id,
            'check_in_date' => $today,
            'check_out_date' => $dayAfter,
            'allocation_status' => 'confirmed',
        ]);

        // Single day range (today)
        $range = $this->analyticsService->resolveDateRange('today');
        $occupancy = $this->analyticsService->calculateOccupancyMetrics($range);

        // 1 room occupied out of 2 rooms available
        $this->assertEquals(1, $occupancy['occupied_room_nights']);
        $this->assertEquals(2, $occupancy['available_room_nights']);
        $this->assertEquals(50.0, $occupancy['occupancy_rate']);
    }

    public function test_cancelled_bookings_and_expired_holds_are_excluded_from_occupancy(): void
    {
        $today = Carbon::now('Asia/Kolkata')->startOfDay();
        $tomorrow = $today->copy()->addDay();

        $cancelledBooking = $this->createTestBooking([
            'check_in_date' => $today,
            'check_out_date' => $tomorrow,
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        // Allocation for cancelled booking
        RoomAllocation::create([
            'booking_id' => $cancelledBooking->id,
            'room_id' => $this->room101->id,
            'check_in_date' => $today,
            'check_out_date' => $tomorrow,
            'allocation_status' => 'confirmed',
        ]);

        // Temporary hold past 30 minutes (expired)
        $activeBooking = $this->createTestBooking();
        RoomAllocation::create([
            'booking_id' => $activeBooking->id,
            'room_id' => $this->room102->id,
            'check_in_date' => $today,
            'check_out_date' => $tomorrow,
            'allocation_status' => 'temporary',
            'allocated_at' => now()->subMinutes(45), // Expired hold
        ]);

        $range = $this->analyticsService->resolveDateRange('today');
        $occupancy = $this->analyticsService->calculateOccupancyMetrics($range);

        // Neither cancelled nor expired temporary hold should count as confirmed occupancy
        $this->assertEquals(0, $occupancy['occupied_room_nights']);
        $this->assertEquals(0.0, $occupancy['occupancy_rate']);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 5. INQUIRY CONVERSION ATTRIBUTION TESTS (IDENTITY-MATCHED)
    // ═══════════════════════════════════════════════════════════════════════

    public function test_matched_inquiry_to_booking_conversions_matches_within_30_days(): void
    {
        $inquiryDate = Carbon::now('Asia/Kolkata')->subDays(5);

        // Customer inquiry
        $inquiry = ContactMessage::create([
            'name' => 'Aditi Sen',
            'email' => 'aditi.sen@example.com',
            'phone' => '+91 98888 77777',
            'subject' => 'Executive Suite Tariff',
            'message' => 'Inquiring about suite rates for next weekend.',
            'status' => 'replied',
        ]);
        ContactMessage::where('id', $inquiry->id)->update([
            'created_at' => $inquiryDate->copy()->setTimezone('UTC'),
        ]);

        // Matching booking created 2 days after inquiry
        $booking = $this->createTestBooking([
            'customer_email' => 'aditi.sen@example.com',
            'customer_mobile' => '9888877777',
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
        Booking::where('id', $booking->id)->update([
            'created_at' => $inquiryDate->copy()->addDays(2)->setTimezone('UTC'),
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $inqAnalytics = $this->analyticsService->getInquiryAnalytics($range);

        $this->assertEquals(1, $inqAnalytics['total_inquiries']);
        $this->assertEquals(1, $inqAnalytics['matched_conversions']);
        $this->assertEquals(100.0, $inqAnalytics['conversion_rate']);
    }

    public function test_unmatched_inquiry_or_booking_made_before_inquiry_is_not_converted(): void
    {
        $inquiryDate = Carbon::now('Asia/Kolkata')->subDays(10);

        // Booking made BEFORE the inquiry
        $booking = $this->createTestBooking([
            'customer_email' => 'priya@example.com',
        ]);
        Booking::where('id', $booking->id)->update([
            'created_at' => $inquiryDate->copy()->subDays(2)->setTimezone('UTC'),
        ]);

        // Inquiry made later
        $inquiry = ContactMessage::create([
            'name' => 'Priya Nair',
            'email' => 'priya@example.com',
            'phone' => '9111122222',
            'subject' => 'Late checkout question',
            'message' => 'Can I have late checkout?',
            'status' => 'new',
        ]);
        ContactMessage::where('id', $inquiry->id)->update([
            'created_at' => $inquiryDate->copy()->setTimezone('UTC'),
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $inqAnalytics = $this->analyticsService->getInquiryAnalytics($range);

        $this->assertEquals(1, $inqAnalytics['total_inquiries']);
        $this->assertEquals(0, $inqAnalytics['matched_conversions']);
        $this->assertEquals(0.0, $inqAnalytics['conversion_rate']);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 6. CSV & PRINTABLE EXPORT TESTS
    // ═══════════════════════════════════════════════════════════════════════

    public function test_csv_export_streams_all_six_reports_successfully(): void
    {
        $this->createTestBooking();

        $reportTypes = ['bookings', 'revenue', 'payments', 'cancellations', 'occupancy', 'inquiries'];

        foreach ($reportTypes as $type) {
            $response = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => $type]));
            $response->assertStatus(200);
            $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        }
    }

    public function test_printable_report_renders_with_luxury_print_view(): void
    {
        $this->createTestBooking();

        $response = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', [
            'type' => 'bookings',
            'format' => 'print',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.analytics.print-report');
        $response->assertSee('Hotel Rose Palace');
        $response->assertSee('Bookings Master Report');
        $response->assertSee('window.print()');
    }

    public function test_invalid_report_type_returns_404(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => 'invalid_report_type']));
        $response->assertStatus(404);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 7. PHASE 10A REGRESSION TESTS: NEGATIVE NET REVENUE, CSV INJECTION, ABV, REFUNDS
    // ═══════════════════════════════════════════════════════════════════════

    public function test_negative_net_revenue_is_preserved_when_refunds_exceed_captured_revenue(): void
    {
        $booking1 = $this->createTestBooking();
        $booking2 = $this->createTestBooking();

        // 1 captured payment of ₹2,000
        Payment::create([
            'booking_id' => $booking1->id,
            'razorpay_order_id' => $booking1->razorpay_order_id,
            'razorpay_payment_id' => 'pay_cap_2000',
            'amount' => 2000.00,
            'status' => 'captured',
            'captured_at' => now(),
            'method' => 'card',
        ]);

        // Processed refund of ₹5,000
        Payment::create([
            'booking_id' => $booking2->id,
            'razorpay_order_id' => $booking2->razorpay_order_id,
            'razorpay_payment_id' => 'pay_ref_5000',
            'amount' => 5000.00,
            'status' => 'refunded',
            'refund_status' => 'processed',
            'refund_amount' => 5000.00,
            'refunded_at' => now(),
            'method' => 'upi',
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $kpis = $this->analyticsService->getKpiSummary($range);
        $revenue = $this->analyticsService->getRevenueAnalytics($range);

        // Net revenue must be negative: 2000 - 5000 = -3000.00 (not clamped to 0.00)
        $this->assertEquals(2000.00, $kpis['gross_revenue']);
        $this->assertEquals(5000.00, $kpis['total_refunds']);
        $this->assertEquals(-3000.00, $kpis['net_revenue']);
        $this->assertEquals(-3000.00, $revenue['net_amount']);

        // Verify dashboard displays negative net revenue clearly
        $dashResponse = $this->actingAs($this->adminUser)->get(route('admin.analytics.index'));
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('-₹3,000.00');
        $dashResponse->assertSee('Net Outflow');

        // Verify printable report displays negative amount
        $printResponse = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => 'revenue', 'format' => 'print']));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('-₹3,000.00');

        // Verify CSV export contains negative net revenue as valid numeric string
        $csvResponse = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => 'revenue']));
        $csvResponse->assertStatus(200);
        $csvContent = $csvResponse->streamedContent();
        $this->assertStringContainsString('-3000.00', $csvContent);
        // Ensure it is NOT escaped with a single quote because it is a valid negative number
        $this->assertStringNotContainsString("'-3000.00", $csvContent);
    }

    public function test_csv_export_sanitizes_formula_injection_characters_while_preserving_numbers(): void
    {
        // 1. Booking with malicious formula trigger in customer name
        $this->createTestBooking([
            'customer_name' => '=SUM(A1:A10)',
            'customer_email' => 'victim@example.com',
            'total_amount' => 11200.00,
        ]);

        // 2. Inquiry with formula characters and leading whitespace
        ContactMessage::create([
            'name' => '   =SUM(A1:A10)',
            'email' => 'attacker@example.com',
            'phone' => '+91 98888 77777',
            'subject' => "+cmd|' /C calc'!A0",
            'message' => '@SUM(A1:A2)',
            'status' => 'new',
        ]);

        // 3. Cancelled booking with @ formula trigger in cancellation reason
        $this->createTestBooking([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => '@HARMFUL_SPREADSHEET_FORMULA',
        ]);

        // Test Bookings CSV
        $bookCsv = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => 'bookings']));
        $bookCsv->assertStatus(200);
        $bookContent = $bookCsv->streamedContent();
        $this->assertStringContainsString("'=SUM(A1:A10)", $bookContent); // Escaped with leading quote
        $this->assertStringContainsString('11200.00', $bookContent); // Numeric value preserved unescaped

        // Test Inquiries CSV
        $inqCsv = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => 'inquiries']));
        $inqCsv->assertStatus(200);
        $inqContent = $inqCsv->streamedContent();
        $this->assertStringContainsString("'+cmd|' /C calc'!A0", $inqContent);
        $this->assertStringContainsString("'   =SUM(A1:A10)", $inqContent);

        // Test Cancellations CSV
        $cancCsv = $this->actingAs($this->adminUser)->get(route('admin.analytics.export', ['type' => 'cancellations']));
        $cancCsv->assertStatus(200);
        $cancContent = $cancCsv->streamedContent();
        $this->assertStringContainsString("'@HARMFUL_SPREADSHEET_FORMULA", $cancContent);
    }

    public function test_abv_approved_business_definition_and_edge_cases(): void
    {
        // Case 1: Booking total_amount differs from captured payment amount
        // Booking total is 15000, but payment received was 12000 (e.g. discount/deposit)
        $booking = $this->createTestBooking([
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'total_amount' => 15000.00,
        ]);
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_diff_amount',
            'amount' => 12000.00,
            'status' => 'captured',
            'captured_at' => now(),
            'method' => 'card',
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $kpis = $this->analyticsService->getKpiSummary($range);

        // ABV must strictly use bookings.total_amount (15000.00), NOT captured payment (12000.00)
        $this->assertEquals(15000.00, $kpis['average_booking_value']);

        // Case 2: Multiple confirmed paid bookings exist
        $this->createTestBooking([
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'total_amount' => 25000.00,
        ]);

        $kpis2 = $this->analyticsService->getKpiSummary($range);
        // (15000 + 25000) / 2 = 20000.00
        $this->assertEquals(20000.00, $kpis2['average_booking_value']);

        // Case 3: Zero confirmed paid bookings in range
        $today = Carbon::now('Asia/Kolkata')->startOfDay();
        $tomorrowRange = [
            'start_utc' => $today->copy()->addDays(10)->setTimezone('UTC'),
            'end_utc' => $today->copy()->addDays(11)->setTimezone('UTC'),
            'start_local' => $today->copy()->addDays(10),
            'end_local' => $today->copy()->addDays(11),
            'days_count' => 1,
            'preset' => 'custom',
        ];
        $emptyKpis = $this->analyticsService->getKpiSummary($tomorrowRange);
        $this->assertEquals(0.00, $emptyKpis['average_booking_value']);
    }

    public function test_processed_refund_filtering_excludes_pending_failed_and_conflicting_statuses(): void
    {
        $booking = $this->createTestBooking();

        // 1. Successfully processed partial refund: status = 'captured', refund_status = 'processed'
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_partial_proc',
            'amount' => 10000.00,
            'status' => 'captured',
            'refund_status' => 'processed',
            'refund_amount' => 2500.00,
            'refunded_at' => now(),
            'captured_at' => now(),
            'method' => 'card',
        ]);

        // 2. Pending refund: refund_status = 'pending' (MUST BE EXCLUDED)
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_pending_ref',
            'amount' => 5000.00,
            'status' => 'refund_pending',
            'refund_status' => 'pending',
            'refund_amount' => 5000.00,
            'method' => 'card',
        ]);

        // 3. Failed refund: refund_status = 'failed' (MUST BE EXCLUDED)
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_failed_ref',
            'amount' => 3000.00,
            'status' => 'captured',
            'refund_status' => 'failed',
            'refund_amount' => 3000.00,
            'method' => 'upi',
        ]);

        // 4. Conflicting status: status = 'refunded' but refund_status = 'failed' (MUST BE EXCLUDED)
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_conflicting',
            'amount' => 4000.00,
            'status' => 'refunded',
            'refund_status' => 'failed',
            'refund_amount' => 4000.00,
            'refunded_at' => now(),
            'method' => 'card',
        ]);

        // 5. Multiple payment records on same booking: 1 failed payment attempt and 1 captured
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_failed_attempt',
            'amount' => 10000.00,
            'status' => 'failed',
            'method' => 'card',
        ]);

        $range = $this->analyticsService->resolveDateRange('last_30_days');
        $kpis = $this->analyticsService->getKpiSummary($range);
        $cancellations = $this->analyticsService->getCancellationAnalytics($range);

        // ONLY the successfully processed partial refund of ₹2,500 must be counted
        $this->assertEquals(2500.00, $kpis['total_refunds']);
        $this->assertEquals(2500.00, $cancellations['total_refund_amount']);
        $this->assertEquals(1, $cancellations['refund_completed_count']);
        $this->assertEquals(1, $cancellations['refund_pending_count']);
        $this->assertEquals(2, $cancellations['refund_failed_count']); // 2 failed refunds: pay_failed_ref and pay_conflicting
    }
}
