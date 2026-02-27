@extends('layout.layout')

@section('content')
<style>
    html { scroll-behavior: smooth; }
</style>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6">
    {{-- SweetAlert Messages --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1e3a8a'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            });
        </script>
    @endif

    <form method="POST" action="{{ route('payroll.processAll') }}">
        @csrf
        <input type="hidden" name="month" value="{{ isset($periodStart) ? $periodStart->format('Y-m') : now()->format('Y-m') }}">

        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Payroll Management</h1>
                <p class="text-gray-600">Manage employee salaries and payments</p>
                @isset($periodStart)
                    <p class="text-gray-500 text-sm mt-1">
                        Period: {{ $periodStart->toDateString() }} to {{ $periodEnd->toDateString() }}
                    </p>
                @endisset
            </div>

            <button type="submit"
                    class="px-5 h-10 inline-flex items-center justify-center bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm transition-colors duration-200 shrink-0"
                    title="Processes payroll for all staff (skips already processed for this month)">
                Process All Payments
            </button>
        </div>

    {{-- Staff Payroll Table --}}
    @if($staffMembers->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg p-12 border border-gray-100 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="text-gray-500 font-medium text-lg">No staff members available</p>
            <p class="text-gray-400 text-sm mt-2">Add staff members to manage their payroll</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                            <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase">Name</th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase">Contact</th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase">Join Date</th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase">Basic Salary</th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase">Bank Details</th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700 text-sm uppercase">ETF Number</th>
                            <th class="text-center py-4 px-6 font-semibold text-gray-700 text-sm uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($staffMembers as $staff)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-gray-800">{{ $staff->name }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-gray-700">{{ $staff->contact_number }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-gray-700">{{ $staff->join_date }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-lg font-bold text-gray-800">Rs. {{ number_format($staff->basic_salary, 2) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-medium text-gray-800">{{ $staff->bank_name }}</p>
                                    <span class="text-xs text-gray-500">{{ $staff->bank_account_number }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-gray-700">{{ $staff->etf_number ?? 'N/A' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-full max-w-xs grid grid-cols-2 gap-3">
                                            <div class="flex flex-col">
                                                <label class="text-xs font-medium text-gray-700 mb-1">Leaves</label>
                                                <input
                                                    type="number"
                                                    step="0.5"
                                                    min="0"
                                                    max="31"
                                                    name="leaves_taken[{{ $staff->id }}]"
                                                    value="{{ old('leaves_taken.' . $staff->id, 0) }}"
                                                    class="w-full h-10 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                    placeholder="0"
                                                    title="Leaves taken this month (supports half-days)"
                                                />
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="text-xs font-medium text-gray-700 mb-1">Wedding payment</label>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    name="wedding_payment[{{ $staff->id }}]"
                                                    value="{{ old('wedding_payment.' . $staff->id, 0) }}"
                                                    class="w-full h-10 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                                    placeholder="0"
                                                    title="Wedding payment"
                                                />
                                            </div>
                                        </div>

                                        <a href="{{ route('payroll.index', ['history_staff_id' => $staff->id, 'month' => isset($periodStart) ? $periodStart->format('Y-m') : now()->format('Y-m')]) }}#history"
                                           class="px-5 h-10 inline-flex items-center justify-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm transition-colors duration-200">
                                            View History
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset($historyStaff) && $historyStaff)
            <div id="history" class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
                    <h2 class="text-lg font-semibold text-gray-800">Payment History: {{ $historyStaff->name }}</h2>
                    <p class="text-sm text-gray-600">Last 50 payments</p>
                </div>

                @if($historyPayrolls->isEmpty())
                    <div class="p-6 text-gray-600">No payroll history yet.</div>
                @else
                    <div class="p-6 grid grid-cols-1 gap-6 place-items-center">
                        @foreach($historyPayrolls as $p)
                            @php
                                $monthLabel = \Carbon\Carbon::parse($p->period_start)->format('F Y');

                                $dailyRate = ((float) $p->basic_salary) / 30;
                                $unusedLeaves = max(0, (float) $p->allowed_leaves - (float) $p->leaves_taken);
                                $attendance = (float) ($p->adjustments?->where('type', 'allowance')->where('label', 'Attendance')->sum('amount') ?? 0);
                                $attendanceAllowance = (float) ($p->adjustments?->where('type', 'allowance')->where('label', 'Attendance Allowance')->sum('amount') ?? 0);

                                $weddingPayment = (float) ($p->adjustments?->where('type', 'allowance')->where('label', 'Wedding payment')->sum('amount') ?? 0);
                                $extraAllowances = (float) ($p->adjustments?->where('type', 'allowance')->whereNotIn('label', ['Wedding payment', 'Attendance', 'Attendance Allowance'])->sum('amount') ?? 0);
                                $extraDeductions = (float) ($p->adjustments?->where('type', 'deduction')->sum('amount') ?? 0);

                                $salarySubTotal = (float) $p->basic_salary + $attendance + $attendanceAllowance;
                                $totalSalary = $salarySubTotal + (float) $p->commission_amount + $weddingPayment + $extraAllowances;
                                $totalDeductions = (float) $p->leave_deduction + $extraDeductions;
                                $balanceSalary = $totalSalary - $totalDeductions;
                            @endphp

                            <div class="w-full max-w-3xl border border-gray-100 rounded-2xl shadow-sm overflow-hidden bg-white">
                                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-100">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="text-center flex-1">
                                            <div class="text-lg font-semibold text-gray-800">Neeliya Mendis Salons</div>
                                            <div class="text-sm text-gray-600 mt-1">Salary Slip &nbsp;&nbsp; {{ $monthLabel }}</div>
                                        </div>
                                        <a href="{{ route('payroll.slip', $p->id) }}"
                                           class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm transition-colors duration-200 whitespace-nowrap">
                                            Download PDF
                                        </a>
                                    </div>
                                </div>

                                <div class="px-6 py-4 text-sm text-gray-800">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <div><span class="font-semibold">Name:</span> {{ $historyStaff->name }}</div>
                                            <div><span class="font-semibold">Bank:</span> {{ $historyStaff->bank_name ?? '-' }}</div>
                                            <div><span class="font-semibold">Account No:</span> {{ $historyStaff->bank_account_number ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div><span class="font-semibold">Period:</span> {{ $p->period_start }} to {{ $p->period_end }}</div>
                                            <div><span class="font-semibold">Leaves Taken:</span> {{ number_format((float)$p->leaves_taken, 2) }}</div>
                                            <div><span class="font-semibold">Unused Leaves:</span> {{ number_format($unusedLeaves, 2) }}</div>
                                        </div>
                                    </div>

                                    <div class="mt-5 border-t border-gray-100 pt-4">
                                        <div class="flex items-center justify-between">
                                            <div class="font-semibold">Salary Basic</div>
                                            <div>Rs. {{ number_format((float)$p->basic_salary, 2) }}</div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="font-semibold">Attendance allowance</div>
                                            <div>Rs. {{ number_format($attendanceAllowance, 2) }}</div>
                                        </div>
                                       
                                    </div>

                                    <div class="mt-5">
                                        <div class="font-semibold underline underline-offset-2">Add:</div>
                                        <div class="flex items-center justify-between mt-2">
                                            <div>Attendance</div>
                                            <div>Rs. {{ number_format($attendance, 2) }}</div>
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <div>Extra pay &amp; O T (Commission)</div>
                                            <div>Rs. {{ number_format((float)$p->commission_amount, 2) }}</div>
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <div>Wedding payment</div>
                                            <div>Rs. {{ number_format($weddingPayment, 2) }}</div>
                                        </div>
                                        @if($p->adjustments && $p->adjustments->where('type', 'allowance')->whereNotIn('label', ['Wedding payment','Attendance','Attendance Allowance'])->count())
                                            @foreach($p->adjustments->where('type', 'allowance')->whereNotIn('label', ['Wedding payment','Attendance','Attendance Allowance']) as $a)
                                                <div class="flex items-center justify-between mt-2">
                                                    <div>{{ $a->label }}</div>
                                                    <div>Rs. {{ number_format((float)$a->amount, 2) }}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 font-semibold">
                                            <div>Total Salary</div>
                                            <div>Rs. {{ number_format($totalSalary, 2) }}</div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2">
                                            Daily rate: Rs. {{ number_format($dailyRate, 2) }} &nbsp; | &nbsp; Unused leaves bonus calculated from unused leaves
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="font-semibold underline underline-offset-2">Deductions</div>
                                        <div class="flex items-center justify-between mt-2 text-red-600">
                                            <div>No pay</div>
                                            <div>(Rs. {{ number_format((float)$p->leave_deduction, 2) }})</div>
                                        </div>
                                        @if($p->adjustments && $p->adjustments->where('type', 'deduction')->count())
                                            @foreach($p->adjustments->where('type', 'deduction') as $d)
                                                <div class="flex items-center justify-between mt-2 text-red-600">
                                                    <div>{{ $d->label }}</div>
                                                    <div>(Rs. {{ number_format((float)$d->amount, 2) }})</div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 font-semibold">
                                            <div>Balance Salary</div>
                                            <div>Rs. {{ number_format($balanceSalary, 2) }}</div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2">Paid at: {{ $p->paid_at ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @endif

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        try {
            const params = new URLSearchParams(window.location.search);
            if (params.has('history_staff_id')) {
                const el = document.getElementById('history');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        } catch (e) {
            // no-op
        }
    });
</script>
@endsection
