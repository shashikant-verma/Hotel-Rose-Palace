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
        Schema::table('contact_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_messages', 'subject')) {
                $table->string('subject', 255)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('contact_messages', 'status')) {
                $table->string('status', 20)->default('new')->after('message')->index();
            }
        });

        // Backfill status for any existing records based on is_replied / is_read flags
        try {
            DB::table('contact_messages')
                ->where('is_replied', true)
                ->update(['status' => 'replied']);

            DB::table('contact_messages')
                ->where('is_read', true)
                ->where('is_replied', false)
                ->update(['status' => 'read']);
        } catch (\Throwable $e) {
            // Safe fallback if table is empty or error occurs
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (Schema::hasColumn('contact_messages', 'subject')) {
                $table->dropColumn('subject');
            }
            if (Schema::hasColumn('contact_messages', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
