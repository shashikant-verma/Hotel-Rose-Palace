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
        Schema::create('seasonal_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')
                ->constrained('room_types')
                ->cascadeOnDelete();
            
            $table->decimal('price', 10, 2)->comment('Price per night during this seasonal period');
            $table->date('start_date')->comment('Start date of seasonal pricing');
            $table->date('end_date')->comment('End date of seasonal pricing');
            $table->string('season_name')->nullable()->comment('Name of season (e.g., Diwali, New Year, Holi, Weekend)');
            $table->boolean('is_active')->default(true)->comment('Active/inactive status');
            
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
        Schema::dropIfExists('seasonal_pricing');
    }
};
