<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="path/to/filter.js" defer></script> <!-- Link to the external JavaScript file -->
</head>

<body>
    @extends('layout.layout')

    @section('content')
        <div class="p-4">
            @if (session('success'))
                <div class="fixed right-5">
                    <div id="successAlert"
                        class="alert alert-success border border-green-500 px-20 py-5 bg-green-300 bg-opacity-65 rounded-md">
                        {{ session('success') }}
                    </div>
                </div>
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
                <div>
                    <p class="font-semibold text-lg">History</p>
                </div>
            </div>
            <form action="{{ route('history-search') }}" method="POST">
                @csrf
                <div class="flex gap-5 w-">
                    <div class="w-1/6">
                        <div class="relative border border-gray-300 rounded-md shadow-sm h-[47px]">
                            <input type="text" placeholder="Search Client Phone number.." id="myInput" name="contact"
                                value="{{ isset($selectedClient) ? $selectedClient->contact : (isset($contact) ? $contact : '') }}"
                                class="rounded-md px-4 py-2 mr-2 focus:outline-none transition duration-200 ease-in-out w-full">

                            <button type="button" id="clearButton"
                                class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-600 hover:text-gray-900 focus:outline-none">
                                &times;
                            </button>
                            <input type="text" name="clientId" id="clientId"
                                value="{{ isset($clientId) ? $clientId : '' }}" hidden>
                        </div>
                        <div>
                            <ul id="clientList"
                                class="border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto transition-all duration-200 ease-in-out hidden fixed bg-white w-1/6">
                                @forelse ($clients as $client)
                                    <li class="client-item px-4 py-2 hover:bg-gray-200 cursor-pointer transition-transform duration-200 ease-in-out "
                                        data-id="{{ $client->id }}" data-contact="{{ $client->contact }}">
                                        {{ $client->contact }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2">No clients found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="w-1/6">
                        <div>
                            <div class="relative border border-gray-300 rounded-md shadow-sm h-[47px]">
                                <input type="text" name="service" id="service" placeholder="Search Service"
                                    value="{{ isset($service) ? $service : '' }}"
                                    class="border px-3 rounded-md w-full py-2 focus:outline-none border-none">
                                <button type="button" id="clearServiceButton"
                                    class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-600 hover:text-gray-900 focus:outline-none">
                                    &times;
                                </button>

                            </div>
                        </div>
                        <div>
                            <ul id="serviceList"
                                class="border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto transition-all duration-200 ease-in-out hidden fixed bg-white w-1/6">
                                @forelse ($services as $service)
                                    <li class="service-item px-4 py-2 hover:bg-gray-200 cursor-pointer transition-transform duration-200 ease-in-out transform"
                                        data-id="{{ $service->id }}">
                                        {{ $service->name }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2">No Service found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="w-1/6">
                        <input type="month" class="border py-2 rounded-md border-gray-400 px-2 h-[47px] w-full"
                            value="{{ isset($months) ? $months : '' }}" name="month">
                    </div>
                    <div class="w-1/6">
                        <select class="border py-2 rounded-md border-gray-400 px-2 h-[47px] w-full" name="day">
                            <option value="">Select a Day</option>
                            <script>
                                const selectElement = document.querySelector('select[name="day"]');
                                const selectedDay = <?php echo isset($day) ? $day : 'null'; ?>; // Get selected day from PHP

                                for (let day = 1; day <= 31; day++) {
                                    const option = document.createElement('option');
                                    option.value = day;
                                    option.textContent = day;

                                    // Check if selectedDay is set and matches the current day
                                    if (selectedDay !== null && day === selectedDay) {
                                        option.selected = true; // Mark this option as selected
                                    }

                                    selectElement.appendChild(option);
                                }
                            </script>
                        </select>
                    </div>
                    <div class="w-1/6">
                        <button type="submit"
                            class="border py-2 bg-customPalette-dark text-white rounded-md hover:bg-customPalette-darker border-gray-400 px-2 h-[47px] w-full">
                            Search </button>
                    </div>
                </div>
            </form>

            <div class="mt-10">
                <table class="min-w-full table-auto bg-white border-collapse shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-200 text-left text-sm uppercase leading-normal">
                            <th class="py-3 px-6">Date</th>
                            <th class="py-3 px-6">Client</th>
                            <th class="py-3 px-6">Total Price</th>
                            <th class="py-3 px-6">
                                <div class="flex">
                                    <div class="w-3/12">
                                        Service Name
                                    </div>
                                    <div class="w-3/12">
                                        Service Price
                                    </div>
                                    <div class="w-3/12">
                                        reminding date
                                    </div>
                                    <div class="w-3/12">
                                        Service details
                                    </div>
                                </div>

                            </th>
                            {{-- <th class="py-3 px-6">Service Price</th>
                            <th class="py-3 px-6">Reminding Date</th>
                            <th class="py-3 px-6">Details</th> --}}
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse ($invoices as $invoice)
                            <!-- Renamed to $invoices -->
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 whitespace-nowrap">{{ $invoice->date }}</td>
                                <td class="py-3 px-6 whitespace-nowrap">{{ $invoice->client->name }}</td>
                                <td class="py-3 px-6 whitespace-nowrap">{{ $invoice->total_price }}</td>
                                <td colspan="4" class="py-3 px-6 whitespace-nowrap">
                                    @foreach ($invoice->details as $detail)
                                        <div class="mb-2 flex">
                                            <span class="font-medium w-3/12">{{ $detail->name }}</span>
                                            <span class="text-gray-500 w-3/12">Rs. {{ $detail->price }}</span>
                                            <span class="font-medium w-3/12">{{ $detail->reminding_date }}</span>
                                            <span class="text-gray-400 w-3/12">
                                                <div>{{ $detail->color ? 'Color: ' . $detail->color : '' }}</div>
                                                <div>{{ $detail->colorCode ? 'Color Code: ' . $detail->colorCode : '' }}
                                                </div>
                                                <div>{{ $detail->percentage ? 'Percentage: ' . $detail->percentage : '' }}
                                                </div>
                                            </span>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No clients found.</td> <!-- colspan=7 -->
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 text-center flex justify-center">
                    {{ $invoices->links() }} <!-- Ensure pagination links are styled appropriately -->
                </div>
            </div>

        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const clientInput = document.getElementById('myInput');
                const clientList = document.getElementById('clientList');
                const serviceInput = document.getElementById('service');
                const serviceList = document.getElementById('serviceList');
                const clientIdInput = document.getElementById('clientId'); // Get the clientId input

                function filterFunction() {
                    const filter = clientInput.value.toUpperCase().trim();
                    const li = clientList.getElementsByClassName('client-item');

                    // Show or hide client list based on input
                    clientList.classList.toggle('hidden', !filter);

                    // Filter client list items
                    Array.from(li).forEach(item => {
                        const txtValue = item.textContent || item.innerText;
                        item.style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                    });
                }

                function clearSearch() {
                    clientInput.value = '';
                    clientIdInput.value = ''; // Clear clientId input
                    clientList.classList.add('hidden'); // Hide list
                }

                function filterService() {
                    const filter = serviceInput.value.toUpperCase().trim();
                    const li = serviceList.getElementsByClassName('service-item');

                    // Show or hide service list based on input
                    serviceList.classList.toggle('hidden', !filter);

                    // Filter service list items
                    Array.from(li).forEach(item => {
                        const txtValue = item.textContent || item.innerText;
                        item.style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                    });
                }

                function clearService() {
                    serviceInput.value = '';
                    serviceList.classList.add('hidden'); // Hide list
                }

                // Add click events to client and service list items
                function addClientClickEvents() {
                    document.querySelectorAll('.client-item').forEach(item => {
                        item.addEventListener('click', function() {
                            clientInput.value = this.getAttribute('data-contact'); // Set input value
                            clientIdInput.value = this.getAttribute('data-id'); // Set clientId value
                            clientList.classList.add('hidden'); // Hide list
                        });
                    });
                }

                function addServiceClickEvents() {
                    document.querySelectorAll('.service-item').forEach(item => {
                        item.addEventListener('click', function() {
                            serviceInput.value = this.innerText; // Set input value
                            serviceList.classList.add('hidden'); // Hide list
                        });
                    });
                }

                // Event listeners
                clientInput.addEventListener('keyup', filterFunction);
                serviceInput.addEventListener('keyup', filterService);
                document.getElementById('clearButton').addEventListener('click', clearSearch);
                document.getElementById('clearServiceButton').addEventListener('click', clearService);

                // Initialize click events
                addClientClickEvents();
                addServiceClickEvents();
            });
        </script>
    @endsection
</body>

</html>
