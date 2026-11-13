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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference', 50)->unique();
            $table->string('customer_name');
            $table->string('customer_mobile', 20);
            $table->string('customer_email')->nullable();
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('restrict');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('num_adults')->default(2);
            $table->integer('num_children')->default(0);
            $table->integer('room_quantity')->default(1);
            $table->decimal('base_amount', 12, 2);
            $table->decimal('tax_amount', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('razorpay_order_id', 100)->unique();
            $table->string('razorpay_payment_id', 100)->nullable()->unique();
            $table->enum('booking_status', ['confirmed', 'cancelled', 'checked_in', 'checked_out'])->default('confirmed');
            $table->enum('payment_status', ['pending', 'paid', 'refunded', 'partially_refunded'])->default('pending');
            $table->longText('special_requests')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for common queries
            $table->index('customer_mobile');
            $table->index(['check_in_date', 'check_out_date']);
            $table->index('booking_status');
            $table->index('payment_status');
            $table->index('room_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
