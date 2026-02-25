@extends('layout.layout')

@section('content')
    <div class="p-8 bg-gray-50 min-h-screen">
        <a href="{{ route('services') }}"
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg shadow hover:bg-gray-600 transition">
            Back
        </a>
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-customPalette-dark">Add New Service</h2>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if ($errors->has('category'))
                <div class="bg-red-100 text-red-700 p-2 mb-2 rounded">
                    {{ $errors->first('category') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('pages.service') }}" method="POST" class="space-y-6">
                @csrf
                {{-- Category --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Select Category</label>
                        <select name="category_id" class="w-full border rounded p-3 focus:ring-2 focus:ring-customPalette-dark">
                            <option value="">-- Choose Existing Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Or Add New Category</label>
                        <input type="text" name="new_category"
                               class="w-full border rounded p-3 focus:ring-2 focus:ring-customPalette-dark"
                               placeholder="Enter new category name">
                    </div>
                </div>

                {{-- Service Name --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="name"
                           class="w-full border rounded p-3 focus:ring-2 focus:ring-customPalette-dark"
                           placeholder="Enter service name" required>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Price (Rs.)</label>
                    <input type="number" name="price" step="0.01"
                           class="w-full border rounded p-3 focus:ring-2 focus:ring-customPalette-dark"
                           placeholder="Enter price" required>
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" class="w-full border rounded p-3 focus:ring-2 focus:ring-customPalette-dark" required>
                        <option value="Both" selected>Both</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description"
                              class="w-full border rounded p-3 focus:ring-2 focus:ring-customPalette-dark"
                              rows="4" placeholder="Enter service description (optional)"></textarea>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-customPalette-dark text-white px-6 py-3 rounded-lg hover:bg-customPalette-darker shadow-md transition">
                        Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
