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
        // 1. Add housekeeping_status to rooms table
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'housekeeping_status')) {
                $table->string('housekeeping_status', 20)->default('clean')->after('status');
            }
        });

        // 2. Add PMS operational fields to enquiries table
        Schema::table('enquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('enquiries', 'room_id')) {
                $table->foreignId('room_id')->nullable()->after('room_type_id')->constrained('rooms')->nullOnDelete();
            }
            if (!Schema::hasColumn('enquiries', 'booking_type')) {
                $table->string('booking_type', 20)->default('website')->after('reference_id');
            }
            if (!Schema::hasColumn('enquiries', 'id_proof_type')) {
                $table->string('id_proof_type', 50)->nullable()->after('customer_phone');
            }
            if (!Schema::hasColumn('enquiries', 'id_proof_number')) {
                $table->string('id_proof_number', 50)->nullable()->after('id_proof_type');
            }
            if (!Schema::hasColumn('enquiries', 'payment_mode')) {
                $table->string('payment_mode', 50)->nullable()->after('special_requests');
            }
            if (!Schema::hasColumn('enquiries', 'payment_status')) {
                $table->string('payment_status', 20)->default('unpaid')->after('payment_mode');
            }
            if (!Schema::hasColumn('enquiries', 'paid_amount')) {
                $table->decimal('paid_amount', 10, 2)->default(0)->after('payment_status');
            }
            if (!Schema::hasColumn('enquiries', 'total_tariff')) {
                $table->decimal('total_tariff', 10, 2)->default(0)->after('paid_amount');
            }
            if (!Schema::hasColumn('enquiries', 'checked_in_at')) {
                $table->timestamp('checked_in_at')->nullable()->after('confirmed_at');
            }
            if (!Schema::hasColumn('enquiries', 'checked_out_at')) {
                $table->timestamp('checked_out_at')->nullable()->after('checked_in_at');
            }
        });

        // Allow status to accept checked_in, checked_out, etc.
        try {
            DB::statement("ALTER TABLE enquiries MODIFY status VARCHAR(50) DEFAULT 'new'");
        } catch (\Exception $e) {
            // Ignore if already modified or SQLite
        }

        // 3. Create banquet_bookings table
        if (!Schema::hasTable('banquet_bookings')) {
            Schema::create('banquet_bookings', function (Blueprint $table) {
                $table->id();
                $table->string('reference_id')->unique();
                $table->string('customer_name');
                $table->string('customer_phone');
                $table->string('customer_email')->nullable();
                $table->date('event_date');
                $table->string('slot', 30)->default('evening'); // morning, evening, full_day
                $table->string('event_type', 50)->default('wedding'); // wedding, corporate, birthday, exhibition, other
                $table->integer('guest_count')->default(100);
                $table->string('catering_package', 100)->nullable();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->decimal('advance_paid', 10, 2)->default(0);
                $table->string('payment_mode', 50)->nullable();
                $table->string('payment_status', 30)->default('unpaid');
                $table->string('status', 30)->default('tentative'); // tentative, confirmed, completed, cancelled
                $table->longText('special_notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('event_date');
                $table->index('status');
                $table->index('slot');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banquet_bookings');

        Schema::table('enquiries', function (Blueprint $table) {
            if (Schema::hasColumn('enquiries', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn([
                    'room_id', 'booking_type', 'id_proof_type', 'id_proof_number',
                    'payment_mode', 'payment_status', 'paid_amount', 'total_tariff',
                    'checked_in_at', 'checked_out_at'
                ]);
            }
        });

        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'housekeeping_status')) {
                $table->dropColumn('housekeeping_status');
            }
        });
    }
};
