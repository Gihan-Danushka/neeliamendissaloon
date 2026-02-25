<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HistoryController extends Controller
{
    public function index_view(Request $request)
    {
        try {
            $clients  = Client::all();
            $services = Service::all();
            $invoices = Invoice::orderBy('date', 'desc')->paginate(10);

            if ($request->wantsJson()) {
                return response()->json([
                    'clients'  => $clients,
                    'services' => $services,
                    'invoices' => [
                        'data' => $invoices->items(),
                        'meta' => [
                            'current_page' => $invoices->currentPage(),
                            'per_page'     => $invoices->perPage(),
                            'total'        => $invoices->total(),
                            'last_page'    => $invoices->lastPage(),
                        ],
                    ],
                ], 200);
            }

            return view('pages.history', compact('clients', 'services', 'invoices'));
        } catch (Exception $e) {
            Log::error('History index error: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to load history'], 500);
            }

            return redirect()->back()->with([
                'error' => 'Error loading history: ' . $e->getMessage(),
            ]);
        }
    }

    public function search(Request $request)
    {
        try {
            $clients  = Client::all();
            $services = Service::all();

            $contact  = $request->contact;
            $clientId = $request->clientId;
            $month    = $request->month;
            $day      = $request->day;
            $service  = $request->service;

            $invoicesQuery = Invoice::orderBy('date', 'desc');

            // Filter by client contact
            if ($request->filled('clientId') && $request->filled('contact')) {
                $invoicesQuery->whereHas('client', function ($query) use ($request) {
                    $query->where('contact', $request->contact);
                });
            }

            // Filter by month/year
            if ($request->filled('month')) {
                $dateParts = explode('-', $request->month);
                if (count($dateParts) == 2) {
                    $year  = $dateParts[0];
                    $month = $dateParts[1];
                    $invoicesQuery->whereYear('date', $year)
                                  ->whereMonth('date', $month);
                }
            }

            // Filter by day
            if ($request->filled('day')) {
                $invoicesQuery->whereDay('date', $request->day);
            }

            // Filter by service name
            if ($request->filled('service')) {
                $invoicesQuery->whereHas('details', function ($query) use ($request) {
                    $query->where('name', $request->service);
                });
            }

            $invoices = $invoicesQuery->paginate(10);

            if ($request->wantsJson()) {
                return response()->json([
                    'filters' => [
                        'contact'  => $contact,
                        'clientId' => $clientId,
                        'month'    => $month,
                        'day'      => $day,
                        'service'  => $service,
                    ],
                    'clients'  => $clients,
                    'services' => $services,
                    'invoices' => [
                        'data' => $invoices->items(),
                        'meta' => [
                            'current_page' => $invoices->currentPage(),
                            'per_page'     => $invoices->perPage(),
                            'total'        => $invoices->total(),
                            'last_page'    => $invoices->lastPage(),
                        ],
                    ],
                ], 200);
            }

            return view('pages.history', compact('clients', 'services', 'invoices', 'contact', 'clientId', 'month', 'day', 'service'));
        } catch (Exception $e) {
            Log::error('History search error: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to search history'], 500);
            }

            return redirect()->back()->with([
                'error' => 'Error creating invoice: ' . $e->getMessage(),
            ]);
        }
    }
}
