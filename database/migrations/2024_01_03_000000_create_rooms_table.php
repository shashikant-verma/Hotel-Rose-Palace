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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('restrict');
            $table->string('room_number')->unique();
            $table->integer('floor')->nullable();
            $table->decimal('current_price', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('room_type_id');
            $table->index('room_number');
            $table->index('status');
            $table->index('is_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
