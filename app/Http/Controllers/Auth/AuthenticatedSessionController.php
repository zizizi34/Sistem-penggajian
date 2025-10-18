<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // For super admin we force their dashboard even if there is an intended URL.
        if ($user->role === 'super_admin') {
            $request->session()->forget('url.intended');
            return redirect()->route('super.dashboard');
        }

        // For admin: force them to admin dashboard and, if they have an assigned department, include it
        if ($user->role === 'admin') {
            $request->session()->forget('url.intended');
            $dept = $user->id_departemen ?? null;
            $url = route('admin.dashboard');
            if ($dept) {
                $url = route('admin.dashboard', ['dept' => $dept]);
            }
            return redirect()->to($url);
        }

        // Default for regular users: respect intended URL if present
        return redirect()->intended(route('user.dashboard'));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
