<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Staff;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Mail\InvoiceMail;
use Exception;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
            $clients = Client::all();
            $services = Service::all();
            $staffMembers = Staff::orderBy('name')->get();
            $selectedClient = Client::findOrFail($id);

            if ($request->wantsJson()) {
                return response()->json([
                    'clients'        => $clients,
                    'selectedClient' => $selectedClient,
                    'services'       => $services,
                    'staffMembers'   => $staffMembers,
                ], 200);
            }

            return view('pages.invoice', compact('clients', 'selectedClient', 'services', 'staffMembers'));
        } catch (Exception $e) {
            Log::error('Error fetching invoice index: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to load invoice page'], 500);
            }

            return redirect()->back()->with('error', 'Failed to retrieve clients. Please try again.');
        }
    }

    public function index_view(Request $request)
    {
        try {
            $clients = Client::all();
            $services = Service::all();
            $staffMembers = Staff::orderBy('name')->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'clients'  => $clients,
                    'services' => $services,
                    'staffMembers' => $staffMembers,
                ], 200);
            }

            return view('pages.invoice', compact('clients', 'services', 'staffMembers'));
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to load invoice view'], 500);
            }
            return redirect()->back()->with([
                'error' => 'Error creating invoice: ' . $e->getMessage(),
            ]);
        }
    }

    public function get_service(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);

            return response()->json(['service' => $service], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'total'            => 'required|numeric',
                'date'             => 'required|date',
                'selectedClientId' => 'required|exists:clients,id',
            ]);

            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator);
            }

            // Create invoice
            $invoice = Invoice::create([
                'date'        => $request->date,
                'total_price' => $request->total,
                'client_id'   => $request->selectedClientId,
            ]);

            // Prepare details
            $invoiceDetails = [];
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^serviceName_(\d+)$/', $key, $matches)) {
                    $index = $matches[1];
                    if (!empty($request->{"servicePrice_$index"})) {
                        $invoiceDetails[] = [
                            'name'           => $value,
                            'price'          => $request->{"servicePrice_$index"},
                            'color'          => $request->{"serviceColor_$index"} ?? null,
                            'colorCode'      => $request->{"serviceColorCode_$index"} ?? null,
                            'percentage'     => $request->{"servicePercentage_$index"} ?? null,
                            'reminding_date' => $request->{"serviceRemindingDate_$index"} ?? null,
                            'invoice_id'     => $invoice->id,
                        ];
                    }
                }
            }

            // Validate service details
            foreach ($invoiceDetails as $detail) {
                $detailValidator = Validator::make($detail, [
                    'name'  => 'required|string',
                    'price' => 'required|numeric',
                ]);
                if ($detailValidator->fails()) {
                    if ($request->wantsJson()) {
                        return response()->json(['errors' => $detailValidator->errors()], 422);
                    }
                    return redirect()->back()->withErrors($detailValidator);
                }
            }

            // Save details
            InvoiceDetail::insert($invoiceDetails);

            // Send email with PDF
            $this->sendPDF($request->selectedClientId);

            $client = Client::findOrFail($request->selectedClientId);
            $invoiceDetailsData = InvoiceDetail::where('invoice_id', $invoice->id)->get();

            $data = [
                'client'         => $client,
                'total'          => $invoice->total_price,
                'date'           => now()->format('Y-m-d'),
                'invoiceDetails' => $invoiceDetailsData,
            ];

            // Generate PDF
            $pdf      = PDF::loadView('pdf.client-services', $data);
            $pdfBase64 = base64_encode($pdf->output());

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Invoice created successfully!',
                    'invoice' => $invoice,
                    'details' => $invoiceDetailsData,
                    'pdf'     => [
                        'filename' => 'invoice_'.$invoice->id.'.pdf',
                        'base64'   => $pdfBase64,
                    ],
                ], 201);
            }

            return redirect()->back()->with([
                'success'  => 'Invoice created successfully!',
                'pdf_data' => $pdfBase64,
            ]);
        } catch (Exception $e) {
            Log::error('Invoice store error: '.$e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error creating invoice: '.$e->getMessage()], 500);
            }
            return redirect()->back()->with([
                'error' => 'Error creating invoice: ' . $e->getMessage(),
            ]);
        }
    }

    private function sendPDF($clientId)
    {
        $client  = Client::findOrFail($clientId);
        $invoice = Invoice::where('client_id', $clientId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$invoice) {
            return false;
        }

        $invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();

        $data = [
            'client'         => $client,
            'total'          => $invoice->total_price,
            'date'           => now()->format('Y-m-d'),
            'invoiceDetails' => $invoiceDetails,
        ];

        $pdf = PDF::loadView('pdf.client-services', $data);
        Mail::to($client->email)->send(new InvoiceMail($data, $pdf));

        return true;
    }
}
