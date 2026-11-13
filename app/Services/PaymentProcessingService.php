<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Models\RoomAllocation;
use App\Models\WebhookEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentProcessingService
{
    protected RazorpayService $razorpayService;
    protected RoomAllocationService $allocationService;
    protected RoomAvailabilityService $availabilityService;

    public function __construct(
        RazorpayService $razorpayService,
        RoomAllocationService $allocationService,
        RoomAvailabilityService $availabilityService
    ) {
        $this->razorpayService = $razorpayService;
        $this->allocationService = $allocationService;
        $this->availabilityService = $availabilityService;
    }

    /**
     * Initiate or reuse Razorpay Order for a Booking
     *
     * @param Booking $booking
     * @return array Checkout parameters for frontend
     * @throws Exception
     */
    public function initiateOrder(Booking $booking): array
    {
        // 1. Booking must not be already paid
        if ($booking->payment_status === 'paid') {
            throw new Exception('This booking has already been paid and confirmed.');
        }

        // 2. Strict backend calculation of amount in paise (never trust browser)
        $amountInRupees = (float) $booking->total_amount;
        if ($amountInRupees <= 0) {
            throw new Exception('Invalid booking total amount.');
        }
        $amountInPaise = (int) round($amountInRupees * 100);

        // 3. Prevent duplicate active orders for the same booking
        // Check for an existing 'created' payment for this booking created within reservation duration
        $reservationMinutes = (int) config('razorpay.reservation_duration_minutes', 15);
        $activePayment = Payment::where('booking_id', $booking->id)
            ->where('status', 'created')
            ->where('created_at', '>=', now()->subMinutes($reservationMinutes))
            ->latest()
            ->first();

        if ($activePayment && !empty($activePayment->razorpay_order_id)) {
            $orderId = $activePayment->razorpay_order_id;
        } else {
            // Create a fresh Razorpay order
            $orderPayload = [
                'amount' => $amountInPaise,
                'currency' => config('razorpay.currency', 'INR'),
                'receipt' => (string) $booking->booking_reference,
                'notes' => [
                    'booking_id' => (string) $booking->id,
                    'booking_reference' => (string) $booking->booking_reference,
                    'customer_mobile' => (string) $booking->customer_mobile,
                    'room_type_id' => (string) $booking->room_type_id,
                ],
            ];

            $razorpayOrder = $this->razorpayService->createOrder($orderPayload);
            $orderId = $razorpayOrder['id'];

            // Store payment attempt record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'razorpay_order_id' => $orderId,
                'amount' => $amountInRupees,
                'currency' => config('razorpay.currency', 'INR'),
                'status' => 'created',
                'idempotency_key' => 'order_init_' . $booking->id . '_' . now()->timestamp,
            ]);

            // Update booking with real order ID
            $booking->update([
                'razorpay_order_id' => $orderId,
            ]);

            PaymentLog::record(
                $booking->id,
                $payment->id,
                'order.created',
                'checkout',
                ['order_id' => $orderId, 'amount_paise' => $amountInPaise]
            );
        }

        // Return only safe public information for Razorpay Checkout modal
        return [
            'key' => config('razorpay.key_id'),
            'amount' => $amountInPaise,
            'currency' => config('razorpay.currency', 'INR'),
            'name' => config('razorpay.brand_name', 'Hotel Rose Palace'),
            'description' => 'Room Reservation: ' . ($booking->roomType?->name ?? 'Room Booking') . ' (' . $booking->booking_reference . ')',
            'order_id' => $orderId,
            'prefill' => [
                'name' => $booking->customer_name,
                'email' => $booking->customer_email,
                'contact' => $booking->customer_mobile,
            ],
            'notes' => [
                'booking_reference' => $booking->booking_reference,
            ],
            'theme' => [
                'color' => config('razorpay.brand_theme_color', '#800020'),
            ],
        ];
    }

    /**
     * Verify payment signature and confirm booking
     *
     * @param Booking $booking
     * @param array $paymentData [razorpay_payment_id, razorpay_order_id, razorpay_signature]
     * @return array [success => bool, message => string, booking => Booking, payment => Payment]
     * @throws Exception
     */
    public function verifyAndConfirm(Booking $booking, array $paymentData): array
    {
        $paymentId = $paymentData['razorpay_payment_id'] ?? null;
        $orderId = $paymentData['razorpay_order_id'] ?? null;
        $signature = $paymentData['razorpay_signature'] ?? null;

        if (!$paymentId || !$orderId || !$signature) {
            throw new Exception('Missing required Razorpay payment verification parameters.');
        }

        // 1. Order ID must match booking's recorded order ID
        if ($booking->razorpay_order_id !== $orderId) {
            PaymentLog::record(
                $booking->id,
                null,
                'signature.mismatch',
                'checkout',
                ['expected' => $booking->razorpay_order_id, 'received' => $orderId]
            );
            throw new Exception('Order ID verification failed.');
        }

        // 2. Cryptographic signature verification using HMAC-SHA256
        $isValidSignature = $this->razorpayService->verifyPaymentSignature($orderId, $paymentId, $signature);

        if (!$isValidSignature) {
            PaymentLog::record(
                $booking->id,
                null,
                'signature.invalid',
                'checkout',
                ['order_id' => $orderId, 'payment_id' => $paymentId]
            );
            throw new Exception('Payment signature verification failed.');
        }

        // 3. Idempotency Check: if booking is already paid with this payment ID, return idempotent success
        if ($booking->payment_status === 'paid' && $booking->razorpay_payment_id === $paymentId) {
            $payment = Payment::where('razorpay_payment_id', $paymentId)->first();
            return [
                'success' => true,
                'idempotent' => true,
                'message' => 'Payment has already been verified and booking confirmed.',
                'booking' => $booking,
                'payment' => $payment,
            ];
        }

        // 4. Fetch payment details directly from Razorpay API to verify amount & currency
        $paymentDetails = $this->razorpayService->fetchPayment($paymentId);

        $expectedPaise = (int) round(((float) $booking->total_amount) * 100);
        $actualPaise = (int) ($paymentDetails['amount'] ?? 0);
        $currency = $paymentDetails['currency'] ?? 'INR';

        if ($actualPaise !== $expectedPaise || strtoupper($currency) !== 'INR') {
            PaymentLog::record(
                $booking->id,
                null,
                'amount.mismatch',
                'checkout',
                ['expected_paise' => $expectedPaise, 'actual_paise' => $actualPaise, 'currency' => $currency]
            );
            throw new Exception('Payment amount verification mismatch.');
        }

        // 5. Database transaction to lock and confirm allocation or execute safe auto-refund if room expired
        return DB::transaction(function () use ($booking, $paymentId, $orderId, $signature, $paymentDetails, $actualPaise) {
            // Reload fresh booking with lock
            $freshBooking = Booking::where('id', $booking->id)->lockForUpdate()->first();

            // Locate or create payment record
            $payment = Payment::where('razorpay_order_id', $orderId)->first();
            if (!$payment) {
                $payment = Payment::create([
                    'booking_id' => $freshBooking->id,
                    'razorpay_order_id' => $orderId,
                    'amount' => $freshBooking->total_amount,
                    'currency' => 'INR',
                    'status' => 'created',
                ]);
            }

            // Update payment details
            $payment->update([
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'method' => $paymentDetails['method'] ?? 'card',
                'bank' => $paymentDetails['bank'] ?? null,
                'wallet' => $paymentDetails['wallet'] ?? null,
                'vpa' => $paymentDetails['vpa'] ?? null,
                'fee' => isset($paymentDetails['fee']) ? ((float) $paymentDetails['fee']) / 100 : 0.00,
                'tax' => isset($paymentDetails['tax']) ? ((float) $paymentDetails['tax']) / 100 : 0.00,
                'payload' => $paymentDetails,
            ]);

            // Check if room allocations already exist for this booking
            $existingAllocations = RoomAllocation::where('booking_id', $freshBooking->id)->get();
            $hasActiveAllocations = $existingAllocations->where('allocation_status', '!=', 'released')->count() >= $freshBooking->room_quantity;

            $canConfirm = false;

            if ($hasActiveAllocations) {
                // Temporary allocations already held for this booking: confirm them
                foreach ($existingAllocations as $alloc) {
                    if ($alloc->allocation_status !== 'confirmed') {
                        $alloc->update([
                            'allocation_status' => 'confirmed',
                            'allocated_at' => now(),
                        ]);
                    }
                }
                $canConfirm = true;
            } else {
                // Check if rooms are still available right now
                $availability = $this->availabilityService->getAvailableRooms(
                    $freshBooking->room_type_id,
                    $freshBooking->check_in_date,
                    $freshBooking->check_out_date
                );

                if ($availability['available_quantity'] >= $freshBooking->room_quantity) {
                    // Allocate available physical rooms
                    $physicalRooms = $this->availabilityService->getAvailablePhysicalRooms(
                        $freshBooking->room_type_id,
                        $freshBooking->check_in_date,
                        $freshBooking->check_out_date
                    )->take($freshBooking->room_quantity);

                    foreach ($physicalRooms as $room) {
                        RoomAllocation::create([
                            'booking_id' => $freshBooking->id,
                            'room_id' => $room->id,
                            'check_in_date' => $freshBooking->check_in_date,
                            'check_out_date' => $freshBooking->check_out_date,
                            'allocation_status' => 'confirmed',
                            'allocated_at' => now(),
                        ]);
                    }
                    $canConfirm = true;
                }
            }

            // Room Hold Expired & No Rooms Available Edge Case: Safe Auto-Refund
            if (!$canConfirm) {
                PaymentLog::record(
                    $freshBooking->id,
                    $payment->id,
                    'allocation.expired_overbooking_prevented',
                    'checkout',
                    ['payment_id' => $paymentId, 'booking_id' => $freshBooking->id]
                );

                // Auto-refund to prevent overbooking
                $refundResult = null;
                try {
                    $refundResult = $this->razorpayService->refundPayment(
                        $paymentId,
                        $actualPaise,
                        'Reservation hold expired; room no longer available. Auto-refund initiated.'
                    );
                } catch (Exception $re) {
                    Log::critical('Auto-refund API call failed: ' . $re->getMessage(), ['payment_id' => $paymentId]);
                }

                // Never assume a refund is completed until Razorpay confirms it ('processed')
                $isProcessed = ($refundResult && ($refundResult['status'] ?? '') === 'processed');
                $refundStatus = $refundResult['status'] ?? ($refundResult ? 'pending' : 'failed');

                $payment->update([
                    'status' => $isProcessed ? 'refunded' : 'refund_pending',
                    'refund_id' => $refundResult['id'] ?? null,
                    'refund_status' => $refundStatus,
                    'refund_amount' => $freshBooking->total_amount,
                    'refund_reason' => 'Room hold expired and no rooms available. Overbooking prevented.',
                    'refunded_at' => $isProcessed ? now() : null,
                ]);

                $freshBooking->update([
                    'booking_status' => 'cancelled',
                    'payment_status' => $isProcessed ? 'refunded' : 'pending',
                    'razorpay_payment_id' => $paymentId,
                    'special_requests' => trim(($freshBooking->special_requests ?? '') . ' [System: Room hold expired prior to payment; ' . ($isProcessed ? '100% refund processed' : 'refund pending gateway confirmation') . ']'),
                ]);

                return [
                    'success' => false,
                    'overbooked' => true,
                    'message' => 'Your reservation hold expired before payment was completed, and the selected room is no longer available. A full refund has been initiated to your original payment method.',
                    'booking' => $freshBooking,
                    'payment' => $payment,
                ];
            }

            // Normal Success Path: Confirm Booking & Payment
            $payment->update([
                'status' => 'captured',
                'captured_at' => now(),
            ]);

            $freshBooking->update([
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'razorpay_payment_id' => $paymentId,
            ]);

            PaymentLog::record(
                $freshBooking->id,
                $payment->id,
                'payment.captured',
                'checkout',
                ['payment_id' => $paymentId, 'order_id' => $orderId, 'amount' => $freshBooking->total_amount]
            );

            return [
                'success' => true,
                'message' => 'Payment successful! Your booking is confirmed.',
                'booking' => $freshBooking,
                'payment' => $payment,
            ];
        });
    }

    /**
     * Process Razorpay Webhook Event Idempotently
     *
     * @param string $rawBody
     * @param string $signature
     * @return array [success => bool, message => string]
     * @throws Exception
     */
    public function processWebhook(string $rawBody, string $signature): array
    {
        // 1. Cryptographic webhook signature verification
        $isValid = $this->razorpayService->verifyWebhookSignature($rawBody, $signature);
        if (!$isValid) {
            PaymentLog::record(
                null,
                null,
                'webhook.invalid_signature',
                'webhook',
                ['error' => 'Invalid webhook signature received from Razorpay endpoint']
            );
            throw new Exception('Invalid webhook signature.');
        }

        $payload = json_decode($rawBody, true);
        if (!$payload || !isset($payload['event'])) {
            throw new Exception('Invalid webhook payload format.');
        }

        $event = $payload['event'];
        $eventId = $payload['event_id'] ?? ($payload['id'] ?? null);

        // 2. Webhook Idempotency: Prevent duplicate event processing
        if ($eventId) {
            $existingEvent = WebhookEvent::where('event_id', $eventId)->first();
            if ($existingEvent && $existingEvent->isProcessed()) {
                return [
                    'success' => true,
                    'message' => 'Webhook event already processed (idempotent)',
                    'event_id' => $eventId,
                ];
            }
        }

        // Record incoming webhook event
        $webhookRecord = WebhookEvent::create([
            'event_id' => $eventId,
            'event_type' => $event,
            'payload' => $payload,
            'is_processed' => false,
        ]);

        try {
            DB::transaction(function () use ($event, $payload, $webhookRecord) {
                switch ($event) {
                    case 'payment.captured':
                        $this->handlePaymentCapturedWebhook($payload);
                        break;

                    case 'payment.failed':
                        $this->handlePaymentFailedWebhook($payload);
                        break;

                    case 'order.paid':
                        $this->handleOrderPaidWebhook($payload);
                        break;

                    case 'refund.processed':
                        $this->handleRefundProcessedWebhook($payload);
                        break;

                    case 'refund.failed':
                        $this->handleRefundFailedWebhook($payload);
                        break;

                    case 'refund.created':
                        $this->handleRefundCreatedWebhook($payload);
                        break;

                    default:
                        Log::info('Unhandled Razorpay webhook event: ' . $event);
                        break;
                }

                $webhookRecord->markProcessed();
            });

            return [
                'success' => true,
                'message' => 'Webhook processed successfully',
            ];
        } catch (Exception $e) {
            $webhookRecord->markFailed($e->getMessage());
            PaymentLog::record(
                null,
                null,
                'webhook.processing_error',
                'webhook',
                ['event' => $event, 'error' => $e->getMessage()]
            );
            throw $e;
        }
    }

    /**
     * Handle payment.captured webhook
     */
    protected function handlePaymentCapturedWebhook(array $payload): void
    {
        $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
        if (!$paymentEntity) {
            return;
        }

        $orderId = $paymentEntity['order_id'] ?? null;
        $paymentId = $paymentEntity['id'] ?? null;

        if (!$orderId || !$paymentId) {
            return;
        }

        $booking = Booking::where('razorpay_order_id', $orderId)->first();
        if (!$booking) {
            Log::warning('Webhook payment.captured received for unknown order: ' . $orderId);
            return;
        }

        // If booking not yet marked as paid, confirm it
        if ($booking->payment_status !== 'paid') {
            $payment = Payment::where('razorpay_order_id', $orderId)->first();
            if ($payment) {
                $payment->update([
                    'razorpay_payment_id' => $paymentId,
                    'status' => 'captured',
                    'captured_at' => now(),
                    'payload' => $paymentEntity,
                ]);
            }

            // Confirm allocations
            $allocations = RoomAllocation::where('booking_id', $booking->id)->get();
            foreach ($allocations as $alloc) {
                if ($alloc->allocation_status !== 'confirmed') {
                    $alloc->update(['allocation_status' => 'confirmed', 'allocated_at' => now()]);
                }
            }

            $booking->update([
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'razorpay_payment_id' => $paymentId,
            ]);

            PaymentLog::record(
                $booking->id,
                $payment?->id,
                'webhook.payment.captured',
                'webhook',
                ['payment_id' => $paymentId, 'order_id' => $orderId]
            );
        }
    }

    /**
     * Handle payment.failed webhook
     */
    protected function handlePaymentFailedWebhook(array $payload): void
    {
        $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
        if (!$paymentEntity) {
            return;
        }

        $orderId = $paymentEntity['order_id'] ?? null;
        $paymentId = $paymentEntity['id'] ?? null;
        $errorCode = $paymentEntity['error_code'] ?? 'UNKNOWN_ERROR';
        $errorDescription = $paymentEntity['error_description'] ?? 'Payment failed at gateway';

        if (!$orderId) {
            return;
        }

        $booking = Booking::where('razorpay_order_id', $orderId)->first();
        $payment = Payment::where('razorpay_order_id', $orderId)->first();

        if ($payment) {
            $payment->update([
                'razorpay_payment_id' => $paymentId,
                'status' => 'failed',
                'error_code' => $errorCode,
                'error_description' => $errorDescription,
                'payload' => $paymentEntity,
            ]);
        }

        PaymentLog::record(
            $booking?->id,
            $payment?->id,
            'webhook.payment.failed',
            'webhook',
            ['error_code' => $errorCode, 'error_description' => $errorDescription, 'payment_id' => $paymentId]
        );
    }

    /**
     * Handle order.paid webhook
     */
    protected function handleOrderPaidWebhook(array $payload): void
    {
        $orderEntity = $payload['payload']['order']['entity'] ?? null;
        if (!$orderEntity) {
            return;
        }

        $orderId = $orderEntity['id'] ?? null;
        if (!$orderId) {
            return;
        }

        $booking = Booking::where('razorpay_order_id', $orderId)->first();
        if ($booking && $booking->payment_status !== 'paid') {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
            ]);
        }
    }

    /**
     * Handle refund.processed webhook
     */
    protected function handleRefundProcessedWebhook(array $payload): void
    {
        $refundEntity = $payload['payload']['refund']['entity'] ?? null;
        if (!$refundEntity) {
            return;
        }

        $refundId = $refundEntity['id'] ?? null;
        $paymentId = $refundEntity['payment_id'] ?? null;

        if (!$paymentId) {
            return;
        }

        $payment = Payment::where('razorpay_payment_id', $paymentId)->first();
        if (!$payment) {
            Log::warning('Webhook refund.processed received for unknown payment: ' . $paymentId);
            return;
        }

        $payment->update([
            'refund_id' => $refundId,
            'refund_status' => 'processed',
            'refunded_at' => now(),
        ]);

        if ($payment->booking) {
            $payment->booking->update([
                'refund_status' => 'processed',
            ]);
        }

        PaymentLog::record(
            $payment->booking_id,
            $payment->id,
            'webhook.refund.processed',
            'webhook',
            ['refund_id' => $refundId, 'payment_id' => $paymentId]
        );
    }

    /**
     * Handle refund.failed webhook
     */
    protected function handleRefundFailedWebhook(array $payload): void
    {
        $refundEntity = $payload['payload']['refund']['entity'] ?? null;
        if (!$refundEntity) {
            return;
        }

        $refundId = $refundEntity['id'] ?? null;
        $paymentId = $refundEntity['payment_id'] ?? null;

        if (!$paymentId) {
            return;
        }

        $payment = Payment::where('razorpay_payment_id', $paymentId)->first();
        if ($payment) {
            $payment->update([
                'refund_status' => 'failed',
                'refund_error' => $refundEntity['error_description'] ?? 'Refund failed via webhook',
            ]);

            if ($payment->booking) {
                $payment->booking->update([
                    'refund_status' => 'failed',
                ]);
            }
        }

        PaymentLog::record(
            $payment?->booking_id,
            $payment?->id,
            'webhook.refund.failed',
            'webhook',
            ['refund_id' => $refundId, 'payment_id' => $paymentId]
        );
    }

    /**
     * Handle refund.created webhook
     */
    protected function handleRefundCreatedWebhook(array $payload): void
    {
        $refundEntity = $payload['payload']['refund']['entity'] ?? null;
        if (!$refundEntity) {
            return;
        }

        $refundId = $refundEntity['id'] ?? null;
        $paymentId = $refundEntity['payment_id'] ?? null;

        PaymentLog::record(
            null,
            null,
            'webhook.refund.created',
            'webhook',
            ['refund_id' => $refundId, 'payment_id' => $paymentId]
        );
    }
}
