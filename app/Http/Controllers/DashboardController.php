<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            // ======================
            // Counts
            // ======================
            $userCount    = Client::count();
            $ServiceCount = Service::count();

            // ======================
            // Today / Yesterday
            // ======================
            $todayStr     = now()->toDateString();
            $yesterdayStr = now()->subDay()->toDateString();

            $remindingCount = InvoiceDetail::where('reminding_date', $todayStr)->count();
            $yesterdayTotal = (float) Invoice::where('date', $yesterdayStr)->sum('total_price');

            // ======================
            // Reminders (existing table)
            // ======================
            $reminding = InvoiceDetail::where('reminding_date', $todayStr)
                ->with('invoice.client')
                ->paginate(10);

            // ======================
            // Chart 1: Last 7 days revenue
            // ======================
            $today    = Carbon::today();
            $lastWeek = Carbon::today()->subDays(6); // 7 days including today

            $summary = Invoice::whereBetween('date', [$lastWeek->toDateString(), $today->toDateString()])
                ->selectRaw('date, SUM(total_price) as total_price')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $dates  = $summary->pluck('date')->toArray();
            $prices = $summary->pluck('total_price')->map(fn ($v) => (float) $v)->toArray();

            // ======================
            // Chart 2: Service distribution (FIXED using service_bookings)
            // ======================
            $serviceUsage = DB::table('service_bookings')
                ->join('services', 'services.id', '=', 'service_bookings.service_id')
                ->select('services.name', DB::raw('COUNT(*) as total'))
                ->groupBy('services.name')
                ->orderByDesc('total')
                ->limit(6)
                ->get();

            $names  = $serviceUsage->pluck('name')->toArray();
            $counts = $serviceUsage->pluck('total')->map(fn ($v) => (int) $v)->toArray();

            // ======================
            // Bookings (Today schedule + pending)
            // ======================
            $todayDate = Carbon::today()->toDateString();

            $todaysAppointments = Booking::with(['client', 'user', 'staff', 'services'])
                ->whereDate('date', $todayDate)
                ->orderBy('start_time')
                ->get();

            $pendingAppointments = Booking::with(['client', 'user'])
                ->whereDate('date', $todayDate)
                ->where('status', 'pending')
                ->orderBy('start_time')
                ->get();

            $approvedAppointments = $todaysAppointments->where('status', 'approved')->values();

            // ✅ Optional debug log
            Log::info('Dashboard loaded', [
                'today' => $todayDate,
                'today_count' => $todaysAppointments->count(),
                'pending_count' => $pendingAppointments->count(),
            ]);

            if ($request->wantsJson()) {
                return response()->json(compact(
                    'userCount', 'ServiceCount', 'remindingCount', 'yesterdayTotal',
                    'dates', 'prices', 'names', 'counts',
                    'todaysAppointments', 'pendingAppointments', 'approvedAppointments'
                ));
            }

            return view('pages.dashboard', compact(
                'userCount',
                'ServiceCount',
                'remindingCount',
                'yesterdayTotal',
                'reminding',
                'dates',
                'prices',
                'names',
                'counts',
                'todaysAppointments',
                'pendingAppointments',
                'approvedAppointments'
            ));
        } catch (Exception $e) {
            Log::error('Dashboard index error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to load dashboard'], 500);
            }

            return redirect()->back()->with(['error' => 'Error loading dashboard: ' . $e->getMessage()]);
        }
    }

    public function service(Request $request)
    {
        try {
            $categories = Category::withCount('services')->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'categories' => $categories,
                ], 200);
            }

            return view('pages.service', compact('categories'));
        } catch (Exception $e) {
            Log::error('Dashboard service error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to load services'], 500);
            }

            return redirect()->back()->with(['error' => 'Error loading services: ' . $e->getMessage()]);
        }
    }

    public function download(Request $request)
    {
        try {
            $request->validate([
                'category'   => 'nullable|array',
                'category.*' => 'integer|exists:categories,id',
                'include_pdf'=> 'sometimes|boolean',
            ]);

            $ids = $request->get('category');
            $categoryData = [];

            if (is_array($ids) && count($ids)) {
                $categoryData = Category::with('services')
                    ->whereIn('id', $ids)
                    ->get()
                    ->values();
            } else {
                $categoryData = Category::with('services')->get()->values();
            }

            if ($request->wantsJson()) {
                $payload = [
                    'categories' => $categoryData,
                ];

                if ($request->boolean('include_pdf')) {
                    $pdf = Pdf::loadView('pdf.service-list', ['categories' => $categoryData]);
                    $payload['pdf'] = [
                        'filename' => 'service-list.pdf',
                        'base64'   => base64_encode($pdf->output()),
                    ];
                }

                return response()->json($payload, 200);
            }

            $pdf = Pdf::loadView('pdf.service-list', ['categories' => $categoryData]);
            return $pdf->download('service-list.pdf');

        } catch (Exception $e) {
            Log::error('Dashboard download error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to generate service list'], 500);
            }

            return redirect()->back()->with(['error' => 'Failed to generate service list: ' . $e->getMessage()]);
        }
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

    // Cancel appointment (use rejected to match your statuses)
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

    //Reminder button handler
    public function sendReminder($id)
    {
        try {
            $booking = Booking::with(['user', 'services'])->findOrFail($id);
             Log::error('Error fetching clients: '.$booking);

            // Prevent duplicate reminder for same booking + same date
            $already = Notification::where('booking_id', $booking->id)
                ->whereDate('created_at', $booking->date)
                ->exists();

            /* if ($already) {
                return back()->with('error', 'Reminder already sent for this appointment.');
            } */

            $serviceNames = $booking->services->pluck('name')->implode(', ');
            $clientName = trim(($booking->user?->first_name ?? '') . ' ' . ($booking->user?->last_name ?? ''));

            $message = "Reminder: Appointment for {$clientName} at {$booking->start_time}-{$booking->end_time}"
                . ($serviceNames ? " | Services: {$serviceNames}" : "");

            Notification::create([
                'booking_id'  => $booking->id,
                'user_id'     => $booking->user_id,
                'message'     => $message,
            ]);

            return back()->with('success', 'Reminder saved successfully!');
        } catch (Exception $e) {
            Log::error("Send reminder error: " . $e->getMessage());
            return back()->with('error', 'Failed to save reminder.');
        }
    }
}
