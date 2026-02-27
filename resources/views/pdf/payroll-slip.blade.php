<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salary Slip - Neeliya Mendis Salon</title>
    <style>
        @page {
            margin: 15mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        .container {
            width: 100%;
        }
        /* Header */
        .header {
            border-bottom: 2px solid #002147;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .brand {
            color: #002147;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .document-type {
            color: #D4AF37;
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
            text-transform: uppercase;
        }
        /* Info Grid */
        .info-section {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 2px 0;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .value {
            color: #000;
        }
        /* Tables */
        .details-section {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th {
            background-color: #002147;
            color: #FFFFFF;
            padding: 8px 10px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
        }
        .details-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #EEEEEE;
        }
        .amount-col {
            text-align: right;
            width: 120px;
        }
        .section-header {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #002147;
            padding: 5px 10px;
            font-size: 11px;
            border-left: 3px solid #D4AF37;
            margin: 15px 0 5px 0;
        }
        /* Footer / Summary */
        .summary-section {
            width: 100%;
            margin-top: 20px;
        }
        .summary-table {
            float: right;
            width: 250px;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 6px 10px;
        }
        .net-pay-row {
            background-color: #002147;
            color: #FFFFFF;
        }
        .net-pay-row td {
            font-size: 14px;
            font-weight: bold;
            padding: 10px;
        }
        .net-pay-row .currency {
            font-size: 12px;
            color: #D4AF37;
        }
        .clear {
            clear: both;
        }
        /* Signatures */
        .signature-section {
            margin-top: 60px;
            width: 100%;
        }
        .signature-box {
            width: 200px;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .footer-note {
            margin-top: 40px;
            text-align: center;
            font-size: 9px;
            color: #777;
            border-top: 1px dashed #CCC;
            padding-top: 10px;
        }
        .deduct {
            color: #b00020;
        }
    </style>
</head>
<body>
@php
    $monthLabel = \Carbon\Carbon::parse($payroll->period_start)->format('F Y');

    $dailyRate = ((float) $payroll->basic_salary) / 30;
    $unusedLeaves = max(0, (float) $payroll->allowed_leaves - (float) $payroll->leaves_taken);

    $attendance = (float) ($payroll->adjustments?->where('type', 'allowance')->where('label', 'Attendance')->sum('amount') ?? 0);
    $attendanceAllowance = (float) ($payroll->adjustments?->where('type', 'allowance')->where('label', 'Attendance Allowance')->sum('amount') ?? 0);

    $weddingPayment = (float) ($payroll->adjustments?->where('type', 'allowance')->where('label', 'Wedding payment')->sum('amount') ?? 0);
    $extraAllowances = (float) ($payroll->adjustments?->where('type', 'allowance')->whereNotIn('label', ['Wedding payment', 'Attendance', 'Attendance Allowance'])->sum('amount') ?? 0);
    $extraDeductions = (float) ($payroll->adjustments?->where('type', 'deduction')->sum('amount') ?? 0);

    $salarySubTotal = (float) $payroll->basic_salary + $attendance + $attendanceAllowance;
    $totalSalary = $salarySubTotal + (float) $payroll->commission_amount + $weddingPayment + $extraAllowances;
    $totalDeductions = (float) $payroll->leave_deduction + $extraDeductions;

    // Prefer stored net_pay if present, but compute as fallback
    $balanceSalary = isset($payroll->net_pay) ? (float)$payroll->net_pay : ($totalSalary - $totalDeductions);
@endphp

<div class="container">
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <h1 class="brand">Neeliya Mendis Salons</h1>
                    <div class="document-type">Salary Slip - {{ $monthLabel }}</div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div style="font-size: 10px; color: #777;">Generated on: {{ date('d M Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td>
                    <div><span class="label">Employee Name:</span> <span class="value">{{ $staff->name }}</span></div>
                    <div><span class="label">Bank Name:</span> <span class="value">{{ $staff->bank_name ?? 'N/A' }}</span></div>
                    <div><span class="label">Account Number:</span> <span class="value">{{ $staff->bank_account_number ?? 'N/A' }}</span></div>
                </td>
                <td style="text-align: right;">
                    <div><span class="label">Payroll Period:</span> <span class="value">{{ Carbon\Carbon::parse($payroll->period_start)->format('d M Y') }} - {{ Carbon\Carbon::parse($payroll->period_end)->format('d M Y') }}</span></div>
                    <div><span class="label">Leaves Taken:</span> <span class="value">{{ number_format((float)$payroll->leaves_taken, 1) }} Days</span></div>
                    <div><span class="label">Unused Leaves:</span> <span class="value">{{ number_format($unusedLeaves, 1) }} Days</span></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="details-section">
        <div class="section-header">EARNINGS</div>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="amount-col">Amount (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td class="amount-col">{{ number_format((float)$payroll->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>Attendance</td>
                    <td class="amount-col">{{ number_format($attendance, 2) }}</td>
                </tr>
                <tr>
                    <td>Attendance Allowance</td>
                    <td class="amount-col">{{ number_format($attendanceAllowance, 2) }}</td>
                </tr>
                <tr>
                    <td>Commission (Extra pay & OT)</td>
                    <td class="amount-col">{{ number_format((float)$payroll->commission_amount, 2) }}</td>
                </tr>
                @if($weddingPayment > 0)
                <tr>
                    <td>Wedding Payment</td>
                    <td class="amount-col">{{ number_format($weddingPayment, 2) }}</td>
                </tr>
                @endif
                @if($payroll->adjustments && $payroll->adjustments->where('type', 'allowance')->whereNotIn('label', ['Wedding payment', 'Attendance', 'Attendance Allowance'])->count())
                    @foreach($payroll->adjustments->where('type', 'allowance')->whereNotIn('label', ['Wedding payment', 'Attendance', 'Attendance Allowance']) as $a)
                        <tr>
                            <td>{{ $a->label }}</td>
                            <td class="amount-col">{{ number_format((float)$a->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr style="font-weight: bold;">
                    <td>Total Gross Earnings</td>
                    <td class="amount-col">{{ number_format($totalSalary, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-header">DEDUCTIONS</div>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="amount-col">Amount (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Leave Deductions (No Pay)</td>
                    <td class="amount-col" class="deduct">{{ number_format((float)$payroll->leave_deduction, 2) }}</td>
                </tr>
                @if($payroll->adjustments && $payroll->adjustments->where('type', 'deduction')->count())
                    @foreach($payroll->adjustments->where('type', 'deduction') as $d)
                        <tr>
                            <td>{{ $d->label }}</td>
                            <td class="amount-col" class="deduct">{{ number_format((float)$d->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr style="font-weight: bold;">
                    <td>Total Deductions</td>
                    <td class="amount-col" class="deduct">{{ number_format($totalDeductions, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="summary-section">
        <table class="summary-table">
            <tr class="net-pay-row">
                <td>NET SALARY</td>
                <td class="amount-col"><span class="currency">LKR</span> {{ number_format($balanceSalary, 2) }}</td>
            </tr>
        </table>
        <div class="clear"></div>
        <div style="font-size: 9px; color: #888; margin-top: 10px;">
            Daily Rate: Rs. {{ number_format($dailyRate, 2) }} | 
            Invoice Total: Rs. {{ number_format((float)$payroll->invoice_total, 2) }} | 
            Commission Rate: {{ number_format((float)$payroll->commission_rate * 100, 2) }}%
        </div>
    </div>

    <div class="signature-section">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="signature-box">Employee Signature</div>
                </td>
                <td style="text-align: right;">
                    <div class="signature-box" style="margin-left: auto;">Authorized Signature</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-note">
        This is a computer generated document and does not require a physical signature for authenticity.
        <br>Neeliya Mendis Salons &copy; {{ date('Y') }}
    </div>
</div>

</body>
</html>
