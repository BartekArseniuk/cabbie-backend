<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpiry
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = $user->last_activity;

            \Log::info('User ' . $user->id . ' last activity: ' . $lastActivity);

            $sessionLifetime = config('session.lifetime');

            if ($lastActivity && now()->diffInMinutes($lastActivity) > $sessionLifetime) {
                Auth::logout();
                return response()->json(['message' => 'Session expired'], 401);
            }

            $user->update(['last_activity' => now()]);

            \Log::info('Updated last activity for user ' . $user->id . ' to ' . now());
        }

        return $next($request);
    }
}