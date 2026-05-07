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
        if (auth()->check()) {
            $user = auth()->user();

            $user->forceFill(['last_seen_at' => now()])->save();

            $sessionKey = 'login_logged_for_user_' . $user->id;

            if (!session()->has($sessionKey)) {
                $user->forceFill(['last_login_at' => now()])->save();

                ActivityLog::log(
                    'login',
                    'User',
                    $user->id,
                    null,
                    "User logged in from {$request->ip()}"
                );

                session()->put($sessionKey, true);
            }
        }

        return $next($request);
    }
}
