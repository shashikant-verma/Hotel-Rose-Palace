<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add hospitality specifications to room_types table safely and additively.
     */
    public function up(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->string('bed_type')->nullable()->after('size_sqft');
            $table->string('view_type')->nullable()->after('bed_type');
            $table->integer('bedroom_count')->default(1)->after('view_type');
            $table->integer('living_room_count')->default(0)->after('bedroom_count');
            $table->integer('bathroom_count')->default(1)->after('living_room_count');
            $table->decimal('original_price', 10, 2)->nullable()->after('base_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn([
                'bed_type',
                'view_type',
                'bedroom_count',
                'living_room_count',
                'bathroom_count',
                'original_price',
            ]);
        });
    }
};
