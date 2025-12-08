<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureNotRightHolder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = Auth::user()->role_id;
        $userRole = match ($userRole) {
            1 => 'rechthebbende',
            2 => 'beheerder',
            3 => 'admin',
            4 => 'super admin',
        };
        
        if ($userRole !== 'rechthebbende') {
            return $next($request);
        }

        // Geen admin → abort 403
        abort(403);
    }
}
