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
            return redirect('/login');
        }

        // Allow super_admin to bypass role checks (full access)
        $userRole = Auth::user()->role;
        if ($userRole !== $role && $userRole !== 'super_admin') {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
