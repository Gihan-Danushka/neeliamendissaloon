<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Booking;

class NotificationController extends Controller
{
    /**
     * Get notifications for today and tomorrow.
     * Admins see all; Users only see approved.
     */
    public function getNotifications()
{
    try {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        if ($user->role === 'admin') {
            // Admin → all notifications (today + tomorrow)
            $notifications = Notification::whereDate('created_at', $today)
                ->orWhereDate('created_at', $tomorrow)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // User → only approved booking notifications
            $notifications = Notification::where('user_id', $user->id)
                ->where(function ($q) use ($today, $tomorrow) {
                    $q->whereDate('created_at', $today)
                      ->orWhereDate('created_at', $tomorrow);
                })
                ->whereHas('booking', function ($q) {
                    $q->where('status', 'approved');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve notifications.',
            'error'   => $e->getMessage()
        ], 500);
    }
}

}
