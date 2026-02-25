@extends('layout.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100">
    
    {{-- SweetAlert Notifications --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1e3a8a',
                    timer: 3000
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        location.reload();
                    }
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

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        /* Custom date/time input styling */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: invert(25%) sepia(91%) saturate(2251%) hue-rotate(218deg) brightness(91%) contrast(92%);
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #dbeafe;
            border-radius: 10px;
            margin: 8px 0;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #1e40af, #1e3a8a);
            border-radius: 10px;
            border: 1px solid #bfdbfe;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #1e3a8a, #172554);
        }
        
        /* Animation classes */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slideUp {
            animation: slideUp 0.6s ease-out forwards;
        }
        
        /* Modal animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-overlay {
            animation: fadeIn 0.3s ease-out;
        }
        
        .modal-content {
            animation: slideDown 0.4s ease-out;
        }
        
        /* Stagger animation delays */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        /* Filter button active state */
        .filter-btn-active {
            background: #1e3a8a;
            color: white;
            border-color: #1e3a8a;
        }

        /* Badge styles */
        .badge-pending {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
        }
        .badge-approved {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        .badge-rejected {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        .badge-completed {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        /* --- Select2 Custom Styling --- */
        .select2-container--default .select2-selection--single {
            height: 3rem !important; /* Matches h-12 */
            border: 2px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151 !important;
            padding-left: 1rem !important;
            font-size: 1rem !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 2.8rem !important;
            right: 0.5rem !important;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #1e3a8a !important;
            ring: 2px !important;
            ring-color: rgba(209, 120, 90, 0.2) !important;
        }

        .select2-dropdown {
            border: 2px solid #1e3a8a !important;
            border-radius: 0.75rem !important;
            z-index: 9999 !important;
            overflow: hidden !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: #1e3a8a !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 2px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            padding: 8px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #1e3a8a !important;
            outline: none !important;
        }
    </style>

    {{-- Main Container --}}
    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header Section with Add Booking Button --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 animate-slideUp">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-playfair text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-900 mb-2">
                    Appointment Management
                </h1>
                <p class="text-gray-600 text-base sm:text-lg font-inter">
                    Manage all appointments for <span class="font-bold text-customPalette-dark">Neeliya Mendis Salon</span>
                </p>
            </div>

            {{-- Add Booking Button --}}
            <button onclick="openBookingModal()" class="bg-customPalette-dark hover:bg-customPalette-darker
                       text-white font-bold px-8 py-4 rounded-xl shadow-lg 
                       transform transition-all duration-200 hover:scale-105 hover:shadow-xl
                       flex items-center space-x-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span>ADD BOOKING</span>
            </button>
        </div>

       

        {{-- Filter Buttons with Date Filter --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 animate-slideUp delay-200">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                {{-- Status Filters --}}
                <div class="flex flex-wrap gap-3 items-center flex-1">
                    <p class="text-gray-700 font-semibold font-inter mr-2">Filter by:</p>
                    <button onclick="filterAppointments('all')" class="filter-btn filter-btn-active px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        All Appointments
                    </button>
                    <button onclick="filterAppointments('pending')" class="filter-btn px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        Pending
                    </button>
                    <button onclick="filterAppointments('approved')" class="filter-btn px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        Approved
                    </button>
                    <button onclick="filterAppointments('rejected')" class="filter-btn px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        Rejected
                    </button>
                   {{--  <button onclick="filterAppointments('completed')" class="filter-btn px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        Completed
                    </button>
                    <button onclick="filterAppointments('today')" class="filter-btn px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        Today
                    </button> --}}
                    <button onclick="filterAppointments('upcoming')" class="filter-btn px-6 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 hover:scale-105">
                        Upcoming
                    </button>
                </div>

                {{-- Date Filter --}}
                <div class="flex items-center gap-3">
                    <label class="text-gray-700 font-semibold font-inter whitespace-nowrap">Date:</label>
                    <input type="date" id="dateFilter" onchange="filterByDate()"
                           class="px-4 py-2.5 rounded-xl border-2 border-gray-300 font-semibold text-sm transition-all duration-200 focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20">
                    <button onclick="clearDateFilter()" class="px-4 py-2.5 rounded-xl bg-gray-200 hover:bg-gray-300 font-semibold text-sm transition-all duration-200">
                        Clear
                    </button>
                </div>
            </div>
        </div>

        {{-- Appointments List --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-blue-100 animate-slideUp delay-300">
            <div class="bg-customPalette-dark px-6 sm:px-8 py-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-white font-playfair flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    All Appointments
                </h2>
                <p class="text-blue-100 mt-2 text-sm font-inter">View and manage all scheduled appointments</p>
            </div>

            <div class="p-6">
                @if($appointments->count() > 0)
                    <div id="appointmentsList" class="space-y-4 custom-scrollbar" style="max-height: 800px; overflow-y: auto;">
                        @foreach($appointments->groupBy(function($app) { return \Carbon\Carbon::parse($app->date)->format('Y-m-d'); }) as $date => $dayAppointments)
                            <div class="appointment-group mb-6" data-date="{{ $date }}">
                                {{-- Date Header --}}
                                <div class="flex items-center mb-4">
                                    <div class="flex-grow border-t border-gray-300"></div>
                                    <div class="px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg">
                                        <p class="text-sm font-bold text-gray-700 font-inter">
                                            {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                                        </p>
                                    </div>
                                    <div class="flex-grow border-t border-gray-300"></div>
                                </div>

                                {{-- Appointments for this date --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                                    @foreach($dayAppointments->sortBy('start_time') as $app)
                                        @php
                                            $serviceNames = $app->services?->pluck('name')->toArray() ?? [];
                                            
                                            // Auto-complete past approved appointments
                                            $appointmentDateTime = \Carbon\Carbon::parse($app->date . ' ' . $app->end_time);
                                            $isPast = $appointmentDateTime->isPast();
                                            $displayStatus = $app->status;
                                            
                                            if ($app->status === 'approved' && $isPast) {
                                                $displayStatus = 'completed';
                                            }
                                            
                                            // Set colors based on status
                                            $statusClass = 'border-l-gray-400';
                                            $badgeClass = 'bg-gray-500';
                                            
                                            switch($displayStatus) {
                                                case 'pending':
                                                    $statusClass = 'border-l-amber-500';
                                                    $badgeClass = 'badge-pending';
                                                    break;
                                                case 'approved':
                                                    $statusClass = 'border-l-emerald-500';
                                                    $badgeClass = 'badge-approved';
                                                    break;
                                                case 'rejected':
                                                    $statusClass = 'border-l-red-500';
                                                    $badgeClass = 'badge-rejected';
                                                    break;
                                                case 'completed':
                                                    $statusClass = 'border-l-purple-500';
                                                    $badgeClass = 'badge-completed';
                                                    break;
                                            }
                                        @endphp

                                        <div class="appointment-card bg-gradient-to-br from-blue-50 via-white to-blue-100 rounded-2xl p-5 border-l-4 {{ $statusClass }} border border-blue-200 hover:shadow-lg transition-all duration-200"
                                             data-status="{{ $app->status }}"
                                             data-display-status="{{ $displayStatus }}"
                                             data-date="{{ $app->date }}">
                                            
                                            {{-- Card Header --}}
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center space-x-3 flex-1">
                                                    <div class="w-12 h-12 rounded-xl bg-customPalette-dark text-white flex items-center justify-center font-bold text-lg shadow-md flex-shrink-0">
                                                        {{ $app->display_initial }}
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="font-bold text-gray-800 text-base truncate">
                                                            {{ $app->display_name }}
                                                        </p>
                                                        <div class="flex items-center text-xs text-gray-600 mt-1">
                                                            <svg class="w-3.5 h-3.5 mr-1.5 text-customPalette-dark" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            {{ $app->start_time }} - {{ $app->end_time }}
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                {{-- Status Badge --}}
                                                <div class="px-3 py-1.5 rounded-lg text-white font-bold text-xs shadow-md {{ $badgeClass }}">
                                                    {{ strtoupper($displayStatus) }}
                                                </div>
                                            </div>

                                            {{-- Services --}}
                                            @if(count($serviceNames))
                                                <div class="mb-4 flex flex-wrap gap-2">
                                                    @foreach($serviceNames as $s)
                                                        <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-white text-gray-700 border border-gray-200">
                                                            <svg class="w-3 h-3 mr-1.5 text-customPalette-dark" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            {{ $s }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Actions --}}
                                            @if($app->status === 'pending')
                                                <div class="flex space-x-2">
                                                    <form method="POST" action="{{ route('appointments.approve', $app->id) }}" class="flex-1">
                                                        @csrf
                                                        <button type="submit"
                                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 
                                                                   text-white hover:from-emerald-600 hover:to-green-700 
                                                                   text-sm font-bold shadow-md hover:shadow-lg 
                                                                   transform transition-all duration-200 hover:scale-105">
                                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('appointments.cancel', $app->id) }}" class="flex-1">
                                                        @csrf
                                                        <button type="submit"
                                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 
                                                                   text-white hover:from-red-600 hover:to-rose-700 
                                                                   text-sm font-bold shadow-md hover:shadow-lg 
                                                                   transform transition-all duration-200 hover:scale-105">
                                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($app->status === 'rejected')
                                                <div class="text-center py-2 text-red-600 font-semibold text-sm">
                                                    ✗ Appointment Rejected
                                                </div>
                                            @elseif($displayStatus === 'completed')
                                                <div class="text-center py-2 text-purple-600 font-semibold text-sm">
                                                    ✓ Appointment Completed
                                                </div>
                                            @else
                                                <div class="text-center py-2 text-emerald-600 font-semibold text-sm">
                                                    ✓ Appointment Confirmed
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-inter">No appointments found</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer Note --}}
        <div class="text-center mt-8 pb-4">
            <p class="text-gray-500 text-sm font-inter">
                Need assistance? Contact us at <a href="tel:+94771234567" class="text-customPalette-dark font-semibold hover:underline">+94 77 123 4567</a>
            </p>
        </div>

    </div>

    {{-- Modal for Add Booking --}}
    <div id="bookingModal" class="hidden fixed inset-0 z-50 overflow-y-auto modal-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeBookingModal()">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full modal-content">
                
                {{-- Modal Header --}}
                <div class="bg-customPalette-dark px-6 sm:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white font-playfair flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            New Booking
                        </h2>
                        <button onclick="closeBookingModal()" class="text-white hover:text-blue-100 transition-colors">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-blue-100 mt-2 text-sm font-inter">Complete the form to create a new appointment</p>
                </div>

                {{-- Modal Form --}}
                <form method="POST" action="{{ route('bookings.store') }}" class="p-6 sm:p-8 space-y-5 font-inter max-h-[65vh] overflow-y-auto custom-scrollbar">
                    @csrf

                    {{-- All Fields Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        {{-- Full Name --}}
                        <div class="group md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Full Name <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="full_name" placeholder="John Doe"
                                class="w-full h-12 text-base px-4 rounded-xl border-2 border-gray-200 shadow-sm 
                                       focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                       transition-all duration-200 group-hover:border-gray-300" required>
                        </div>
                        
                        {{-- Email Address --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                Email Address
                            </label>
                            <input type="email" name="email" placeholder="john@example.com"
                                class="w-full h-12 text-base px-4 rounded-xl border-2 border-gray-200 shadow-sm 
                                       focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                       transition-all duration-200 group-hover:border-gray-300">
                        </div>
                        
                        {{-- Phone Number --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                Phone Number <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" name="phone" placeholder="+94 77 123 4567"
                                class="w-full h-12 text-base px-4 rounded-xl border-2 border-gray-200 shadow-sm 
                                       focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                       transition-all duration-200 group-hover:border-gray-300" required>
                        </div>

                        {{-- Select Service --}}
                        <div class="group md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                </svg>
                                Select Service <span class="text-red-500 ml-1">*</span>
                            </label>
                            <select name="service_id" id="serviceSelect"
                                class="w-full h-12 text-base px-4 rounded-xl border-2 border-gray-200 shadow-sm 
                                       focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                       transition-all duration-200 group-hover:border-gray-300 bg-white" required>
                                <option value="" disabled selected>Choose a service...</option>
                                @foreach($services as $service)
                                    {{-- add a padded numeric code for easier searching (e.g. 01, 02, …) --}}
                                    @php
                                        $code = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <option value="{{ $service->id }}" data-code="{{ $code }}">
                                        {{ $code }} - {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Appointment Date --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                Appointment Date <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="date" name="date"
                                class="w-full h-12 text-base px-4 rounded-xl border-2 border-gray-200 shadow-sm 
                                       focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                       transition-all duration-200 group-hover:border-gray-300" required>
                        </div>
                        
                        {{-- Preferred Time --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Preferred Time <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="time" name="start_time"
                                class="w-full h-12 text-base px-4 rounded-xl border-2 border-gray-200 shadow-sm 
                                       focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                       transition-all duration-200 group-hover:border-gray-300" required>
                        </div>
                    </div>

                    {{-- Message Field - Full Width --}}
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#D1785A]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                            </svg>
                            Special Requests
                        </label>
                        <textarea name="message" rows="3" placeholder="Any special requirements..."
                            class="w-full text-base px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm 
                                   focus:border-customPalette-dark focus:ring-2 focus:ring-customPalette-dark/20 
                                   transition-all duration-200 group-hover:border-gray-300 resize-none"></textarea>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex space-x-4 pt-2">
                        <button type="button" onclick="closeBookingModal()"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-8 py-4 text-lg rounded-xl
                                   transform transition-all duration-200 hover:scale-[1.02]">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 bg-customPalette-dark hover:bg-customPalette-darker
                                   text-white font-bold px-8 py-4 text-lg rounded-xl shadow-lg 
                                   transform transition-all duration-200 hover:scale-[1.02] hover:shadow-xl
                                   flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>CONFIRM BOOKING</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- JavaScript for Modal and Filtering --}}
    <script>
        // Modal Functions
        function openBookingModal() {
            document.getElementById('bookingModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeBookingModal();
            }
        });

        // Filter Functions
        function filterAppointments(filterType) {
            const allCards = document.querySelectorAll('.appointment-card');
            const allGroups = document.querySelectorAll('.appointment-group');
            const today = new Date().toISOString().split('T')[0];
            
            // Clear date filter
            document.getElementById('dateFilter').value = '';
            
            // Update filter button states
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('filter-btn-active');
            });
            event.target.classList.add('filter-btn-active');

            // Show/hide cards based on filter
            allCards.forEach(card => {
                const status = card.dataset.status;
                const displayStatus = card.dataset.displayStatus;
                const date = card.dataset.date;
                let shouldShow = false;

                switch(filterType) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'pending':
                        shouldShow = status === 'pending';
                        break;
                    case 'approved':
                        shouldShow = status === 'approved' && displayStatus !== 'completed';
                        break;
                    case 'rejected':
                        shouldShow = status === 'rejected';
                        break;
                    case 'completed':
                        shouldShow = displayStatus === 'completed';
                        break;
                    case 'today':
                        shouldShow = date === today;
                        break;
                    case 'upcoming':
                        shouldShow = date >= today;
                        break;
                }

                card.style.display = shouldShow ? 'block' : 'none';
            });

            // Hide empty date groups
            allGroups.forEach(group => {
                const visibleCards = group.querySelectorAll('.appointment-card[style="display: block;"], .appointment-card:not([style*="display: none"])');
                group.style.display = visibleCards.length > 0 ? 'block' : 'none';
            });
        }

        // Date Filter Function
        function filterByDate() {
            const selectedDate = document.getElementById('dateFilter').value;
            const allCards = document.querySelectorAll('.appointment-card');
            const allGroups = document.querySelectorAll('.appointment-group');
            
            // Clear status filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('filter-btn-active');
            });
            
            if (!selectedDate) return;
            
            allCards.forEach(card => {
                const cardDate = card.dataset.date;
                card.style.display = cardDate === selectedDate ? 'block' : 'none';
            });
            
            // Hide empty date groups
            allGroups.forEach(group => {
                const visibleCards = group.querySelectorAll('.appointment-card[style="display: block;"], .appointment-card:not([style*="display: none"])');
                group.style.display = visibleCards.length > 0 ? 'block' : 'none';
            });
        }

        // Clear Date Filter
        function clearDateFilter() {
            document.getElementById('dateFilter').value = '';
            filterAppointments('all');
            
            // Re-activate "All" filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('filter-btn-active');
            });
            document.querySelector('.filter-btn').classList.add('filter-btn-active');
        }

        // Set minimum date to today for date inputs
        document.addEventListener('DOMContentLoaded', function() {
            const dateInputs = document.querySelectorAll('input[type="date"]');
            const today = new Date().toISOString().split('T')[0];
            dateInputs.forEach(input => {
                input.min = today;
            });

            // Initialize Select2 for service dropdown
            $('#serviceSelect').select2({
                placeholder: "Search for a service...",
                allowClear: true,
                dropdownParent: $('#bookingModal'),
                width: '100%',
                matcher: function(params, data) {
                    // default behaviour first (matches against text)
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    var originalMatcher = $.fn.select2.defaults.defaults.matcher;
                    var match = originalMatcher(params, data);
                    if (match != null) {
                        return match;
                    }

                    // custom match against the numeric code stored in data-code
                    var code = $(data.element).data('code');
                    if (code && code.toString().toLowerCase().indexOf(params.term.toLowerCase()) !== -1) {
                        return data;
                    }

                    return null;
                }
            });
        });
    </script>
</div>
@endsection