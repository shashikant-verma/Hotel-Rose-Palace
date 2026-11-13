<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('razorpay_order_id', 100)->index();
            $table->string('razorpay_payment_id', 100)->nullable()->unique();
            $table->string('razorpay_signature', 255)->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('INR');
            $table->enum('status', ['created', 'authorized', 'captured', 'failed', 'refunded', 'refund_pending'])->default('created');
            $table->string('method', 50)->nullable();
            $table->string('card_network', 50)->nullable();
            $table->string('card_last4', 10)->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('wallet', 100)->nullable();
            $table->string('vpa', 100)->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->string('error_code', 100)->nullable();
            $table->text('error_description')->nullable();
            $table->string('refund_id', 100)->nullable();
            $table->string('refund_status', 50)->nullable();
            $table->decimal('refund_amount', 12, 2)->nullable();
            $table->string('refund_reason', 255)->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->string('idempotency_key', 150)->nullable();
            $table->json('payload')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();

            // Indexes for fast lookup
            $table->index(['booking_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
