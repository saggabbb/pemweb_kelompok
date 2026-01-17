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

        $user = auth()->user();

        if (!$user->role) {
            Auth::logout();
            abort(403, 'Role belum ditentukan');
        }

        // Debug: Log the actual role for debugging
        \Log::info('Login redirect debug', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'role_id' => $user->role_id,
            'role_name' => $user->role->role_name ?? 'null',
        ]);

        return match ($user->role->role_name) {
            'admin'   => redirect()->intended('/admin'),
            'seller'  => redirect()->intended('/seller'),
            'buyer'   => redirect()->intended('/buyer'),
            'courier' => redirect()->intended('/courier'),
            default   => abort(403, 'Role tidak dikenali: ' . $user->role->role_name),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
