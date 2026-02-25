<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class PayrollCalculator
{
    /**
     * Payroll rules:
     * - Basic salary defaults to 85000 if staff.basic_salary is null
     * - 4 paid leave days per month; only leave beyond 4 is deducted
     * - Half-day leave supported via decimals (e.g. 0.5)
     * - Commission = 10% of invoice total for that staff within the period
     */
    public static function calculateForPeriod(
        Staff $staff,
        Carbon $periodStart,
        Carbon $periodEnd,
        float $leavesTaken,
        float $allowedLeaves = 4.0,
        float $commissionRate = 0.10,
        float $defaultBaseSalary = 85000.0,
    ): array {
        $baseSalary = (float) ($staff->basic_salary ?? $defaultBaseSalary);
        $dailyRate = $baseSalary / 30.0;

        $leavesTaken = max(0.0, $leavesTaken);
        $unusedLeaves = max(0.0, $allowedLeaves - $leavesTaken);
        $excessLeaves = max(0.0, $leavesTaken - $allowedLeaves);
        $leaveDeduction = $dailyRate * $excessLeaves;
        $leaveBonus = $dailyRate * $unusedLeaves;

        $invoiceTotal = 0.0;
        if (Schema::hasTable('invoices') && Schema::hasColumn('invoices', 'staff_id')) {
            $invoiceTotal = (float) Invoice::query()
                ->where('staff_id', $staff->id)
                ->whereBetween('date', [$periodStart->toDateString(), $periodEnd->toDateString()])
                ->sum('total_price');
        }

        $commissionAmount = $invoiceTotal * $commissionRate;

        $grossPay = $baseSalary + $commissionAmount + $leaveBonus;
        $netPay = $grossPay - $leaveDeduction;

        return [
            'staff_id' => $staff->id,
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),

            'basic_salary' => round($baseSalary, 2),
            'daily_rate' => round($dailyRate, 4),

            'allowed_leaves' => round($allowedLeaves, 2),
            'leaves_taken' => round($leavesTaken, 2),
            'unused_leaves' => round($unusedLeaves, 2),
            'excess_leaves' => round($excessLeaves, 2),
            'leave_deduction' => round($leaveDeduction, 2),
            'leave_bonus' => round($leaveBonus, 2),

            'invoice_total' => round($invoiceTotal, 2),
            'commission_rate' => round($commissionRate, 4),
            'commission_amount' => round($commissionAmount, 2),

            'gross_pay' => round($grossPay, 2),
            'net_pay' => round($netPay, 2),
        ];
    }
}
