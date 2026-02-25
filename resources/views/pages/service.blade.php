@extends('layout.layout')

@section('content')
<div class="p-6">

    {{-- SweetAlert Notifications --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
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

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
            <style>
                .font-playfair {
                    font-family: 'Playfair Display', serif;
                }
                .font-sans {
                    font-family: 'Sans-serif';
                }
            </style>
            <p class="font-bold text-4xl font-playfair text-customPalette-dark drop-shadow-md">Services</p>
            <p class="text-gray-500 mt-1 text-sm">Browse available categories and services</p>
        </div>

        <a href="{{ route('services.create') }}"
           class="inline-block bg-customPalette-dark hover:bg-customPalette-darker text-white px-5 py-2.5 rounded-lg shadow-md hover:opacity-90 transition duration-200 text-sm font-semibold tracking-wide">
            + Add New Service
        </a>
    </div>

    {{-- Tabs for Gender --}}
    <div class="flex space-x-4 mb-6">
        <button onclick="filterServices('All')" class="tab-btn bg-gray-200 px-4 py-2 rounded-lg font-semibold hover:bg-customPalette-dark hover:text-white">All</button>
        <button onclick="filterServices('Male')" class="tab-btn bg-gray-200 px-4 py-2 rounded-lg font-semibold hover:bg-customPalette-dark hover:text-white">Male</button>
        <button onclick="filterServices('Female')" class="tab-btn bg-gray-200 px-4 py-2 rounded-lg font-semibold hover:bg-customPalette-dark hover:text-white">Female</button>
        <button onclick="filterServices('Both')" class="tab-btn bg-gray-200 px-4 py-2 rounded-lg font-semibold hover:bg-customPalette-dark hover:text-white">Both</button>
    </div>

    {{-- Services Grid --}}
    
    {{-- Categories Grid --}}
<form action="{{ route('services.download') }}" method="POST">
    @csrf
    <div id="categoriesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($categories as $category)
            @if ($category->services->isNotEmpty())
                <div class="category-card bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 transition transform hover:scale-105 hover:shadow-2xl">
                    <!-- Category Header -->
                    <div class="bg-customPalette-dark p-5 text-white flex justify-between items-center rounded-t-xl">
                        <h3 class="text-xl font-bold font-sans tracking-wide">{{ $category->name }}</h3>
                    </div>

                    <!-- Services List -->
                    <div class="p-4 bg-white">
                        <ul class="space-y-3">
                            @foreach ($category->services as $service)
                                <li data-gender="{{ $service->gender }}"
                                    class="service-item flex justify-between items-center p-2 bg-gray-50 rounded-lg shadow-sm hover:bg-gray-100 transition">
                                    <div class="flex items-center space-x-3">
                                        <span class="font-medium text-gray-800 text-base">{{ $service->name }}</span>
                                    </div>
                                    <span class="text-customPalette-dark font-bold">Rs. {{ number_format($service->price, 2) }} +</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</form>

<script>
    function filterServices(gender) {
        document.querySelectorAll('.category-card').forEach(card => {
            let services = card.querySelectorAll('.service-item');
            let visibleCount = 0;

            services.forEach(item => {
                if (gender === 'All' || item.dataset.gender === gender) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // hide category if no services match
            if (visibleCount === 0) {
                card.style.display = 'none';
            } else {
                card.style.display = 'block';
            }
        });

        // highlight active tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-customPalette-dark', 'text-white');
            btn.classList.add('bg-gray-200');
        });
        event.target.classList.remove('bg-gray-200');
        event.target.classList.add('bg-customPalette-dark', 'text-white');
    }

    // Default: Show All
    document.addEventListener('DOMContentLoaded', () => filterServices('All'));
</script>

    



@endsection
