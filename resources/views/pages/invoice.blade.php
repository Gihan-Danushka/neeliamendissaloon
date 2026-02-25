    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://unpkg.com/feather-icons"></script>
    </head>

    <body class="bg-gray-50">
    @extends('layout.layout')

    @section('content')
    <div class="p-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <p class="font-bold text-4xl font-playfair text-customPalette-dark drop-shadow-md">Invoice</p>
            
        </div>

        {{-- Client & Service Selection --}}
        <div class="flex gap-10">
            <div class="w-1/2 shadow-lg border rounded-xl p-6 bg-white">
                <form id="invoiceForm">

                    {{-- Client --}}
                    <div class="p-7">
                        <label for="client" class="block text-sm font-semibold mb-2">Select Client</label>
                        <select id="client" name="client_id" class="w-full border rounded-md">
                            <option value="">-- Select Client --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}"
                                    data-name="{{ $client->name }}"
                                    data-email="{{ $client->email }}"
                                    data-contact="{{ $client->contact }}"
                                    data-whatsapp="{{ $client->whatsapp }}"
                                    data-address="{{ $client->address }}">
                                    {{ $client->contact }} - {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Staff --}}
                    <div class="px-7 pb-7">
                        <label for="staff" class="block text-sm font-semibold mb-2">Select Staff</label>
                        <select id="staff" name="staff_id" class="w-full border rounded-md">
                            <option value="">-- Select Staff --</option>
                            @foreach(($staffMembers ?? collect()) as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2">Used to calculate 10% payroll commission.</p>
                    </div>

                    {{-- Service --}}
                    <div class="mb-6 p-7">
                        <label for="service" class="block text-sm font-semibold mb-2">Select Service</label>
                        <select id="service" class="w-full border rounded-md">
                            <option value="">-- Select Service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3 items-center">
                        <input type="number" id="servicePrice" 
                            class="border rounded-md px-3 py-2 w-40 bg-gray-100 font-semibold" readonly>
                        <button type="button" onclick="addService()" 
                            class="px-5 py-2 bg-customPalette-dark text-white rounded-lg shadow hover:bg-customPalette-darker transition">
                            + Add Service
                        </button>
                    </div>
                </form>
            </div>

            {{-- Client Info --}}
            <div class="w-1/2 shadow-lg border rounded-xl p-6 bg-white">
                <h2 class="text-lg font-semibold">Selected Client</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <p><strong>Name:</strong> <span id="clientName"></span></p>
                    <p><strong>Email:</strong> <span id="clientEmail"></span></p>
                    <p><strong>Contact:</strong> <span id="clientContact"></span></p>
                    <p><strong>WhatsApp:</strong> <span id="clientWhatsapp"></span></p>
                    <p><strong>Address:</strong> <span id="clientAddress"></span></p>
                </div>
            </div>
        </div>

        {{-- Bill Details --}}
        <div class="mt-12 shadow-lg bg-white rounded-xl p-6" id="billArea">
            <h3 class="text-xl font-semibold mb-4">Invoice Details</h3>
            <table class="w-full text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Service</th>
                        <th class="px-4 py-2">Price (Rs.)</th>
                    </tr>
                </thead>
                <tbody id="serviceList"></tbody>
            </table>

            <div class="mt-6 text-xl font-bold">
                Total: Rs. <span id="totalAmount">0.00</span>
            </div>

            <div class="mt-6 flex gap-6 items-center">
                <label class="font-semibold">Cash Given:</label>
                <input type="number" id="cashGiven" 
                    class="border px-3 py-2 rounded-md w-40" oninput="calculateBalance()">
            </div>

            <div class="mt-4 text-lg font-bold text-gray-800">
                Balance: Rs. <span id="balanceAmount">0.00</span>
            </div>
        </div>

        {{-- Preview Styled Invoice Form --}}
        <form id="previewForm" action="{{ route('invoice.preview') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="client_id" id="client_id_hidden">
            <input type="hidden" name="staff_id" id="staff_id_hidden">
            <div id="servicesHiddenInputs"></div>
            <input type="hidden" name="cashGiven" id="cashGivenHidden">

            <div class="flex gap-3">
                
                <input type="hidden" name="print_receipt" id="printReceiptHidden" value="0">

                {{-- ✅ New Download button using the SAME function, no edits to functions --}}
                <button type="button"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700"
                onclick="downloadInvoice()">
                Download PDF
                </button>



            </div>
        </form>

    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#client').select2();
            $('#staff').select2();
            $('#service').select2();
            feather.replace();
        });

        // Client info
        $('#client').on('change', function() {
            let selected = $(this).find(':selected');
            $('#clientName').text(selected.data('name'));
            $('#clientEmail').text(selected.data('email'));
            $('#clientContact').text(selected.data('contact'));
            $('#clientWhatsapp').text(selected.data('whatsapp'));
            $('#clientAddress').text(selected.data('address'));
        });

        // Service price
        $('#service').on('change', function() {
            let price = $(this).find(':selected').data('price') || 0;
            $('#servicePrice').val(price);
        });

        // Add service
        let total = 0, serviceCounter = 0;
        function addService() {
            let serviceName = $('#service option:selected').text();
            let price = parseFloat($('#servicePrice').val()) || 0;
            if(!serviceName || price === 0) return;

            serviceCounter++;
            let rowId = 'serviceRow_' + serviceCounter;

            $('#serviceList').append(`
                <tr id="${rowId}">
                    <td class="px-4 py-2">${serviceName}</td>
                    <td class="px-4 py-2 flex justify-between">
                        Rs. ${price.toFixed(2)}
                        <button type="button" onclick="removeService('${rowId}', ${price})" class="text-red-500 hover:text-red-700">
                            <i data-feather="x-circle"></i>
                        </button>
                    </td>
                </tr>
            `);

            total += price;
            $('#totalAmount').text(total.toFixed(2));
            calculateBalance();

            feather.replace();
            $('#service').val('').trigger('change');
            $('#servicePrice').val('');
        }

        function removeService(rowId, price) {
            $('#' + rowId).remove();
            total -= price;
            if (total < 0) total = 0;
            $('#totalAmount').text(total.toFixed(2));
            calculateBalance();
        }

        function calculateBalance() {
            let cashGiven = parseFloat($('#cashGiven').val()) || 0;
            let balance = cashGiven - total;
            $('#balanceAmount').text(balance.toFixed(2));
        }
        
        function submitPreview() { // unchanged
            let clientId = $('#client').val();
            if (!clientId) {
                alert('Please select a client first.');
                return;
            }
            $('#client_id_hidden').val(clientId);

            $('#servicesHiddenInputs').empty();
            $('#serviceList tr').each(function() {
                let serviceName = $(this).find('td:first').text().trim();
                let service = $('#service option').filter(function() {
                    return $(this).text().trim() === serviceName;
                });
                let serviceId = service.val();
                if (serviceId) {
                    $('#servicesHiddenInputs').append(
                        `<input type="hidden" name="services[]" value="${serviceId}">`
                    );
                }
            });

            $('#cashGivenHidden').val($('#cashGiven').val());

            // Submit to preview (or temporarily switched to download by the Download button)
            $('#previewForm').submit();
        }
    </script>
    <script>
    function buildHiddenInputs() {
        const clientId = $('#client').val();
        if (!clientId) { alert('Please select a client first.'); return false; }
        $('#client_id_hidden').val(clientId);

        const staffId = $('#staff').val();
        $('#staff_id_hidden').val(staffId || '');

        $('#servicesHiddenInputs').empty();
        $('#serviceList tr').each(function() {
        // If you keep matching by text:
        const serviceName = $(this).find('td:first').text().trim();
        const $opt = $('#service option').filter(function () {
            return $(this).text().trim() === serviceName;
        });
        const serviceId = $opt.val();
        if (serviceId) {
            $('#servicesHiddenInputs').append(
            `<input type="hidden" name="services[]" value="${serviceId}">`
            );
        }
        });

        $('#cashGivenHidden').val($('#cashGiven').val());
        return true;
    }

    async function downloadInvoice() {
        const f = document.getElementById('previewForm');
        if (!f) return;

        if (!buildHiddenInputs()) return;

        const printFlag = document.getElementById('printReceiptHidden');
        if (printFlag) printFlag.value = '1';

        const btn = document.querySelector('button[onclick="downloadInvoice()"]');
        if (btn) btn.disabled = true;

        // try AJAX-based download first
        try {
            const url = "{{ route('invoice.download') }}";
            const data = new FormData(f);
            const token = data.get('_token');

            const resp = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: data,
            });

            if (!resp.ok) throw new Error('HTTP status ' + resp.status);

            const ct = resp.headers.get('content-type') || '';
            if (!ct.includes('application/pdf')) throw new Error('non-PDF response');

            const disposition = resp.headers.get('content-disposition') || '';
            let filename = 'invoice.pdf';
            const m = disposition.match(/filename\*?=([^;]+)/);
            if (m) filename = m[1].replace(/"/g, '');

            const blob = await resp.blob();
            const blobUrl = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = blobUrl;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(blobUrl);

            // success, reset flag and button
            if (btn) btn.disabled = false;
            if (printFlag) printFlag.value = '0';
            return;
        } catch (ajaxError) {
            console.warn('AJAX download failed, falling back', ajaxError);
            // proceed to form submit fallback
        }

        // fallback: submit form to new tab/window so user can see errors
        const oldAction = f.action;
        const oldMethod = f.method;
        const oldTarget = f.getAttribute('target');

        f.action = "{{ route('invoice.download') }}";
        f.method = "POST";
        f.target = "_blank";
        if (!f.querySelector('input[name=_token]')) {
            const t = document.createElement('input');
            t.type = 'hidden'; t.name = '_token'; t.value = "{{ csrf_token() }}";
            f.appendChild(t);
        }
        f.submit();

        setTimeout(function () {
            if (printFlag) printFlag.value = '0';
            f.action = oldAction;
            f.method = oldMethod;
            if (oldTarget) {
                f.setAttribute('target', oldTarget);
            } else {
                f.removeAttribute('target');
            }
            if (btn) btn.disabled = false;
        }, 300);
    }

    // keep your original preview submit using the same builder
    function submitPreview() {
        if (!buildHiddenInputs()) return;
        $('#previewForm').submit();
    }

    // toggle 'Download PDF' button availability
    function updateDownloadState() {
        const clientSelected = $('#client').val();
        const hasService = $('#serviceList tr').length > 0;
        const btn = document.querySelector('button[onclick="downloadInvoice()"]');
        if (btn) btn.disabled = !(clientSelected && hasService);
    }

    $(document).ready(function() {
        $('#client').on('change', updateDownloadState);
        // also watch for rows being added/removed
        const target = document.getElementById('serviceList');
        if (target) {
            const observer = new MutationObserver(updateDownloadState);
            observer.observe(target, { childList: true });
        }
        updateDownloadState();
    });
    </script>

    @endsection
    </body>
    </html>
