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
    if (!Schema::hasTable('notifications')) {
        return;
    }

    Schema::table('notifications', function (Blueprint $table) {
        if (Schema::hasColumn('notifications', 'booking_id')) {
            return;
        }

        $table->unsignedBigInteger('booking_id')->nullable()->after('user_id');
        $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
    });
}

public function down(): void
{
    if (!Schema::hasTable('notifications')) {
        return;
    }

    Schema::table('notifications', function (Blueprint $table) {
        if (!Schema::hasColumn('notifications', 'booking_id')) {
            return;
        }

        try {
            $table->dropForeign(['booking_id']);
        } catch (\Throwable $e) {
        }
        $table->dropColumn('booking_id');
    });
}

};
