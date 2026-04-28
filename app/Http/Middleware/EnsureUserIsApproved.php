<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Allow admins always
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Allow the approval pending page and logout
        if ($request->routeIs('approval.pending') || $request->routeIs('logout')) {
            return $next($request);
        }

        if (!$user->approved) {
            return redirect()->route('approval.pending');
        }

        return $next($request);
    }
}
