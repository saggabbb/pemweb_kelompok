<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        // pastikan user punya relasi role
        if (!$user->role) {
            abort(403, 'Role not assigned');
        }

        if (!in_array($user->role->role_name, $roles)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
