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
        Schema::create('promotional_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Offer name (e.g., Early Bird Discount, Group Booking Offer)');
            $table->foreignId('room_type_id')
                ->constrained('room_types')
                ->cascadeOnDelete();
            
            $table->enum('discount_type', ['fixed_amount', 'percentage'])
                ->comment('Type of discount: fixed amount or percentage');
            $table->decimal('discount_value', 10, 2)
                ->comment('Discount amount or percentage value');
            
            $table->dateTime('start_date')->comment('Offer start date and time');
            $table->dateTime('end_date')->comment('Offer end date and time');
            $table->boolean('is_active')->default(true)->comment('Active/inactive status');
            
            $table->decimal('max_discount', 10, 2)->nullable()
                ->comment('Maximum discount amount in rupees (useful for percentage discounts)');
            
            $table->text('description')->nullable()->comment('Additional details about the offer');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for common queries
            $table->index(['room_type_id', 'is_active']);
            $table->index(['start_date', 'end_date', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotional_offers');
    }
};
