<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = $this->getReportData();
            return view('pages.reports', $data);
        } catch (Exception $e) {
            Log::error('Report index error: ' . $e->getMessage());
            return redirect()->back()->with(['error' => 'Error loading reports: ' . $e->getMessage()]);
        }
    }

    public function download()
    {
        try {
            $data = $this->getReportData();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.reports', $data);
            return $pdf->download('salon-report-' . now()->format('Y-m-d') . '.pdf');
        } catch (Exception $e) {
            Log::error('Report download error: ' . $e->getMessage());
            return redirect()->back()->with(['error' => 'Error generating report PDF: ' . $e->getMessage()]);
        }
    }

    private function getReportData()
    {
        $today = Carbon::today();
        
        // ======================
        // 1. Sales Reports (Daily - Current Month)
        // ======================
        $startOfMonth = Carbon::today()->startOfMonth();

        $dailySales = Invoice::whereBetween('date', [$startOfMonth->toDateString(), $today->toDateString()])
            ->selectRaw('date, SUM(total_price) as total_price')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyDates  = $dailySales->pluck('date')->toArray();
        $dailyPrices = $dailySales->pluck('total_price')->map(fn ($v) => (float) $v)->toArray();

        // ======================
        // 2. Sales Reports (Monthly - Current Year)
        // ======================
        $startOfYear = Carbon::today()->startOfYear();
        $monthlySales = Invoice::whereBetween('date', [$startOfYear->toDateString(), $today->toDateString()])
            ->selectRaw("DATE_FORMAT(date, '%Y-%m') as month, SUM(total_price) as total_price")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = $monthlySales->pluck('month')->map(fn ($m) => Carbon::parse($m)->format('F'))->toArray();
        $monthlyPrices = $monthlySales->pluck('total_price')->map(fn ($v) => (float) $v)->toArray();

        // ======================
        // 3. Weekly Service Breakdown (Last 7 Days)
        // ======================
        $lastWeek = Carbon::today()->subDays(6);
        $weeklyServiceUsage = DB::table('service_bookings')
            ->join('services', 'services.id', '=', 'service_bookings.service_id')
            ->join('bookings', 'bookings.id', '=', 'service_bookings.booking_id')
            ->whereBetween('bookings.date', [$lastWeek->toDateString(), $today->toDateString()])
            ->select('services.name', DB::raw('COUNT(*) as total'))
            ->groupBy('services.name')
            ->orderByDesc('total')
            ->get();

        $weeklyServiceNames  = $weeklyServiceUsage->pluck('name')->toArray();
        $weeklyServiceCounts = $weeklyServiceUsage->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        // ======================
        // 4. Monthly Service Breakdown (Current Month)
        // ======================
        $monthlyServiceUsage = DB::table('service_bookings')
            ->join('services', 'services.id', '=', 'service_bookings.service_id')
            ->join('bookings', 'bookings.id', '=', 'service_bookings.booking_id')
            ->whereBetween('bookings.date', [$startOfMonth->toDateString(), $today->toDateString()])
            ->select('services.name', DB::raw('COUNT(*) as total'))
            ->groupBy('services.name')
            ->orderByDesc('total')
            ->get();

        $monthlyServiceNames  = $monthlyServiceUsage->pluck('name')->toArray();
        $monthlyServiceCounts = $monthlyServiceUsage->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        return compact(
            'today',
            'dailyDates', 'dailyPrices',
            'monthlyLabels', 'monthlyPrices',
            'weeklyServiceNames', 'weeklyServiceCounts',
            'monthlyServiceNames', 'monthlyServiceCounts'
        );
    }
}
