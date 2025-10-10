<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // Not logged in
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Role doesn't match
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
