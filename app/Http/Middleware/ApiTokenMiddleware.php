<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken(); // get token from Authorization: Bearer <token>

        // 🔍 DEBUG LOG
    Log::info('API Token received', [
        'token' => $token,
        'has_token' => !empty($token),
        'headers' => $request->headers->all(),
    ]);
        if (!$token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = User::where('api_token', hash('sha256', $token))->first();
        log::info('User lookup result', ['user_found' => $user !== null]);

         // 🔍 DEBUG LOG
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        auth()->setUser($user); // log in the user for this request

        return $next($request);
    }
}
