<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    @extends('layout.layout')

    @section('content')
        <div class="p-4">
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
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <p class="font-semibold text-lg">
                        <a href="{{ route('client') }}"> Client </a>
                        <span class="text-gray-600">→ Profile</span> <!-- Use arrow instead of -> for a more modern look -->
                    </p>
                </div>
            </div>
            <div class="flex w-full gap-10 mt-10">
                <!-- Client Personal Details -->
                <div class="w-1/2 border rounded-lg shadow-md p-6 bg-white h-fit">
                    <h1 class="text-center text-2xl font-bold mb-4">Client Personal Details</h1>
                    <table class="w-full mt-10">
                        <tbody class="border-t">
                            <tr class="border-b">
                                <td class="p-2">
                                    <i class="fa fa-user text-purple-500 text-lg mr-2"></i> <!-- Changed to purple -->
                                    <span class="font-semibold">Name:</span>
                                </td>
                                <td class="p-2">
                                    <span class="ml-2 text-gray-700">{{ $client->name }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2">
                                    <i class="fa fa-envelope text-teal-500 text-lg mr-2"></i> <!-- Changed to teal -->
                                    <span class="font-semibold">Email:</span>
                                </td>
                                <td class="p-2">
                                    <span class="ml-2 text-gray-700">{{ $client->email }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2">
                                    <i class="fa fa-phone text-yellow-500 text-lg mr-2"></i> <!-- Changed to yellow -->
                                    <span class="font-semibold">Contact:</span>
                                </td>
                                <td class="p-2">
                                    <span class="ml-2 text-gray-700">{{ $client->contact }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2">
                                    <i class="fa fa-home text-pink-500 text-lg mr-2"></i> <!-- Changed to pink -->
                                    <span class="font-semibold">Address:</span>
                                </td>
                                <td class="p-2">
                                    <span class="ml-2 text-gray-700">{{ $client->address }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2">
                                    <i class="fa fa-whatsapp text-green-500 text-lg mr-2"></i>
                                    <!-- Kept green for WhatsApp -->
                                    <span class="font-semibold">WhatsApp:</span>
                                </td>
                                <td class="p-2">
                                    <span class="ml-2 text-gray-700">{{ $client->whatsapp }}</span>
                                </td>
                            </tr>
                            @if ($client->allergies)
                                <tr class="border-b">
                                    <td class="p-2">
                                        <i class="fa fa-exclamation-circle text-red-500 text-lg mr-2"></i>
                                        <!-- Kept red for warnings -->
                                        <span class="font-semibold">Allergies:</span>
                                    </td>
                                    <td class="p-2">
                                        <span class="ml-2 text-gray-700">{{ $client->allergies }}</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Client History -->
                <div class="w-1/2 border rounded-lg shadow-md p-6 bg-white h-full">
                    <h1 class="text-center text-2xl font-bold mb-4">Client History</h1>
                    <div class="text-gray-700 mt-10">
                        <!-- Add relevant client history content here -->
                        <table class="min-w-full divide-y divide-gray-200 table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex">
                                            <div class="w-2/5">service name</div>
                                            <div class="w-1/5">service price</div>
                                            <div class="w-2/5">Reminding Date</div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($history as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $invoice->date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rs.
                                            {{ $invoice->total_price }}</td>
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                            @foreach ($invoice->details as $detail)
                                                <div class="mb-2 flex">
                                                    <span class="font-medium w-2/5">{{ $detail->name }}</span>
                                                    <span class="text-gray-500 w-1/5"> Rs. {{ $detail->price }}</span>
                                                    <span class="text-gray-400 w-2/5">
                                                        {{ $detail->reminding_date ? $detail->reminding_date : '' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No client
                                            history available yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="mt-10 flex justify-end">
                <a href="{{ route('invoice-client', ['id' => $client->id]) }}">
                            <button
                                class="bg-customPalette-dark text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-customPalette-darker focus:outline-none focus:ring-2 focus:ring-customPalette-dark focus:ring-opacity-75 transition duration-200">
                                New Invoice
                            </button>
                </a>
            </div>
        </div>
    @endsection
</body>

</html>
