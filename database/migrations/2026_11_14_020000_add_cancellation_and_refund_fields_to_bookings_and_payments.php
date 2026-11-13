<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Convert booking_status from original Phase 8C ENUM to VARCHAR(50)
        // to safely support 'cancellation_requested' on both fresh and existing MySQL databases
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE `bookings` MODIFY COLUMN `booking_status` VARCHAR(50) NOT NULL DEFAULT 'confirmed'");
        } else {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('booking_status', 50)->default('confirmed')->change();
            });
        }

        Schema::table('bookings', function (Blueprint $table) {
            // Cancellation tracking fields
            if (!Schema::hasColumn('bookings', 'cancellation_status')) {
                $table->string('cancellation_status', 50)->default('none')->after('cancellation_reason');
            }
            if (!Schema::hasColumn('bookings', 'cancellation_requested_at')) {
                $table->timestamp('cancellation_requested_at')->nullable()->after('cancellation_status');
            }
            if (!Schema::hasColumn('bookings', 'cancellation_reviewed_at')) {
                $table->timestamp('cancellation_reviewed_at')->nullable()->after('cancellation_requested_at');
            }
            if (!Schema::hasColumn('bookings', 'cancellation_reviewed_by')) {
                $table->foreignId('cancellation_reviewed_by')->nullable()->after('cancellation_reviewed_at')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'cancellation_admin_notes')) {
                $table->text('cancellation_admin_notes')->nullable()->after('cancellation_reviewed_by');
            }
            if (!Schema::hasColumn('bookings', 'cancellation_rejection_reason')) {
                $table->text('cancellation_rejection_reason')->nullable()->after('cancellation_admin_notes');
            }
            if (!Schema::hasColumn('bookings', 'eligible_refund_percentage')) {
                $table->integer('eligible_refund_percentage')->nullable()->after('cancellation_rejection_reason');
            }
            if (!Schema::hasColumn('bookings', 'eligible_refund_amount')) {
                $table->decimal('eligible_refund_amount', 12, 2)->nullable()->after('eligible_refund_percentage');
            }
            if (!Schema::hasColumn('bookings', 'refund_status')) {
                $table->string('refund_status', 50)->nullable()->after('eligible_refund_amount');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'refund_attempts')) {
                $table->integer('refund_attempts')->default(0)->after('refunded_at');
            }
            if (!Schema::hasColumn('payments', 'refund_initiated_at')) {
                $table->timestamp('refund_initiated_at')->nullable()->after('refund_attempts');
            }
            if (!Schema::hasColumn('payments', 'refund_error')) {
                $table->text('refund_error')->nullable()->after('refund_initiated_at');
            }
            if (!Schema::hasColumn('payments', 'idempotency_key')) {
                $table->string('idempotency_key', 255)->nullable()->unique()->after('refund_error');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        // Safety check before rollback: prevent converting ENUM if cancellation_requested bookings exist
        if ($driver === 'mysql' || $driver === 'mariadb') {
            $cancelRequested = DB::table('bookings')
                ->where('booking_status', 'cancellation_requested')
                ->count();

            if ($cancelRequested > 0) {
                throw new \Exception(
                    "Cannot rollback Phase 8F migration: {$cancelRequested} booking(s) have status 'cancellation_requested'. "
                    . "These must be approved/rejected first before migration rollback. "
                    . "Update them to 'confirmed' or 'cancelled' status and retry."
                );
            }
        }

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['cancellation_reviewed_by']);
            $table->dropColumn([
                'cancellation_status',
                'cancellation_requested_at',
                'cancellation_reviewed_at',
                'cancellation_reviewed_by',
                'cancellation_admin_notes',
                'cancellation_rejection_reason',
                'eligible_refund_percentage',
                'eligible_refund_amount',
                'refund_status',
            ]);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'refund_attempts',
                'refund_initiated_at',
                'refund_error',
                'idempotency_key',
            ]);
        });

        // Revert booking_status to original enum on MySQL if rolled back
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE `bookings` MODIFY COLUMN `booking_status` ENUM('confirmed', 'cancelled', 'checked_in', 'checked_out') NOT NULL DEFAULT 'confirmed'");
        }
    }
};
