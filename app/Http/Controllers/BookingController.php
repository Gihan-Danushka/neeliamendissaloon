<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Mail\BookingReminderEmail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Ensure the user is authenticated
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            // Validate request
            $request->validate([
                'date'       => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'total_price'=> 'required',
                'staff_id'   => 'nullable|exists:staff,id',
                'services'   => 'required|array',
                'status'     => 'required|in:pending,rejected,approved,completed'
            ]);

            // Calculate times
            $startTime = Carbon::createFromFormat('H:i:s', $request->input('start_time'));
            $endTime   = $startTime->copy()->addSeconds(0)->format('H:i:s');

            //  Create booking only once
            $booking = Booking::create([
                'user_id'     => $user->id,
                'date'        => $request->input('date'),
                'total_price' => $request->input('total_price'),
                'start_time'  => $startTime->format('H:i:s'),
                'end_time'    => $endTime,
                'staff_id'    => $request->input('staff_id'),
                'status'      => $request->input('status')
            ]);

            //  Save services into pivot table
            foreach ($request->input('services') as $serviceId) {
                DB::table('service_bookings')->insert([
                    'booking_id' => $booking->id,
                    'service_id' => $serviceId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            //  Notification/Email (same condition)
            $bookingDate = Carbon::parse($booking->date);

            if ($bookingDate->isToday() || $bookingDate->isTomorrow()) {
                // Store notification
                Notification::create([
                    'user_id'    => $user->id,
                    'booking_id' => $booking->id,
                    'message'    => "You have a booking for " . $bookingDate->toFormattedDateString() . " for your service(s) " . $booking->services->pluck('name')->implode(', ') . ".",
                ]);

                 // Send email only if today/tomorrow AND approved
            if (($bookingDate->isToday() || $bookingDate->isTomorrow()) && $booking->status === 'approved') {
                Mail::to($user->email)->send(new BookingReminderEmail($booking));
            }
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully.',
                'data'    => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    

// Show form
public function webCreate()
{
    $services = Service::all();

    $todayDate = Carbon::today()->toDateString();

    //Today's all bookings (schedule)
    $appointments  = Booking::with(['client', 'user', 'staff', 'services'])
        ->whereDate('date', '>=', $todayDate)   // ✅ today + future
        ->orderBy('date')                      // sort by date first
        ->orderBy('start_time')                // then by time
        ->get();

    //Today's pending only
    $pendingAppointments = Booking::with(['client', 'user', 'staff', 'services'])
        ->whereDate('date', '>=', $todayDate) 
        ->where('status', 'pending')
        ->orderBy('date')
        ->orderBy('start_time')
        ->get();


    //Today's approved (optional)
    $approvedAppointments = $appointments->where('status', 'approved')->values();

    return view('bookings.create', compact(
        'services',
        'appointments',
        'pendingAppointments',
        'approvedAppointments'
    ));
}


 // Approve appointment
    public function approveAppointment($id)
    {
        try {
            $appointment = Booking::findOrFail($id);
            $appointment->status = 'approved';
            $appointment->save();

            return redirect()->back()->with('success', 'Appointment approved successfully!');
        } catch (Exception $e) {
            Log::error("Approve appointment error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve appointment.');
        }
    }

    //Cancel appointment (use rejected to match your statuses)
    public function cancelAppointment($id)
    {
        try {
            $appointment = Booking::findOrFail($id);
            $appointment->status = 'rejected';
            $appointment->save();

            return redirect()->back()->with('success', 'Appointment rejected successfully!');
        } catch (Exception $e) {
            Log::error("Cancel appointment error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to cancel appointment.');
        }
    }


// Store booking from web form
public function webStore(Request $request)
{
    $request->validate([
        'full_name'    => 'required|string|max:255',
        'email'        => 'nullable|email|max:255',
        'phone'        => 'required|string|max:20',
        'address'      => 'nullable|string|max:255',
        'whatsapp'     => 'nullable|string|max:20',
        'allergies'    => 'nullable|string|max:255',
        'service_id'   => 'required|array',
        'service_id.*' => 'exists:services,id',
        'date'         => 'required|date',
        'start_time'   => 'required',
        'message'      => 'nullable|string'
    ]);

    // Find or create client (best: by contact)
    $clientQuery = Client::query()->where('name', $request->full_name);

    // if name not found and email exists, try email
    if (!$clientQuery->exists() && $request->filled('email')) {
        $clientQuery = Client::query()->where('email', $request->email);
    }

    $client = $clientQuery->first();

    if (!$client) {
        $client = Client::create([
            'name'      => $request->full_name,
            'email'     => $request->email,
            'contact'   => $request->phone,
            'address'   => $request->address,
            'whatsapp'  => $request->whatsapp ?? $request->phone,
            'allergies' => $request->allergies,
        ]);
        Log::info('Booking created successfully');
    } else {
        // optional: keep client updated
        $client->update([
            'name'      => $request->full_name,
            'email'     => $request->email ?? $client->email,
            'address'   => $request->address ?? $client->address,
            'whatsapp'  => $request->whatsapp ?? $client->whatsapp,
            'allergies' => $request->allergies ?? $client->allergies,
        ]);
        Log::info('Booking updated successfully');

    }

    // Calculate total price from multiple services
    $services = Service::whereIn('id', $request->service_id)->get();
    $totalPrice = $services->sum('price');

    //Create booking with BOTH user_id + client_id
    $booking = Booking::create([
        'user_id'     => Auth::id(),          // logged user (admin or customer)
        'client_id'   => $client->id,         // client table id
        'date'        => $request->date,
        'start_time'  => $request->start_time,
        'end_time'    => $request->start_time, // if you calculate duration later, update this
        'status'      => 'approved',
        'total_price' => $totalPrice,
        'staff_id'    => null,
    ]);

    //Attach services
    $booking->services()->attach($request->service_id);

    return redirect()->back()->with('success', ' Successfully created your booking!');
}


    public function index()
        {
            try {
               $booking = Booking::with(['services', 'user', 'staff', 'client'])->get();

                return response()->json([
                    'booking' => $booking
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error'   => 'Failed to retrieve bookings.',
                    'message' => $e->getMessage()
                ], 500);
            }
        }


    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            $booking = Booking::where('id', $id)->first();
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found.'
                ], 404);
            }

            $request->validate([
                'date'       => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'status'     => 'nullable|in:pending,rejected,approved,completed',
                'services'   => 'required|array',
                'staff_id'   => 'nullable|exists:staff,id'
            ]);

            $startTime = Carbon::createFromFormat('H:i:s', $request->input('start_time'));
            $endTime   = $startTime->copy()->addSeconds(0)->format('H:i:s');

            $booking->update([
                'date'       => $request->input('date'),
                'start_time' => $startTime->format('H:i:s'),
                'end_time'   => $endTime,
                'staff_id'   => $request->input('staff_id'),
            ]);

            if ($user->role === 'admin' && $request->has('status')) {
                $booking->status = $request->input('status');
                $booking->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully.',
                'data'    => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update booking.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
{
    try {
        $booking = Booking::with('services', 'user', 'staff')->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve booking.',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    public function destroy($id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            $booking = Booking::where('id', $id)->where('user_id', $user->id)->first();
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found or does not belong to the user.'
                ], 404);
            }

            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete booking.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function getBookingCounts()
    {
        try {
            $counts = Booking::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            return response()->json([
                'success' => true,
                'data'    => [
                    'rejected'  => $counts['rejected'] ?? 0,
                    'approved'  => $counts['approved'] ?? 0,
                    'completed' => $counts['completed'] ?? 0,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve booking counts.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
