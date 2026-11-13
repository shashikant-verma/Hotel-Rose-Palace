<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class RazorpayService
{
    protected string $keyId;
    protected string $keySecret;
    protected string $webhookSecret;
    protected string $baseUrl;

    public function __construct()
    {
        $this->keyId = config('razorpay.key_id', env('RAZORPAY_KEY_ID', ''));
        $this->keySecret = config('razorpay.key_secret', env('RAZORPAY_KEY_SECRET', ''));
        $this->webhookSecret = config('razorpay.webhook_secret', env('RAZORPAY_WEBHOOK_SECRET', ''));
        $this->baseUrl = rtrim(config('razorpay.api_base_url', 'https://api.razorpay.com/v1'), '/');

        if (empty($this->keyId) || empty($this->keySecret)) {
            Log::warning('Razorpay API keys are not configured in environment or config.');
        }
    }

    public function getKeyId(): string
    {
        return $this->keyId;
    }

    /**
     * Create an order on Razorpay using trusted backend booking amount.
     * Never trusts any amount sent by the client browser.
     *
     * @param Booking|array $bookingOrData
     * @return array Razorpay order payload
     * @throws Exception
     */
    public function createOrder($bookingOrData): array
    {
        if ($bookingOrData instanceof Booking) {
            $booking = $bookingOrData;
            if ($booking->total_amount <= 0) {
                throw new Exception("Invalid booking total amount for order creation.");
            }

            $amountInPaise = (int) round($booking->total_amount * 100);
            $currency = config('razorpay.currency', 'INR');
            $receipt = 'rcpt_' . $booking->id . '_' . substr(md5($booking->booking_reference . microtime()), 0, 8);

            $payload = [
                'amount' => $amountInPaise,
                'currency' => $currency,
                'receipt' => $receipt,
                'notes' => [
                    'booking_id' => (string) $booking->id,
                    'booking_reference' => (string) $booking->booking_reference,
                    'customer_mobile' => (string) $booking->customer_mobile,
                    'room_type_id' => (string) $booking->room_type_id,
                    'hotel' => 'Hotel Rose Palace Surat',
                ],
            ];
            $bookingId = $booking->id;
        } else {
            $payload = (array) $bookingOrData;
            $amountInPaise = $payload['amount'] ?? 0;
            $bookingId = isset($payload['notes']['booking_id']) ? (int) $payload['notes']['booking_id'] : null;
            $receipt = $payload['receipt'] ?? 'rcpt_' . uniqid();
        }

        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->post("{$this->baseUrl}/orders", $payload);

            if ($response->successful()) {
                $orderData = $response->json();

                PaymentLog::record(
                    $bookingId,
                    null,
                    'razorpay_order_created',
                    'api',
                    [
                        'order_id' => $orderData['id'],
                        'amount_paise' => $amountInPaise,
                        'receipt' => $receipt,
                    ]
                );

                return $orderData;
            }

            $errorBody = $response->json() ?? [];
            $errorDesc = $errorBody['error']['description'] ?? 'Razorpay order creation failed';

            Log::error('Razorpay order creation API error', [
                'booking_id' => $bookingId,
                'status' => $response->status(),
                'error' => $errorDesc,
            ]);

            PaymentLog::record(
                $bookingId,
                null,
                'razorpay_order_failed',
                'api',
                ['error' => $errorDesc, 'status' => $response->status()]
            );

            throw new Exception("Unable to initiate payment with payment gateway: {$errorDesc}");
        } catch (Exception $e) {
            Log::error('Exception in RazorpayService::createOrder: ' . $e->getMessage(), [
                'booking_id' => $bookingId,
            ]);
            throw $e;
        }
    }

    /**
     * Fetch payment details from Razorpay by Payment ID
     */
    public function fetchPayment(string $paymentId): array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->get("{$this->baseUrl}/payments/{$paymentId}");

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception("Failed to fetch Razorpay payment ({$paymentId}): " . $response->body());
        } catch (Exception $e) {
            Log::error('Exception in RazorpayService::fetchPayment: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verify Razorpay Checkout HMAC-SHA256 signature.
     * signature = hmac_sha256(order_id + "|" + payment_id, key_secret)
     */
    public function verifyPaymentSignature($orderIdOrAttributes, ?string $paymentId = null, ?string $signature = null): bool
    {
        if (is_array($orderIdOrAttributes)) {
            $orderId = $orderIdOrAttributes['razorpay_order_id'] ?? '';
            $paymentId = $orderIdOrAttributes['razorpay_payment_id'] ?? '';
            $signature = $orderIdOrAttributes['razorpay_signature'] ?? '';
        } else {
            $orderId = (string) $orderIdOrAttributes;
        }

        if (empty($orderId) || empty($paymentId) || empty($signature) || empty($this->keySecret)) {
            return false;
        }

        $payload = $orderId . '|' . $paymentId;
        $expectedSignature = hash_hmac('sha256', $payload, $this->keySecret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Verify Razorpay Webhook signature using webhook secret.
     * signature = hmac_sha256(raw_request_body, webhook_secret)
     */
    public function verifyWebhookSignature(string $rawPayload, string $signature): bool
    {
        if (empty($this->webhookSecret) || empty($signature) || empty($rawPayload)) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $rawPayload, $this->webhookSecret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Manually capture a payment if authorized
     */
    public function capturePayment(string $paymentId, int $amountInPaise, string $currency = 'INR'): array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->post("{$this->baseUrl}/payments/{$paymentId}/capture", [
                    'amount' => $amountInPaise,
                    'currency' => $currency,
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception("Failed to capture Razorpay payment: " . $response->body());
        } catch (Exception $e) {
            Log::error('Exception in RazorpayService::capturePayment: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Initiate a refund on Razorpay with verified idempotency protection.
     * 
     * Razorpay officially supports the X-Idempotency-Key header (same as Stripe).
     * See: https://razorpay.com/docs/api/refunds/#create-a-refund
     * 
     * The key must be deterministic based on the payment operation, not random per request.
     * If the client retries with the same idempotency key, Razorpay returns the existing refund.
     * This prevents duplicate refunds after network timeouts.
     *
     * @param string $paymentId Razorpay payment ID
     * @param int|null $amountInPaise Refund amount in paise (null = full refund)
     * @param string|null $reason Refund reason
     * @param string|null $idempotencyKey Optional idempotency key (generated if not provided)
     * @return array Razorpay refund response
     */
    public function refundPayment(
        string $paymentId,
        ?int $amountInPaise = null,
        ?string $reason = null,
        ?string $idempotencyKey = null
    ): array {
        $payload = [];
        if ($amountInPaise !== null && $amountInPaise > 0) {
            $payload['amount'] = $amountInPaise;
        }
        if (!empty($reason)) {
            $payload['notes'] = ['reason' => $reason];
        }

        // Generate idempotency key if not provided
        // Key must be deterministic: based on payment ID + amount to ensure idempotency
        // If retry happens with same parameters, Razorpay returns existing refund
        if (!$idempotencyKey) {
            $idempotencyKey = 'refund_' . $paymentId . '_' . ($amountInPaise ?? 'full') . '_' . hash('sha256', json_encode($payload));
        }

        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->withHeader('X-Idempotency-Key', $idempotencyKey)  // Razorpay idempotency header
                ->timeout(15)
                ->post("{$this->baseUrl}/payments/{$paymentId}/refund", $payload);

            if ($response->successful()) {
                $refundData = $response->json();

                PaymentLog::record(
                    null,
                    null,
                    'razorpay_refund_initiated',
                    'api',
                    [
                        'payment_id' => $paymentId,
                        'refund_id' => $refundData['id'] ?? null,
                        'amount_paise' => $amountInPaise,
                        'idempotency_key' => $idempotencyKey,
                        'reason' => $reason,
                    ]
                );

                return $refundData;
            }

            throw new Exception("Failed to refund Razorpay payment: " . $response->body());
        } catch (Exception $e) {
            Log::error('Exception in RazorpayService::refundPayment: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch a specific refund by Payment ID and Refund ID from Razorpay
     */
    public function fetchRefund(string $paymentId, string $refundId): array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->get("{$this->baseUrl}/payments/{$paymentId}/refunds/{$refundId}");

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception("Failed to fetch Razorpay refund ({$refundId}): " . $response->body());
        } catch (Exception $e) {
            Log::error('Exception in RazorpayService::fetchRefund: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch all refunds for a specific payment
     */
    public function fetchPaymentRefunds(string $paymentId): array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->get("{$this->baseUrl}/payments/{$paymentId}/refunds");

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception("Failed to fetch Razorpay refunds for payment ({$paymentId}): " . $response->body());
        } catch (Exception $e) {
            Log::error('Exception in RazorpayService::fetchPaymentRefunds: ' . $e->getMessage());
            throw $e;
        }
    }
}
