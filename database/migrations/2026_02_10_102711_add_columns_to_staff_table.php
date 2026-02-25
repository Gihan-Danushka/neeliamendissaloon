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
        Schema::table('staff', function (Blueprint $table) {
            if (!Schema::hasColumn('staff', 'experience')) {
                $table->string('experience')->nullable();
            }
            if (!Schema::hasColumn('staff', 'join_date')) {
                $table->date('join_date')->nullable();
            }
            if (!Schema::hasColumn('staff', 'bank_account_number')) {
                $table->string('bank_account_number')->nullable();
            }
            if (!Schema::hasColumn('staff', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }
            if (!Schema::hasColumn('staff', 'basic_salary')) {
                $table->decimal('basic_salary', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('staff', 'etf_number')) {
                $table->string('etf_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('staff', 'experience')) $columnsToDrop[] = 'experience';
            if (Schema::hasColumn('staff', 'join_date')) $columnsToDrop[] = 'join_date';
            if (Schema::hasColumn('staff', 'bank_account_number')) $columnsToDrop[] = 'bank_account_number';
            if (Schema::hasColumn('staff', 'bank_name')) $columnsToDrop[] = 'bank_name';
            if (Schema::hasColumn('staff', 'basic_salary')) $columnsToDrop[] = 'basic_salary';
            if (Schema::hasColumn('staff', 'etf_number')) $columnsToDrop[] = 'etf_number';

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
