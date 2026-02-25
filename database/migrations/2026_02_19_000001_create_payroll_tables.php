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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->restrictOnDelete();

            $table->date('period_start');
            $table->date('period_end');

            $table->decimal('basic_salary', 10, 2)->default(0);

            // Leave policy (supports half-day leaves via decimal)
            $table->decimal('allowed_leaves', 5, 2)->default(4);
            $table->decimal('leaves_taken', 5, 2)->default(0);
            $table->decimal('excess_leaves', 5, 2)->default(0);
            $table->decimal('leave_deduction', 10, 2)->default(0);

            // Commission policy
            $table->decimal('invoice_total', 12, 2)->default(0);
            $table->decimal('commission_rate', 5, 4)->default(0.10);
            $table->decimal('commission_amount', 12, 2)->default(0);

            // Manual adjustments (optional)
            $table->decimal('allowances_total', 10, 2)->default(0);
            $table->decimal('deductions_total', 10, 2)->default(0);

            $table->decimal('gross_pay', 12, 2)->default(0);
            $table->decimal('net_pay', 12, 2)->default(0);

            $table->string('status', 20)->default('pending');
            $table->dateTime('paid_at')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('reference_no', 100)->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['staff_id', 'period_start', 'period_end']);
            $table->index(['status', 'paid_at']);
        });

        Schema::create('payroll_adjustments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payroll_id')
                ->constrained('payrolls')
                ->cascadeOnDelete();

            $table->string('type', 20);
            $table->string('label');
            $table->decimal('amount', 10, 2);

            $table->timestamps();

            $table->index(['payroll_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_adjustments');
        Schema::dropIfExists('payrolls');
    }
};
