<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = \App\Models\Role::whereIn('role_name', ['buyer', 'seller', 'courier'])->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        // Determine initial balance based on role
        $role = \App\Models\Role::find($request->role_id);
        $initialBalance = match($role->role_name) {
            'buyer' => 5000000,   // Rp 5 juta
            'seller' => 2000000,  // Rp 2 juta
            'courier' => 500000,  // Rp 500 ribu
            default => 0,
        };

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'address' => $request->address,
            'balance' => $initialBalance,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return match ($user->role->role_name) {
            'admin'   => redirect()->intended('/admin'),
            'seller'  => redirect()->intended('/seller'),
            'buyer'   => redirect()->intended('/buyer'),
            'courier' => redirect()->intended('/courier'),
            default   => redirect('/dashboard'),
        };
    }
}
