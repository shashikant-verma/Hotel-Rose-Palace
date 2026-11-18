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
        Schema::table('bookings', function (Blueprint $table) {
            // Add pricing tracking columns to preserve exact prices at time of booking
            // This ensures admin price changes don't affect existing bookings
            $table->decimal('discount_amount', 10, 2)->default(0)->after('tax_amount')
                ->comment('Applied discount amount at time of booking');
            $table->string('pricing_source')->nullable()->after('discount_amount')
                ->comment('Source of pricing: base, seasonal, seasonal_with_promotion, base_with_promotion');
            $table->json('pricing_snapshot')->nullable()->after('pricing_source')
                ->comment('Snapshot of pricing details for this booking (nightly breakdown)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('discount_amount');
            $table->dropColumn('pricing_source');
            $table->dropColumn('pricing_snapshot');
        });
    }
};
