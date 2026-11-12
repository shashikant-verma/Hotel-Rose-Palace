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
        Schema::create('hotel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key')->unique();
            $table->longText('setting_value')->nullable();
            $table->text('description')->nullable();
            $table->enum('setting_type', ['text', 'textarea', 'number', 'boolean', 'url'])
                  ->default('text');
            $table->timestamps();
            
            $table->index('setting_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_settings');
    }
};
