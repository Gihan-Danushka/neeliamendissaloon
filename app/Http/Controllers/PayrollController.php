<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Payroll;
use App\Models\PayrollAdjustment;
use App\Models\Staff;
use App\Services\PayrollCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PayrollController extends Controller
{
    /**
     * Display the payroll management page.
     */
    public function index(Request $request)
    {
        try {
            // Retrieve all staff members for payroll management
            $staffMembers = Staff::with('categories')->get();

            $month = $request->input('month'); // optional: YYYY-MM
            $periodStart = $month
                ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
                : now()->startOfMonth();
            $periodEnd = $periodStart->copy()->endOfMonth();

            /**
             * Optional input to support half-days:
             * - Query/body: leaves_taken[staff_id]=4.5
             */
            $leavesTakenByStaff = (array) $request->input('leaves_taken', []);

            $payrollPreview = [];
            foreach ($staffMembers as $staff) {
                $leavesTaken = (float) ($leavesTakenByStaff[$staff->id] ?? 0);
                $payrollPreview[$staff->id] = PayrollCalculator::calculateForPeriod(
                    $staff,
                    $periodStart,
                    $periodEnd,
                    $leavesTaken,
                );
            }

            $historyStaff = null;
            $historyPayrolls = collect();
            $historyStaffId = $request->query('history_staff_id');
            if ($historyStaffId) {
                $historyStaff = Staff::find($historyStaffId);
                if ($historyStaff) {
                    $historyPayrolls = Payroll::query()
                        ->where('staff_id', $historyStaff->id)
                        ->with('adjustments')
                        ->orderByDesc('paid_at')
                        ->orderByDesc('created_at')
                        ->limit(50)
                        ->get();
                }
            }

            // Check if the request expects a JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'period' => [
                        'start' => $periodStart->toDateString(),
                        'end' => $periodEnd->toDateString(),
                    ],
                    'data' => $staffMembers,
                    'payroll' => $payrollPreview,
                ]);
            }

            // Return the payroll view with staff data
            return view('pages.payroll', compact(
                'staffMembers',
                'payrollPreview',
                'periodStart',
                'periodEnd',
                'historyStaff',
                'historyPayrolls'
            ));
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving payroll data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function processPayment(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
            'leaves_taken' => ['required', 'numeric', 'min:0', 'max:31'],
            'wedding_payment' => ['nullable', 'numeric', 'min:0'],
        ]);

        $month = $validated['month'] ?? null;
        $periodStart = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();
        $periodEnd = $periodStart->copy()->endOfMonth();

        $calc = PayrollCalculator::calculateForPeriod(
            $staff,
            $periodStart,
            $periodEnd,
            (float) $validated['leaves_taken'],
        );

        $weddingPayment = (float) ($validated['wedding_payment'] ?? 0);

        $payroll = Payroll::updateOrCreate(
            [
                'staff_id' => $staff->id,
                'period_start' => $calc['period_start'],
                'period_end' => $calc['period_end'],
            ],
            [
                'basic_salary' => $calc['basic_salary'],

                'allowed_leaves' => $calc['allowed_leaves'],
                'leaves_taken' => $calc['leaves_taken'],
                'excess_leaves' => $calc['excess_leaves'],
                'leave_deduction' => $calc['leave_deduction'],

                'invoice_total' => $calc['invoice_total'],
                'commission_rate' => $calc['commission_rate'],
                'commission_amount' => $calc['commission_amount'],

                'allowances_total' => $calc['leave_bonus'] ?? 0,
                'deductions_total' => $calc['leave_deduction'],
                'gross_pay' => $calc['gross_pay'] + $weddingPayment,
                'net_pay' => $calc['net_pay'] + $weddingPayment,

                'status' => 'paid',
                'paid_at' => now(),
                'payment_method' => 'cash',
                'created_by' => Auth::id(),
            ]
        );

        // Upsert Wedding payment as an allowance line item
        PayrollAdjustment::query()
            ->where('payroll_id', $payroll->id)
            ->where('type', 'allowance')
            ->where('label', 'Wedding payment')
            ->delete();

        if ($weddingPayment > 0) {
            PayrollAdjustment::create([
                'payroll_id' => $payroll->id,
                'type' => 'allowance',
                'label' => 'Wedding payment',
                'amount' => $weddingPayment,
            ]);
        }

        return redirect()
            ->route('payroll.index', ['history_staff_id' => $staff->id, 'month' => $periodStart->format('Y-m')])
            ->with('success', 'Payment processed successfully.');
    }

    public function processAll(Request $request)
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
            'leaves_taken' => ['nullable', 'array'],
            'leaves_taken.*' => ['nullable', 'numeric', 'min:0', 'max:31'],
            'wedding_payment' => ['nullable', 'array'],
            'wedding_payment.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $month = $validated['month'] ?? null;
        $periodStart = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();
        $periodEnd = $periodStart->copy()->endOfMonth();

        $staffMembers = Staff::query()->get();

        $leavesTakenByStaff = (array) ($validated['leaves_taken'] ?? []);
        $weddingPaymentByStaff = (array) ($validated['wedding_payment'] ?? []);

        $processed = 0;
        $skipped = 0;

        DB::transaction(function () use ($staffMembers, $periodStart, $periodEnd, $leavesTakenByStaff, $weddingPaymentByStaff, &$processed, &$skipped) {
            foreach ($staffMembers as $staff) {
                $leavesTaken = (float) ($leavesTakenByStaff[$staff->id] ?? 0);
                $weddingPayment = (float) ($weddingPaymentByStaff[$staff->id] ?? 0);

                $calc = PayrollCalculator::calculateForPeriod(
                    $staff,
                    $periodStart,
                    $periodEnd,
                    $leavesTaken,
                );

                $alreadyExists = Payroll::query()
                    ->where('staff_id', $staff->id)
                    ->whereDate('period_start', $calc['period_start'])
                    ->whereDate('period_end', $calc['period_end'])
                    ->exists();

                if ($alreadyExists) {
                    $skipped++;
                    continue;
                }

                $payroll = Payroll::create([
                    'staff_id' => $staff->id,
                    'period_start' => $calc['period_start'],
                    'period_end' => $calc['period_end'],

                    'basic_salary' => $calc['basic_salary'],

                    'allowed_leaves' => $calc['allowed_leaves'],
                    'leaves_taken' => $calc['leaves_taken'],
                    'excess_leaves' => $calc['excess_leaves'],
                    'leave_deduction' => $calc['leave_deduction'],

                    'invoice_total' => $calc['invoice_total'],
                    'commission_rate' => $calc['commission_rate'],
                    'commission_amount' => $calc['commission_amount'],

                    'allowances_total' => $calc['leave_bonus'] ?? 0,
                    'deductions_total' => $calc['leave_deduction'],
                    'gross_pay' => $calc['gross_pay'] + $weddingPayment,
                    'net_pay' => $calc['net_pay'] + $weddingPayment,

                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => 'cash',
                    'created_by' => Auth::id(),
                ]);

                if ($weddingPayment > 0) {
                    PayrollAdjustment::create([
                        'payroll_id' => $payroll->id,
                        'type' => 'allowance',
                        'label' => 'Wedding payment',
                        'amount' => $weddingPayment,
                    ]);
                }

                $processed++;
            }
        });

        return redirect()
            ->route('payroll.index', ['month' => $periodStart->format('Y-m')])
            ->with('success', "Processed {$processed} staff payroll(s). Skipped {$skipped} already processed.");
    }

    public function downloadSlip(Payroll $payroll)
    {
        $payroll->load(['staff', 'adjustments']);

        $staff = $payroll->staff;
        if (!$staff) {
            return redirect()->route('payroll.index')->with('error', 'Staff not found for this payroll record.');
        }

        $monthLabel = Carbon::parse($payroll->period_start)->format('F_Y');
        $safeName = Str::slug($staff->name ?: 'staff');
        $filename = "salary_slip_{$safeName}_{$monthLabel}.pdf";

        $pdf = Pdf::loadView('pdf.payroll-slip', [
            'payroll' => $payroll,
            'staff' => $staff,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }
}
