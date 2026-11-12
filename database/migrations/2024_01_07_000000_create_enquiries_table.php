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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('restrict');
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('num_adults')->default(2);
            $table->integer('num_children')->default(0);
            $table->longText('special_requests')->nullable();
            $table->enum('status', ['new', 'contacted', 'availability_confirmed', 'booking_confirmed', 'cancelled', 'closed'])
                  ->default('new');
            $table->longText('internal_notes')->nullable();
            $table->timestamp('whatsapp_message_sent_at')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('reference_id');
            $table->index('customer_phone');
            $table->index('status');
            $table->index('check_in_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
