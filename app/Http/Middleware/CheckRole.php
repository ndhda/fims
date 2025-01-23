<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Ensure that the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Access user management and role
        $user = Auth::user();

        if (!$user->role || $user->role->role_id != $roles) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
