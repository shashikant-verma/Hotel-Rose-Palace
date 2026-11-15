<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('otp_verifications', function (Blueprint $table) {
            $table->string('email', 255)->after('mobile_number')->nullable();
            $table->string('mobile_number', 20)->nullable()->change();

            $table->index('email');
            $table->index(['email', 'purpose']);
        });
    }

    public function down(): void
    {
        Schema::table('otp_verifications', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['email', 'purpose']);
            $table->dropColumn('email');
        });
    }
};
