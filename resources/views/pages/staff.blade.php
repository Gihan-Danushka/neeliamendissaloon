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
            <p class="font-bold text-4xl font-playfair text-customPalette-dark drop-shadow-md">Manage Staff</p>
            <p class="text-gray-500 mt-1 text-sm">Browse and manage your staff members</p>
        </div>

        <a href="{{ route('staff.create') }}"
   class="inline-block bg-customPalette-dark hover:bg-customPalette-darker text-white px-5 py-2.5 rounded-lg shadow-md hover:opacity-90 transition duration-200 text-sm font-semibold tracking-wide">
    + Add New Staff Member
</a>

    </div>

    

    {{-- Staff Table --}}
    @if($staffMembers->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
            <p>No staff members available. Please add new staff.</p>
        </div>
    @else
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Contact Number</th>
                    <th class="px-4 py-2 text-left">Ratings</th>
                    <th class="px-4 py-2 text-left">Experience</th>
                    <th class="px-4 py-2 text-left">Join Date</th>
                    <th class="px-4 py-2 text-left">Bank Details</th>
                    <th class="px-4 py-2 text-left">Basic Salary</th>
                    <th class="px-4 py-2 text-left">ETF Number</th>
                    <th class="px-4 py-2 text-left">Categories</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staffMembers as $staff)
                     <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $staff->name }}</td>
                        <td class="px-4 py-2">{{ $staff->contact_number }}</td>
                        <td class="px-4 py-2">{{ $staff->ratings }}</td>
                        <td class="px-4 py-2">{{ $staff->experience }}</td>
                        <td class="px-4 py-2">{{ $staff->join_date }}</td>
                        <td class="px-4 py-2">
                            {{ $staff->bank_name }}<br>
                            <span class="text-xs text-gray-500">{{ $staff->bank_account_number }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $staff->basic_salary }}</td>
                        <td class="px-4 py-2">{{ $staff->etf_number }}</td>
                        <td class="px-4 py-2">
                            {{ implode(', ', $staff->categories->pluck('name')->toArray()) }}
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('staff.show', $staff->id) }}" class="text-green-500 hover:text-green-700 mr-2">
                                <i class="fa fa-eye"></i> View
                            </a>
                            
                            <a href="{{ route('staff.edit', $staff->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            
                            <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

@push('scripts')
<script>
    // Staff index scripts
</script>
@endpush
