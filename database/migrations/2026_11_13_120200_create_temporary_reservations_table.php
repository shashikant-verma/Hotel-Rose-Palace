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
        Schema::create('temporary_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_token', 100)->unique();
            $table->string('customer_mobile', 20);
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->integer('room_quantity')->default(1);
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->decimal('total_amount', 12, 2);
            $table->string('razorpay_order_id', 100)->nullable();
            $table->timestamp('expires_at');
            $table->enum('status', ['active', 'expired', 'converted', 'released'])->default('active');
            $table->timestamps();

            // Indexes for common queries
            $table->index('customer_mobile');
            $table->index('room_type_id');
            $table->index('status');
            $table->index('expires_at');
            $table->index(['check_in_date', 'check_out_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_reservations');
    }
};
