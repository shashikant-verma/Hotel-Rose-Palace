<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Keep only "Deluxe Family Room" and "Executive Room"
        // Soft delete all other room types
        DB::table('room_types')
            ->whereNotIn('name', ['Deluxe Family Room', 'Executive Room'])
            ->whereNull('deleted_at')
            ->update(['deleted_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore soft-deleted room types
        DB::table('room_types')
            ->whereNotIn('name', ['Deluxe Family Room', 'Executive Room'])
            ->whereNotNull('deleted_at')
            ->update(['deleted_at' => null]);
    }
};
