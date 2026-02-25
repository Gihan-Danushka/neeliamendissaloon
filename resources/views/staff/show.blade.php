@extends('layout.layout')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Staff Details</h1>
            <p class="text-gray-500 mt-1">View detailed information about {{ $staff->name }}</p>
        </div>
        <a href="{{ route('staff.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            &larr; Back to List
        </a>
    </div>

    {{-- Content --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-customPalette-dark/10 rounded-full flex items-center justify-center text-customPalette-dark text-2xl font-bold mr-4">
                    {{ substr($staff->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $staff->name }}</h2>
                    <p class="text-gray-500">{{ $staff->contact_number }}</p>
                </div>
                <div class="ml-auto">
                     <span class="bg-customPalette-light/20 text-customPalette-light text-xs font-semibold px-2.5 py-0.5 rounded">
                        Rating: {{ $staff->ratings }}/5
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Personal Info --}}
                <div class="border-b md:border-b-0 md:border-r border-gray-200 pb-6 md:pb-0 md:pr-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Professional Info</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-500 block text-sm">Experience</span>
                            <span class="text-gray-800 font-medium">{{ $staff->experience ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Join Date</span>
                            <span class="text-gray-800 font-medium">{{ $staff->join_date ? \Carbon\Carbon::parse($staff->join_date)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Specializations (Categories)</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @forelse($staff->categories as $category)
                                    <span class="bg-customPalette-dark/10 text-customPalette-dark text-xs px-2 py-1 rounded">{{ $category->name }}</span>
                                @empty
                                    <span class="text-gray-400 italic">No categories assigned</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Financial Info --}}
                <div class="pl-0 md:pl-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Financial Details</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-500 block text-sm">Basic Salary</span>
                            <span class="text-gray-800 font-medium">{{ number_format($staff->basic_salary, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">ETF Number</span>
                            <span class="text-gray-800 font-medium">{{ $staff->etf_number ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Bank Details</span>
                            <span class="text-gray-800 font-medium block">{{ $staff->bank_name ?? 'N/A' }}</span>
                            <span class="text-gray-600 text-sm">{{ $staff->bank_account_number ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
