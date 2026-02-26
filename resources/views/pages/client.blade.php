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
            <div class="flex justify-between items-center mb-8">
        <p class="font-bold text-4xl font-playfair text-customPalette-dark drop-shadow-md">Clients</p>
        <button id="openClientForm"
            class="bg-customPalette-dark hover:bg-customPalette-darker text-white font-semibold px-5 py-2 rounded-lg shadow hover:opacity-90 transition flex items-center gap-2">
            <i class="fa fa-user-plus"></i> Add Client
        </button>
    </div>

            <div class="flex justify-between mb-6">
        <form action="{{ route('client-search') }}" method="POST" class="flex items-center gap-2">
            @csrf
            <div class="flex items-center bg-white border border-gray-300 rounded-lg shadow-sm px-3">
                <input type="text" id="search" placeholder="Search by Contact Number" name="search"
                    value="{{ isset($searchTerm) ? $searchTerm : '' }}"
                    class="px-2 py-2 w-64 focus:outline-none text-sm">
                <button type="button" onclick="clearSearch()" class="text-gray-400 hover:text-red-500 ml-2">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <button type="submit" id="searchbutton"
                class="bg-customPalette-dark hover:bg-customPalette-darker text-white font-semibold px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
                <i class="fa fa-search"></i> Search
            </button>
        </form>
    </div>


                <script>
                    function clearSearch() {
                        document.getElementById('search').value = ''; // Clear the input field
                        document.getElementById('searchbutton').click(); // Trigger the click event on the search button
                    }
                </script>

            </div>

            <div class="overflow-x-auto">
                {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Contact</th>
                    <th class="py-3 px-6 text-left">Address</th>
                    <th class="py-3 px-6 text-left">Whatsapp</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($clients as $client)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td hidden>{{ $client->id }}</td>
                        <td class="py-3 px-6">
                            @if ($client->allergies)
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500 mr-2"></span>
                            @endif
                            {{ $client->name }}
                        </td>
                        <td class="py-3 px-6">{{ $client->email }}</td>
                        <td class="py-3 px-6">{{ $client->contact }}</td>
                        <td class="py-3 px-6">{{ $client->address }}</td>
                        <td class="py-3 px-6">{{ $client->whatsapp }}</td>
                        <td class="py-3 px-6 flex justify-center gap-2">
                            <a href="{{ route('client-profile', ['id' => $client->id]) }}">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs shadow">
                                    <i class="fa fa-eye"></i> View
                                </button>
                            </a>
                            <button class="bg-customPalette-light hover:bg-customPalette-buttonhover text-white px-3 py-1 rounded-md text-xs shadow"
                                onclick="editClient({{ $client }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs shadow"
                                onclick="deleteClient({{ $client->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">No clients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
                <!-- Pagination Links -->
                <div class="mt-4 text-center flex justify-center">
                    {{ $clients->links() }} <!-- Ensure pagination links are styled appropriately -->
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="ClientFormModal" class="fixed z-10 inset-0 hidden">
            <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-80">
                <div id="modalContent"
                    class="bg-white w-1/2 rounded shadow-md border overflow-y-auto my-16 transform -translate-y-full transition-transform duration-300">
                    <div class="flex justify-between items-center w-full border mb-4 px-4 bg-customPalette-darker">
                        <!-- Heading in the center -->
                        <div class="flex-grow text-center py-3">
                            <h2 class="text-2xl font-bold text-white">Client Form</h2>
                        </div>

                        <!-- Close button at the end (right) -->
                        <div class="flex justify-end">
                            <button id="closeClientForm" class="text-white hover:text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form id="clientForm" class="space-y-4 p-6" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="id" id="client_id">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Enter client's name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent p-1"
                                value="{{ old('name') }}">
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter client's email"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent p-1">
                        </div>
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact <span class="text-red-500">*</span></label>
                            <input type="tel" id="contact" name="contact"
                                placeholder="Enter client's contact number"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent p-1"
                                value="{{ old('contact') }}">
                                @error('contact')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="address" name="address" rows="3" placeholder="Enter client's address"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent p-1">{{ old('address') }}</textarea>
                            
                                @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            </div>
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp <span class="text-red-500">*</span></label>
                            <input type="tel" id="whatsapp" name="whatsapp"
                                placeholder="Enter client's WhatsApp number"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent p-1"
                                value="{{ old('whatsapp') }}">
                                @error('whatsapp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                        </div>
                        <div>
                            <div class="flex items-center mb-2 gap-3">
                                <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>

                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="toggleAllergies" class="sr-only peer"
                                        onchange="toggleInput()">
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <div id="allergiesdiv" class="hidden">
                                <textarea id="allergies" name="allergies" placeholder="Enter client's allergies"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent p-1"
                                    rows="3"></textarea>

                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="mt-4 bg-customPalette-button text-white font-semibold px-6 py-2 rounded-md hover:bg-customPalette-buttonhover transition-colors">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       <script>
function deleteClient(clientId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then(async (result) => {
    if (!result.isConfirmed) return;

    try {
      const res = await fetch(`/client/delete/${clientId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json' // ✅ IMPORTANT
        }
      });

      // If server returns error, show message
      if (!res.ok) {
        const txt = await res.text();
        throw new Error(txt || 'Delete failed');
      }

      // Some responses can be 204 No Content (no JSON)
      let data = {};
      const contentType = res.headers.get('content-type') || '';
      if (contentType.includes('application/json')) {
        data = await res.json();
      }

      await Swal.fire('Deleted!', data.message || 'Client deleted successfully.', 'success');
      location.reload();

    } catch (err) {
      Swal.fire('Error!', 'There was an error deleting the client. Please try again.', 'error');
      console.error(err);
    }
  });
}
</script>


        <script>
            function toggleInput() {
                const checkbox = document.getElementById('toggleAllergies');
                const allergiesDiv = document.getElementById('allergiesdiv');
                const inputField = document.getElementById('allergies');

                // Toggle the visibility of the input field
                if (checkbox.checked) {
                    allergiesDiv.classList.remove('hidden'); // Show the input field
                    inputField.disabled = false; // Enable the input field
                } else {
                    allergiesDiv.classList.add('hidden'); // Hide the input field
                    inputField.disabled = true; // Disable the input field
                    inputField.value = ''; // Clear the input field if hiding
                }
            }

            const openClientFormButton = document.getElementById('openClientForm');
            const closeClientFormButton = document.getElementById('closeClientForm');
            const ClientFormModal = document.getElementById('ClientFormModal');
            const modalContent = document.getElementById('modalContent');
            const form = document.getElementById('clientForm');
            const formMethodInput = document.getElementById('formMethod');
            const clientIdInput = document.getElementById('client_id');

            // Open modal for adding a new client
            openClientFormButton.addEventListener('click', () => {
                form.reset();
                form.action = '{{ route('client-store') }}'; // Set form action to store route
                formMethodInput.value = 'POST'; // Set form method to POST
                clientIdInput.value = ''; // Clear client id

                // Reset allergies
                const allergiesDiv = document.getElementById('allergiesdiv');
                const checkbox = document.getElementById('toggleAllergies');
                checkbox.checked = false; // Uncheck the checkbox
                allergiesDiv.classList.add('hidden'); // Hide the input field
                document.getElementById('allergies').value = ''; // Clear allergies input

                // Show modal with animation
                ClientFormModal.classList.remove('hidden');
                setTimeout(() => {
                    ClientFormModal.classList.add('visible');
                    modalContent.classList.add('visible'); // Add visible class to modal content
                }, 10); // Delay to allow the hidden class to be removed
            });

            // Close modal
            closeClientFormButton.addEventListener('click', () => {
                modalContent.classList.remove('visible'); // Remove visible class for animation

                // Wait for the transition to finish before hiding the modal
                setTimeout(() => {
                    ClientFormModal.classList.remove('visible');
                    setTimeout(() => {
                        ClientFormModal.classList.add('hidden');
                    }, 300); // Match this duration with the CSS transition duration
                }, 300); // Wait for the slide-out transition
            });

            // Open modal for editing a client
            function editClient(client) {
                form.action = `/client/update/${client.id}`; // Set form action to update route
                formMethodInput.value = 'PATCH'; // Set form method to PATCH
                clientIdInput.value = client.id;
                document.getElementById('name').value = client.name;
                document.getElementById('email').value = client.email;
                document.getElementById('contact').value = client.contact;
                document.getElementById('address').value = client.address;
                document.getElementById('whatsapp').value = client.whatsapp;

                // Set the allergies data
                const allergiesInput = document.getElementById('allergies');
                const allergiesDiv = document.getElementById('allergiesdiv');
                const checkbox = document.getElementById('toggleAllergies');

                // Check if the client has allergies
                if (client.allergies) {
                    checkbox.checked = true; // Check the checkbox
                    allergiesInput.value = client.allergies; // Set the allergies input value
                    allergiesDiv.classList.remove('hidden'); // Show the input field
                    allergiesInput.disabled = false; // Enable the input field
                } else {
                    checkbox.checked = false; // Uncheck the checkbox
                    allergiesDiv.classList.add('hidden'); // Hide the input field
                    allergiesInput.value = ''; // Clear the input field
                    allergiesInput.disabled = true; // Disable the input field
                }

                // Show modal with animation
                ClientFormModal.classList.remove('hidden');
                setTimeout(() => {
                    ClientFormModal.classList.add('visible');
                    modalContent.classList.add('visible'); // Add visible class to modal content
                }, 10); // Delay to allow the hidden class to be removed
            }
        </script>

        <style>
            /* Add this CSS to your existing styles */
            #ClientFormModal {
                transition: opacity 0.3s ease;
                opacity: 0;
                /* Initially hidden */
            }

            #ClientFormModal.visible {
                opacity: 1;
                /* Fully visible when class is added */
            }

            #modalContent {
                transform: translateY(-100%);
                /* Start above the screen */
            }

            #modalContent.visible {
                transform: translateY(0);
                /* Slide down into view */
            }
        </style>
        @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('openClientForm').click(); // Reopen the modal
            });
        </script>
        @endif

    @endsection
</body>

</html>