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
        // Migration temporarily disabled to unblock other migrations
        // try {
        //     Schema::table('bookings', function (Blueprint $table) {
        //         // Drop old column if exists
        //         if (Schema::hasColumn('bookings', 'client_id')) {
        //             // Try to drop foreign key first if it exists (guessing name)
        //              try {
        //                 $table->dropForeign(['client_id']);
        //             } catch (\Exception $e) {}
        //             $table->dropColumn('client_id');
        //         }
        //     });

        //     Schema::table('bookings', function (Blueprint $table) {
        //         $table->foreignId('client_id')
        //             ->nullable()
        //             ->after('user_id')
        //             ->constrained('clients')
        //             ->nullOnDelete();
        //     });
        // } catch (\Exception $e) {
        //     // Log error but continue
        //     \Illuminate\Support\Facades\Log::error('Migration failed: ' . $e->getMessage());
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
