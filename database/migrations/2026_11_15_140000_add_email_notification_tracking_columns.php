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
            $table->timestamp('confirmation_email_sent_at')->nullable()->after('payment_status');
            $table->timestamp('cancellation_email_sent_at')->nullable()->after('cancelled_at');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('receipt_email_sent_at')->nullable()->after('captured_at');
            $table->timestamp('refund_email_sent_at')->nullable()->after('refunded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['confirmation_email_sent_at', 'cancellation_email_sent_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['receipt_email_sent_at', 'refund_email_sent_at']);
        });
    }
};
