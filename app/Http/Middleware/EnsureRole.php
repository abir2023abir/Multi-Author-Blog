<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Debug logging
        \Log::info('EnsureRole middleware', [
            'user' => $user ? $user->email : 'null',
            'role' => $user ? $user->role : 'null',
            'required_role' => $role,
            'hasRole_method' => $user && method_exists($user, 'hasRole') ? $user->hasRole($role) : 'no_method',
            'spatie_roles' => $user ? $user->roles->pluck('name')->toArray() : []
        ]);

        if (!$user) {
            abort(403, 'No user authenticated');
        }

        // Check both Spatie roles and simple role field
        $hasRole = false;
        if (method_exists($user, 'hasRole')) {
            $hasRole = $user->hasRole($role);
        }
        if (!$hasRole && $user->role === $role) {
            $hasRole = true;
        }

        if (!$hasRole) {
            abort(403, "User {$user->email} with role {$user->role} does not have required role {$role}");
        }

        return $next($request);
    }
}


