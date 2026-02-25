<?php

namespace App\Http\Controllers;

use App\Mail\ReminderMail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Bill;
use Illuminate\Support\Facades\DB;



class ClientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $clients = Client::paginate(10);

            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $clients->items(),
                    'meta' => [
                        'current_page' => $clients->currentPage(),
                        'per_page'     => $clients->perPage(),
                        'total'        => $clients->total(),
                        'last_page'    => $clients->lastPage(),
                    ],
                ], 200);
            }

            return view('pages.client', compact('clients'));
        } catch (Exception $e) {
            Log::error('Error fetching clients: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to retrieve clients'], 500);
            }
            return redirect()->back()->with('error', 'Failed to retrieve clients. Please try again.');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'nullable|email|unique:clients,email',
            'contact'  => 'required',
            'address'  => 'required',
            'whatsapp' => 'required',
            'allergies'=> 'nullable',
        ]);

        try {
            $client = Client::create($request->all());

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Client created successfully.',
                    'data'    => $client,
                ], 201);
            }

            return redirect()->route('client')->with('success', 'Client created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating client: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to create client'], 500);
            }
            return redirect()->back()->with('error', 'Failed to create client. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email',
            'contact'  => 'required',
            'address'  => 'required|string|max:500',
            'whatsapp' => 'required',
            'allergies'=> 'nullable',
        ]);

        try {
            $client = Client::findOrFail($id);

            $client->name      = $request->name;
            $client->email     = $request->email;
            $client->contact   = $request->contact;
            $client->address   = $request->address;
            $client->whatsapp  = $request->whatsapp;
            $client->allergies = $request->allergies;
            $client->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Client updated successfully.',
                    'data'    => $client,
                ], 200);
            }

            return redirect()->back()->with('success', 'Client updated successfully!');
        } catch (Exception $e) {
            Log::error('Error updating client: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to update client'], 500);
            }
            return redirect()->back()->with('error', 'Failed to update client. Please try again.');
        }
    }

  public function delete(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        //  Delete all bookings related to this client
        Booking::where('client_id', $client->id)->delete();

        //  Delete client
        $client->delete();

        DB::commit();

        Log::info('Client and related bookings deleted', [
            'client_id' => $client->id,
            'client_name' => $client->name ?? null
        ]);

        return response()->json([
            'message' => 'Client and all related bookings deleted successfully.'
        ], 200);

    } catch (Exception $e) {
        DB::rollBack();

        Log::error('Error deleting client and bookings', [
            'client_id' => $id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Failed to delete client. Please try again.'
        ], 500);
    }
}

    public function profile(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);

            $history = Invoice::where('client_id', $id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'client'  => $client,
                    'history' => $history,
                ], 200);
            }

            return view('pages.client_profile', compact('client', 'history'));
        } catch (Exception $e) {
            Log::error('Error fetching client profile: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unable to fetch client profile'], 500);
            }
            return redirect()->back()->with('error', 'Unable to fetch client profile. Please try again.');
        }
    }

    public function search(Request $request)
    {
        try {
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;

                $clients = Client::where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('contact', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('whatsapp', 'LIKE', "%{$searchTerm}%")
                    ->paginate(10);

                if ($request->wantsJson()) {
                    return response()->json([
                        'data' => $clients->items(),
                        'meta' => [
                            'current_page' => $clients->currentPage(),
                            'per_page'     => $clients->perPage(),
                            'total'        => $clients->total(),
                            'last_page'    => $clients->lastPage(),
                        ],
                        'search' => $searchTerm,
                    ], 200);
                }

                return view('pages.client', compact('clients', 'searchTerm'));
            } else {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Search term is required'], 422);
                }
                return redirect()->route('client');
            }
        } catch (Exception $e) {
            Log::error('Error during client search: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unable to perform client search'], 500);
            }
            return redirect()->back()->with('error', 'Unable to perform client search. Please try again.');
        }
    }

    public function checkUser(Request $request)
    {
        try {
            $today = Carbon::now()->addDay()->format('Y-m-d');

            $invoiceDetails = InvoiceDetail::where('reminding_date', $today)
                ->with('invoice.client')
                ->get();

            $emails = [];
            $sent   = [];

            foreach ($invoiceDetails as $detail) {
                if ($detail->invoice && $detail->invoice->client) {
                    $clientEmail = $detail->invoice->client->email;
                    $clientName  = $detail->invoice->client->name;

                    $clientServices = $invoiceDetails->where('invoice.client.email', $clientEmail);

                    if ($clientEmail && !in_array($clientEmail, $emails)) {
                        $emails[] = $clientEmail;
                        Mail::to($clientEmail)->send(new ReminderMail($clientName, $clientServices));
                        $sent[] = $clientEmail;
                    }
                }
            }

            Log::info("Reminder emails sent.", ['count' => count($sent)]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message'        => 'Reminder emails processed.',
                    'emails_sent_to' => $sent,
                    'count'          => count($sent),
                    'date'           => $today,
                ], 200);
            }

            return redirect()->back()->with('success', 'Reminder emails sent successfully.');
        } catch (Exception $e) {
            Log::error('Error sending reminders: '.$e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to send reminders'], 500);
            }
            return redirect()->back()->with('error', 'Failed to send reminders. Please try again.');
        }
    }
}
