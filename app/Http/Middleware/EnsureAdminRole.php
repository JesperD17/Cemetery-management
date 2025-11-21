<?php



    namespace App\Http\Middleware;
    
    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    
    class EnsureAdminRole
    {
        public function handle(Request $request, Closure $next)
        {
            $userRole = Auth::user()->role_id;
            $userRole = match ($userRole) {
                1 => 'rechthebbende',
                2 => 'beheerder',
                3 => 'admin',
                4 => 'super admin',
            };
            
            if ($userRole === 'admin' || $userRole === 'super admin' || $userRole === 'beheerder') {
                return $next($request);
            }
    
            // Geen admin → abort 403
            abort(403);
        }
    }
    