@extends('layout.layout')

@section('content')
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

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Dashboard</h1>
        <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/icons/users.png') }}" class="w-10 h-10 object-contain" alt="Clients">
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900">{{ $userCount }}</p>
                    <p class="text-sm text-gray-500 mt-1">Total</p>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-800 mb-2">All Clients</h3>
            <div class="text-sm text-blue-600">Active users</div>
        </div>

        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-16 h-16 bg-blue-400 rounded-2xl flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/icons/hairdresser.png') }}" class="w-11 h-11 object-contain" alt="Services">
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900">{{ $ServiceCount }}</p>
                    <p class="text-sm text-gray-500 mt-1">Available</p>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-800 mb-2">All Services</h3>
            <div class="text-sm text-blue-600">Service catalog</div>
        </div>

        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-16 h-16 bg-customPalette-light rounded-2xl flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/icons/memories.png') }}" class="w-10 h-10 object-contain" alt="Reminders">
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900">{{ $remindingCount }}</p>
                    <p class="text-sm text-gray-500 mt-1">Pending</p>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-800 mb-2">Today's Reminders</h3>
            <div class="text-sm text-customPalette-light">Follow-ups needed</div>
        </div>

        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/icons/yesterday.png') }}" class="w-10 h-10 object-contain" alt="Sales">
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-gray-900">{{ number_format($yesterdayTotal, 2) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Rs.</p>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-800 mb-2">Yesterday Sales</h3>
            <div class="text-sm text-green-600">Revenue</div>
        </div>

    </div>

    {{-- Charts + Today Schedule --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Charts --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mt-5">
            <h2 class="text-3xl font-bold text-gray-800 mb-10">Performance Analytics</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100 mt-20">
                    <div class="h-[320px]">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100 mt-20">
                    <div class="h-[320px]">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today Schedule - Only Approved Appointments --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Today's Schedule</h2>
                @php
                    $approvedCount = $todaysAppointments->where('status', 'approved')->count();
                @endphp
                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">
                    {{ $approvedCount }} Bookings
                </span>
            </div>

            <div class="space-y-4 overflow-auto max-h-[65vh] pr-2 custom-scrollbar">
                @php
                    $approvedAppointments = $todaysAppointments->where('status', 'approved');
                @endphp
                
                @forelse($approvedAppointments as $app)
                    @php
                        $serviceNames = $app->services?->pluck('name')->toArray() ?? [];
                        $startHHMM = \Carbon\Carbon::parse($app->start_time)->format('H:i');
                    @endphp

                    <div
                        class="appointment-card bg-blue-50 rounded-xl p-4 border-2 border-blue-200 hover:shadow-md transition-all duration-200 relative"
                        data-start="{{ $startHHMM }}"
                    >
                        {{-- Status badge --}}
                        <span class="status-badge absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold border">
                            Upcoming
                        </span>

                        <div class="flex items-start space-x-3 mb-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                {{ $app->display_initial }}
                            </div>

                            <div class="flex-1 min-w-0 pr-16 ">
                                <h4 class="font-bold text-gray-900 text-base">
                                    {{ $app->display_name }}
                                </h4>

                                <p class="text-sm text-gray-600 flex items-center mt-1">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $app->start_time }} - {{ $app->end_time }}
                                </p>
                            </div>
                        </div>

                        {{--  Services + Reminder Icon Inline --}}
                        <div class="ml-12 flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                @if(count($serviceNames))
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($serviceNames as $service)
                                            <span class="text-s text-gray-700 bg-white px-3 py-1 rounded-full border border-gray-200">
                                                {{ $service }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">No services listed</span>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('notifications.booking.remind', $app->id) }}" class="shrink-0">
                                @csrf
                                <button type="submit"
                                    title="Send Reminder"
                                    class="p-2 rounded-full border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 hover:border-blue-300 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">No approved appointments scheduled</p>
                        <p class="text-gray-400 text-sm mt-1">Pending appointments need approval first</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Pending Appointments --}}
    @if($pendingAppointments->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pending Appointments</h2>
                    <p class="text-gray-500 text-sm mt-1">Review and approve today's pending bookings</p>
                </div>
                <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                    {{ $pendingAppointments->count() }} Pending
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase">ID</th>
                            <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase">Client</th>
                            <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase">Date</th>
                            <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase">Time Slot</th>
                            <th class="text-left py-4 px-4 font-semibold text-gray-700 text-sm uppercase">Amount</th>
                            <th class="text-center py-4 px-4 font-semibold text-gray-700 text-sm uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pendingAppointments as $app)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <span class="font-mono text-sm font-semibold text-gray-600">#{{ $loop->iteration }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-gray-800">{{ $app->display_name }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($app->date)->format('M d, Y') }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-medium text-gray-700">{{ $app->start_time }} - {{ $app->end_time }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-lg font-bold text-gray-800">Rs. {{ number_format($app->total_price, 2) }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex justify-center space-x-2">
                                        <form method="POST" action="{{ route('appointments.approve', $app->id) }}">
                                            @csrf
                                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('appointments.cancel', $app->id) }}">
                                            @csrf
                                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium text-sm">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e3a8a; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #172554; }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // -------------------------
    // Charts
    // -------------------------
    if (typeof Chart === 'undefined') {
        console.error("Chart.js is not loaded. Add Chart.js in layout.blade.php before @stack('scripts')");
        return;
    }

    const dates  = @json($dates);
    const prices = @json($prices);

    new Chart(document.getElementById('myChart1'), {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Daily Revenue',
                data: prices,
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Last Week Revenue' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    const names  = @json($names);
    const counts = @json($counts);

    new Chart(document.getElementById('myChart2'), {
        type: 'doughnut',
        data: {
            labels: names,
            datasets: [{
                label: 'Services',
                data: counts,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // -------------------------
    // Today Schedule Badge Logic - Only for Approved Appointments
    // -------------------------
    function toMinutes(hhmm) {
        const [h, m] = hhmm.split(':').map(Number);
        return (h * 60) + m;
    }

    function updateAppointmentStatuses() {
        const now = new Date();
        const nowMinutes = now.getHours() * 60 + now.getMinutes();

        document.querySelectorAll('.appointment-card').forEach(card => {
            const startStr = card.dataset.start;
            if (!startStr) return;

            const startMinutes = toMinutes(startStr);
            const inProgressEnd = startMinutes + 5;

            const badge = card.querySelector('.status-badge');
            badge.className = "status-badge absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold border";

            // reset border colors
            card.classList.remove("border-green-400", "border-blue-400");
            card.classList.add("border-blue-200");

            if (nowMinutes >= startMinutes && nowMinutes < inProgressEnd) {
                badge.textContent = "In Progress";
                badge.classList.add("bg-blue-100", "text-blue-700", "border-blue-300");
                card.classList.remove("border-blue-200");
                card.classList.add("border-blue-400");
            } else if (nowMinutes >= inProgressEnd) {
                badge.textContent = "Completed";
                badge.classList.add("bg-green-100", "text-green-700", "border-green-300");
                card.classList.remove("border-blue-300");
                card.classList.add("border-green-400");
            } else {
                badge.textContent = "Upcoming";
                badge.classList.add("bg-gray-100", "text-gray-700", "border-gray-200");
            }
        });
    }

    updateAppointmentStatuses();
    setInterval(updateAppointmentStatuses, 30000);
});
</script>
@endpush