<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if the user's role is one of the allowed roles
            if (!in_array($user->role, $roles)) {
                return redirect('/dashboard');
            }
            
            return $next($request);
        }
        
        return redirect()->route('login');
    }
    
}
