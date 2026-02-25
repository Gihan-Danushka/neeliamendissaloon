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
                            window.location.href = '{{ route('staff.index') }}'; // Redirect to staff list
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
                <p class="font-bold text-4xl font-playfair text-customPalette-dark drop-shadow-md">Create New Staff</p>
                <p class="text-gray-500 mt-1 text-sm">Fill in the details to add a new staff member</p>
            </div>

            <a href="{{ route('staff.index') }}" class="inline-block bg-customPalette-dark hover:bg-customPalette-darker text-white px-5 py-2.5 rounded-lg shadow-md hover:opacity-90 transition duration-200 text-sm font-semibold tracking-wide">
                Back to Staff List
            </a>
        </div>

        {{-- Staff Creation Form --}}
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf

            {{-- Basic Details Section --}}
            <div class="mb-10">
                <h3 class="text-xl font-semibold border-b-2 border-customPalette-dark pb-2 mb-6 text-customPalette-dark">Basic Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="form-group mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full" required>
                    </div>

                    {{-- Ratings (1 to 5 dropdown) --}}
                    <div class="form-group mb-4">
                        <label for="ratings" class="block text-sm font-medium text-gray-700">Ratings</label>
                        <select id="ratings" name="ratings" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group  mb-4">
                        <label for="experience" class="block text-sm font-medium text-gray-700">Experience</label>
                        <input type="text" id="experience" name="experience" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>

                    <div class="form-group mb-4">
                        <label for="join_date" class="block text-sm font-medium text-gray-700">Join Date</label>
                        <input type="date" id="join_date" name="join_date" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>

                    <div class="form-group mb-4">
                        <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
                        <select multiple id="categories" name="category_ids[]" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Salary Details Section --}}
            <div class="mb-10">
                <h3 class="text-xl font-semibold border-b-2 border-customPalette-dark pb-2 mb-6 text-customPalette-dark">Salary Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="form-group mb-4">
                        <label for="basic_salary" class="block text-sm font-medium text-gray-700">Basic Salary</label>
                        <input type="number" step="0.01" id="basic_salary" name="basic_salary" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>

                    <div class="form-group mb-4">
                        <label for="etf_number" class="block text-sm font-medium text-gray-700">ETF Number</label>
                        <input type="text" id="etf_number" name="etf_number" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>

                    <div class="form-group mb-4">
                        <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>

                    <div class="form-group mb-4">
                        <label for="bank_account_number" class="block text-sm  font-medium text-gray-700">Bank Account Number</label>
                        <input type="text" id="bank_account_number" name="bank_account_number" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-customPalette-dark hover:bg-customPalette-darker text-white font-bold py-2.5 px-6 rounded-md shadow-md transition duration-200">Save Staff</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
<script>
    // Handle star rating click event
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            const ratingValue = this.getAttribute('data-value');
            
            // Set the value of the hidden input field
            document.getElementById('ratings').value = ratingValue;

            // Update the star colors based on selection
            document.querySelectorAll('.star').forEach(starElement => {
                if (starElement.getAttribute('data-value') <= ratingValue) {
                    starElement.style.color = '#FFD700'; // Gold color for selected stars
                } else {
                    starElement.style.color = '#D3D3D3'; // Light gray for unselected stars
                }
            });
        });
    });
</script>
@endsection
