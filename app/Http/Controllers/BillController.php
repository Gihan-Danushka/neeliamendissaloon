<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\BillItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

// ESC/POS
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class BillController extends Controller
{
    public function download(Request $request)
    {
        try {
            Log::info('Download request data', $request->all());

            // Normalize optional fields
            if ($request->input('staff_id') === '') {
                $request->merge(['staff_id' => null]);
            }

            // ✅ Validate
            $data = $request->validate([
                'client_id'      => 'required|exists:clients,id',
                'staff_id'       => 'nullable|exists:staff,id',
                'services'       => 'required|array|min:1',
                'services.*'     => 'integer|exists:services,id',
                'cashGiven'      => 'nullable|numeric',
                'cash_given'     => 'nullable|numeric',
                'include_pdf'    => 'sometimes|boolean',
                'print_receipt'  => 'sometimes|boolean',
            ]);

            // 1) Inputs
            $clientId    = $data['client_id'];
            $staffId     = $data['staff_id'] ?? null;
            $serviceIds  = $data['services'];
            $cashGivenIn = $request->input('cashGiven', $request->input('cash_given'));

            // 2) Fetch data
            $client   = Client::findOrFail($clientId);
            $services = Service::whereIn('id', $serviceIds)->get();

            // 3) Totals
            $total     = $services->sum('price');
            $cashGiven = (float) ($cashGivenIn ?? 0);
            $balance   = $cashGiven - $total;

            // 4) Save invoice
            $invoice = Invoice::create([
                'client_id'   => $client->id,
                'staff_id'    => $staffId,
                'total_price' => $total,
                'cash_given'  => $cashGiven,
                'balance'     => $balance,
                'date'        => now(),
            ]);

            // 5) Save items
            foreach ($services as $service) {
                BillItem::create([
                    'invoice_id'   => $invoice->id,
                    'service_id'   => $service->id,
                    'service_name' => $service->name,
                    'price'        => $service->price,
                ]);
            }

            // 6) Prepare payload (for API users)
            $items = $services->map(fn($s) => [
                'id'    => $s->id,
                'name'  => $s->name,
                'price' => (float) $s->price,
            ])->toArray();

            $payload = [
                'invoice_id' => $invoice->id,
                'client'     => [
                    'id'    => $client->id,
                    'name'  => $client->name,
                    'email' => $client->email,
                ],
                'staff_id' => $invoice->staff_id,
                'items'   => $items,
                'total'   => (float) $total,
                'cash'    => (float) $cashGiven,
                'balance' => (float) $balance,
                'date'    => $invoice->date,
            ];

            // 7) JSON path
            if ($request->wantsJson()) {
                if ($request->boolean('include_pdf')) {
                    $pdf = Pdf::loadView('bill', [
                        'client'        => $client,
                        'services'      => $items,
                        'total'         => $total,
                        'cashGiven'     => $cashGiven,
                        'balance'       => $balance,
                        'invoiceNumber' => $invoice->id,
                    ]);

                    // 🔹 Explicit 80mm paper (226.77pt wide). Height large; Dompdf trims.
                    $pdf->setPaper([0, 0, 204.4, 595.3], 'portrait');


                    $payload['pdf'] = [
                        'filename' => 'invoice_' . $invoice->id . '.pdf',
                        'base64'   => base64_encode($pdf->output()),
                    ];
                }

                if ($request->boolean('print_receipt')) {
                    $this->printToPos($invoice, $client, $services, $total, $cashGiven, $balance);
                }

                return response()->json([
                    'message' => 'Invoice created successfully',
                    'data'    => $payload,
                ], 201);
            }

            // 8) Web: optionally print to POS, then download 80mm PDF
            if ($request->boolean('print_receipt')) {
                $this->printToPos($invoice, $client, $services, $total, $cashGiven, $balance);
            }

            $pdf = Pdf::loadView('bill', [
                'client'        => $client,
                'services'      => $items,
                'total'         => $total,
                'cashGiven'     => $cashGiven,
                'balance'       => $balance,
                'invoiceNumber' => $invoice->id,
            ]);

            // 🔹 IMPORTANT: do NOT force A4. Use 80mm.
            $pdf->setPaper([0, 0, 226.77, 1400], 'portrait');

            $filename = 'invoice_' . $invoice->id . '_' . now()->format('Ymd_His') . '.pdf';
            return $pdf->download($filename);

        } catch (ValidationException $ve) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $ve->errors()], 422);
            }
            return back()->withErrors($ve->errors());
        } catch (\Throwable $e) {
            Log::error('Bill download error: '.$e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to create invoice'], 500);
            }
            return back()->with('error', 'Failed to create invoice. Please try again.');
        }
    }

    /**
     * Print a compact receipt to the Windows ESC/POS printer (80mm).
     */
    private function printToPos(Invoice $invoice, Client $client, $services, float $total, float $cashGiven, float $balance): void
    {
        try {
            // ⬇ Adjust to your printer name in "Devices & Printers"
            $printerName = config('pos.name', 'XP-80C (copy 1)');      // e.g. "XP-80C" or "BELDON BNPP-99IU"
            $cols        = (int) config('pos.chars_per_line', 42); // 42 chars typical for 80mm

            $connector = new WindowsPrintConnector($printerName);
            $p = new Printer($connector);

            /* ---- Header ---- */
            $p->setJustification(Printer::JUSTIFY_CENTER);
            $p->setEmphasis(true);
            $p->text("Glory Luxe Beauty Studio\n");
            $p->setEmphasis(false);
            $p->text("144 Diulapitiya Road, Marandagahamula\n");
            $p->text("Tel: 070 422 3885\n");
            $p->text("Invoice #{$invoice->id}\n");
            $p->text(now()->format('Y-m-d H:i')."\n\n");

            /* ---- Client ---- */
            $p->setJustification(Printer::JUSTIFY_LEFT);
            $p->text("Client: {$client->name}\n");
            if (!empty($client->contact)) {
                $p->text("Phone : {$client->contact}\n");
            }
            $p->text(str_repeat('-', $cols)."\n");

            /* ---- Items (fixed name/price columns) ---- */
            $priceW = 12;                         // leaves room for "999,999.99"
            $nameW  = max(10, $cols - $priceW);   // remaining width for name

            foreach ($services as $s) {
                $name  = mb_strimwidth($s->name, 0, $nameW, '', 'UTF-8');
                $price = number_format((float)$s->price, 2);
                $p->text(str_pad($name, $nameW) . str_pad($price, $priceW, ' ', STR_PAD_LEFT) . "\n");
            }

            $p->text(str_repeat('-', $cols)."\n");

            /* ---- Totals ---- */
            $p->setEmphasis(true);
            $p->text(str_pad('Total',   $nameW) . str_pad(number_format($total, 2),    $priceW, ' ', STR_PAD_LEFT) . "\n");
            $p->setEmphasis(false);
            $p->text(str_pad('Cash',    $nameW) . str_pad(number_format($cashGiven, 2),$priceW, ' ', STR_PAD_LEFT) . "\n");
            $p->text(str_pad('Balance', $nameW) . str_pad(number_format($balance, 2),  $priceW, ' ', STR_PAD_LEFT) . "\n");

            /* ---- Footer ---- */
            $p->feed(2);
            $p->setJustification(Printer::JUSTIFY_CENTER);
            $p->text("Thank you!\n");
            $p->feed();
            $p->cut();
            // $p->pulse(); // open cash drawer if required
            $p->close();

        } catch (\Throwable $e) {
            Log::error("POS print failed: ".$e->getMessage());
            // do not throw; PDF flow should continue
        }
    }
}
