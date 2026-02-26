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
                        window.location.href = '{{ route('staff.index') }}';
                    }
                });
            });
        </script>
    @endif

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
            <style>
                .font-playfair { font-family: 'Playfair Display', serif; }
            </style>
            <p class="font-bold text-4xl font-playfair text-customPalette-dark drop-shadow-md">Edit Staff Profile</p>
            <p class="text-gray-500 mt-1 text-sm">Update the information for {{ $staff->name }}</p>
        </div>

        <a href="{{ route('staff.index') }}" class="inline-block bg-customPalette-dark hover:bg-customPalette-darker text-white px-5 py-2.5 rounded-lg shadow-md hover:opacity-90 transition duration-200 text-sm font-semibold tracking-wide">
            Back to Staff List
        </a>
    </div>

    {{-- Staff Edit Form --}}
    <form action="{{ route('staff.update', $staff->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Basic Details Section --}}
        <div class="mb-10">
            <h3 class="text-xl font-semibold border-b-2 border-customPalette-dark pb-2 mb-6 text-customPalette-dark">Basic Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div class="form-group mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full" required>
                </div>
                <div class="form-group mb-4">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number', $staff->contact_number) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full" required>
                </div>
                
                <div class="form-group mb-4">
                    <label for="ratings" class="block text-sm font-medium text-gray-700">Ratings</label>
                    <select id="ratings" name="ratings" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('ratings', $staff->ratings) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="experience" class="block text-sm font-medium text-gray-700">Experience</label>
                    <input type="text" id="experience" name="experience" value="{{ old('experience', $staff->experience) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>

                <div class="form-group mb-4">
                    <label for="join_date" class="block text-sm font-medium text-gray-700">Join Date</label>
                    <input type="date" id="join_date" name="join_date" value="{{ old('join_date', $staff->join_date) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>

                <div class="form-group mb-4">
                    <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
                    <select multiple id="categories" name="category_ids[]" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', $staff->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
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
                    <input type="number" step="0.01" id="basic_salary" name="basic_salary" value="{{ old('basic_salary', $staff->basic_salary) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>

                <div class="form-group mb-4">
                    <label for="attendance_allowance" class="block text-sm font-medium text-gray-700">Attendance Allowance</label>
                    <input type="number" step="0.01" id="attendance_allowance" name="attendance_allowance" value="{{ old('attendance_allowance', $staff->attendance_allowance) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>

                <div class="form-group mb-4">
                    <label for="etf_number" class="block text-sm font-medium text-gray-700">ETF Number</label>
                    <input type="text" id="etf_number" name="etf_number" value="{{ old('etf_number', $staff->etf_number) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>

                <div class="form-group mb-4">
                    <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $staff->bank_name) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>

                <div class="form-group mb-4">
                    <label for="bank_account_number" class="block text-sm  font-medium text-gray-700">Bank Account Number</label>
                    <input type="text" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $staff->bank_account_number) }}" class="form-control px-4 py-2 border border-gray-300 rounded-md w-full">
                </div>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-customPalette-dark hover:bg-customPalette-darker text-white font-bold py-2.5 px-10 rounded-md shadow-md transition duration-200">Update Profile</button>
            <a href="{{ route('staff.index') }}" class="px-8 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-md hover:bg-gray-100 transition duration-200">Cancel</a>
        </div>
    </form>
</div>
@endsection
