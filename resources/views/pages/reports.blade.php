@extends('layout.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 p-6">

    {{-- SweetAlert Messages --}}
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

    {{-- Header --}}
    <div class="mb-8 pl-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Performance Analytics & Reports</h1>
        <p class="text-gray-600">Track your salon's growth and service trends.</p>
    </div>

    {{-- Sales Reports Section --}}
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-10 mx-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <img src="{{ asset('icons/pay.png') }}" class="w-6 h-6 object-contain" alt="Sales">
                </div>
                Sales Reports
            </h2>
            <div class="flex space-x-2">
                <span class="px-4 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold border border-blue-100 italic">Daily & Monthly Revenue</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Daily Sales Chart --}}
            <div class="bg-gradient-to-br from-blue-50/50 to-white p-6 rounded-2xl border border-blue-100">
                <h3 class="text-lg font-bold text-gray-700 mb-6 text-center">Daily Revenue (Current Month)</h3>
                <div class="h-[350px]">
                    <canvas id="dailySalesChart"></canvas>
                </div>
            </div>

            {{-- Monthly Sales Chart --}}
            <div class="bg-gradient-to-br from-blue-50/50 to-white p-6 rounded-2xl border border-blue-100">
                <h3 class="text-lg font-bold text-gray-700 mb-6 text-center">Monthly Revenue (Current Year)</h3>
                <div class="h-[350px]">
                    <canvas id="monthlySalesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Service Breakdown Section --}}
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-10 mx-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <div class="w-10 h-10 bg-customPalette-light rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <img src="{{ asset('icons/service.png') }}" class="w-6 h-6 object-contain" alt="Services">
                </div>
                Service Popularity
            </h2>
            <div class="flex space-x-2">
                <span class="px-4 py-1.5 bg-yellow-50 text-yellow-700 rounded-full text-sm font-semibold border border-yellow-100 italic">Weekly & Monthly Usage</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Weekly Service Chart --}}
            <div class="bg-gradient-to-br from-blue-50/50 to-white p-6 rounded-2xl border border-blue-100">
                <h3 class="text-lg font-bold text-gray-700 mb-6 text-center">Weekly Service Distribution</h3>
                <div class="h-[350px]">
                    <canvas id="weeklyServiceChart"></canvas>
                </div>
            </div>

            {{-- Monthly Service Chart --}}
            <div class="bg-gradient-to-br from-blue-50/50 to-white p-6 rounded-2xl border border-blue-100">
                <h3 class="text-lg font-bold text-gray-700 mb-6 text-center">Monthly Service Distribution</h3>
                <div class="h-[350px]">
                    <canvas id="monthlyServiceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="px-4 text-center mt-12 pb-8">
        <p class="text-gray-500 text-sm mb-4">Export these reports as PDF for your records</p>
        <a href="{{ route('reports.download') }}" target="_blank" 
           class="px-8 py-3 bg-gray-800 text-white rounded-xl hover:bg-black font-bold transition shadow-md inline-flex items-center mx-auto">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download Full Report (PDF)
        </a>
    </div>


</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') {
        console.error("Chart.js is not loaded.");
        return;
    }

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 20, font: { size: 12, weight: '600' } } }
        }
    };

    // 1. Daily Sales Chart
    new Chart(document.getElementById('dailySalesChart'), {
        type: 'bar',
        data: {
            labels: @json($dailyDates),
            datasets: [{
                label: 'Daily Revenue (Rs.)',
                data: @json($dailyPrices),
                backgroundColor: 'rgba(30, 58, 138, 0.8)',
                borderColor: '#1e3a8a',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            ...commonOptions,
            plugins: { ...commonOptions.plugins, legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Monthly Sales Chart
    new Chart(document.getElementById('monthlySalesChart'), {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Monthly Revenue (Rs.)',
                data: @json($monthlyPrices),
                borderColor: '#1e3a8a',
                backgroundColor: 'rgba(30, 58, 138, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#1e3a8a'
            }]
        },
        options: {
            ...commonOptions,
            plugins: { ...commonOptions.plugins, legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 3. Weekly Service Chart
    new Chart(document.getElementById('weeklyServiceChart'), {
        type: 'doughnut',
        data: {
            labels: @json($weeklyServiceNames),
            datasets: [{
                data: @json($weeklyServiceCounts),
                backgroundColor: [
                    '#1e3a8a', '#3b82f6', '#60a5fa', '#93c5fd', '#bfdbfe', '#dbeafe'
                ],
                borderWidth: 2
            }]
        },
        options: {
            ...commonOptions,
            cutout: '65%'
        }
    });

    // 4. Monthly Service Chart
    new Chart(document.getElementById('monthlyServiceChart'), {
        type: 'pie',
        data: {
            labels: @json($monthlyServiceNames),
            datasets: [{
                data: @json($monthlyServiceCounts),
                backgroundColor: [
                    '#d4af37', '#fcd34d', '#fbbf24', '#f59e0b', '#d97706', '#b45309'
                ],
                borderWidth: 2
            }]
        },
        options: commonOptions
    });
});
</script>
@endpush
@endsection
