<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminDepartment
{
    /**
     * Ensure admin can only access their own department.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Only apply to admin role
        if ($user->role !== 'admin') {
            return $next($request);
        }

        // If request has dept param, ensure it matches admin's department
        $dept = $request->query('dept') ?? $request->route('dept') ?? null;
        if ($dept && $user->id_departemen && (int)$dept !== (int)$user->id_departemen) {
            abort(403, 'Akses departemen lain tidak diperbolehkan.');
        }

        // For admin dashboard, if no dept param provided, inject admin's department as query
        if ($request->routeIs('admin.dashboard') && !$dept && $user->id_departemen) {
            // Build URL with dept param and redirect
            $url = route('admin.dashboard', ['dept' => $user->id_departemen]);
            return redirect()->to($url);
        }

        return $next($request);
    }
}
