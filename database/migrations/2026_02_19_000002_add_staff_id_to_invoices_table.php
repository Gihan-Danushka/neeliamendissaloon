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
        if (!Schema::hasTable('invoices')) {
            return;
        }

        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'staff_id')) {
                $table->foreignId('staff_id')
                    ->nullable()
                    ->after('client_id')
                    ->constrained('staff')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('invoices', 'date')) {
                // Safety: legacy installs should already have a date column.
                $table->date('date')->nullable();
            }

            if (!Schema::hasColumn('invoices', 'total_price')) {
                // Safety: legacy installs should already have total_price.
                $table->decimal('total_price', 10, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('invoices')) {
            return;
        }

        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'staff_id')) {
                try {
                    $table->dropForeign(['staff_id']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('staff_id');
            }
        });
    }
};
