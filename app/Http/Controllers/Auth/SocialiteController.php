<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Cari user berdasarkan social_id atau email
            $user = User::where('social_id', $socialUser->getId())
                        ->orWhere('email', $socialUser->getEmail())
                        ->first();

            if ($user) {
                // Jika user ada, update social_id jika belum ada (misal login email sama tapi blm link sosmed)
                if (!$user->social_id) {
                    $user->update([
                        'social_id'   => $socialUser->getId(),
                        'social_type' => $provider
                    ]);
                }
                
                Auth::login($user);
                
                return redirect()->intended('/dashboard'); // Ganti redirect sesuai role nanti
            } else {
                // Jika user belum ada, buat baru sebagai BUYER defaultnya
                // Cari Role ID untuk buyer
                $roleBuyer = Role::where('role_name', 'buyer')->first();
                $roleId = $roleBuyer ? $roleBuyer->id : 2; // Default ID 2 if not found (Assumption)

                $newUser = User::create([
                    'name'        => $socialUser->getName(),
                    'email'       => $socialUser->getEmail(),
                    'social_id'   => $socialUser->getId(),
                    'social_type' => $provider,
                    'role_id'     => $roleId,
                    'password'    => Hash::make(Str::random(16)), // Random password
                ]);

                Auth::login($newUser);

                return redirect()->intended('/buyer');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Failed: ' . $e->getMessage());
        }
    }
}
