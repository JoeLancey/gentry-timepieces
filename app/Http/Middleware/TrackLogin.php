<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class TrackLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Track login if user just authenticated (not already logged in)
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if this is a new login session (no last_login_at or it's old)
            if (!$user->last_login_at || $user->last_login_at->diffInMinutes(now()) > 30) {
                $user->update(['last_login_at' => now()]);
                
                // Log the login activity
                ActivityLog::log(
                    'login',
                    'User',
                    $user->id,
                    null,
                    "User logged in from {$request->ip()}"
                );
            }
        }

        return $response;
    }
}
