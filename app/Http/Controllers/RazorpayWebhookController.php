<?php

namespace App\Http\Controllers;

use App\Services\PaymentProcessingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class RazorpayWebhookController extends Controller
{
    protected PaymentProcessingService $paymentService;

    public function __construct(PaymentProcessingService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Handle incoming Razorpay Webhook notification
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $signature = $request->header('X-Razorpay-Signature');
        if (empty($signature)) {
            Log::warning('Razorpay webhook called without X-Razorpay-Signature header', [
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Missing X-Razorpay-Signature header',
            ], 400);
        }

        $rawBody = $request->getContent();
        if (empty($rawBody)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Empty webhook payload',
            ], 400);
        }

        try {
            $result = $this->paymentService->processWebhook($rawBody, $signature);

            return response()->json([
                'status' => 'success',
                'message' => $result['message'] ?? 'Webhook processed',
            ], 200);

        } catch (Exception $e) {
            Log::error('Razorpay webhook handling failure', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
