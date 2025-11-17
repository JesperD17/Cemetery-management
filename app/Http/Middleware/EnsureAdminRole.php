<?php



    namespace App\Http\Middleware;
    
    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    
    class EnsureAdminRole
    {
        public function handle(Request $request, Closure $next)
        {
            // Alleen admin (role_id = 3) mag door
            if (Auth::check() && $request->user()->role_id === 3) {
                return $next($request);
            }
    
            // Geen admin → abort 403
            abort(403);
        }
    }
    