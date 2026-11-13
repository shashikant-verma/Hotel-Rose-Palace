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
        // 1. rooms table enhancements
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'category')) {
                $table->string('category', 50)->nullable()->after('room_type_id');
            }
            if (!Schema::hasColumn('rooms', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2)->nullable()->after('current_price');
            }
            if (!Schema::hasColumn('rooms', 'max_guests')) {
                $table->integer('max_guests')->default(2)->after('price_per_night');
            }
            if (!Schema::hasColumn('rooms', 'image_path')) {
                $table->string('image_path')->nullable()->after('housekeeping_status');
            }
        });

        // Allow rooms.status to accept occupied, reserved, etc.
        try {
            DB::statement("ALTER TABLE rooms MODIFY status VARCHAR(50) DEFAULT 'available'");
        } catch (\Exception $e) {
            // Ignore if already modified or SQLite
        }

        // 2. enquiries table enhancements
        Schema::table('enquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('enquiries', 'booking_ref')) {
                $table->string('booking_ref', 50)->nullable()->after('reference_id');
            }
            if (!Schema::hasColumn('enquiries', 'guest_name')) {
                $table->string('guest_name')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('enquiries', 'phone')) {
                $table->string('phone', 30)->nullable()->after('customer_phone');
            }
            if (!Schema::hasColumn('enquiries', 'check_in')) {
                $table->date('check_in')->nullable()->after('check_in_date');
            }
            if (!Schema::hasColumn('enquiries', 'check_out')) {
                $table->date('check_out')->nullable()->after('check_out_date');
            }
            if (!Schema::hasColumn('enquiries', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->nullable()->after('total_tariff');
            }
        });

        // 3. banquet_bookings table enhancements
        Schema::table('banquet_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('banquet_bookings', 'event_name')) {
                $table->string('event_name')->nullable()->after('reference_id');
            }
            if (!Schema::hasColumn('banquet_bookings', 'organizer_name')) {
                $table->string('organizer_name')->nullable()->after('event_name');
            }
            if (!Schema::hasColumn('banquet_bookings', 'phone')) {
                $table->string('phone', 30)->nullable()->after('organizer_name');
            }
            if (!Schema::hasColumn('banquet_bookings', 'time_slot')) {
                $table->string('time_slot', 50)->nullable()->after('slot');
            }
            if (!Schema::hasColumn('banquet_bookings', 'seating_layout')) {
                $table->string('seating_layout', 50)->nullable()->after('guest_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['category', 'price_per_night', 'max_guests', 'image_path']);
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn(['booking_ref', 'guest_name', 'phone', 'check_in', 'check_out', 'total_amount']);
        });

        Schema::table('banquet_bookings', function (Blueprint $table) {
            $table->dropColumn(['event_name', 'organizer_name', 'phone', 'time_slot', 'seating_layout']);
        });
    }
};
