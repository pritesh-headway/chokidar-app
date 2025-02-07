<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        // dd((auth()->check() && auth()->user()->hasRole($role)));
        $userRoles = $user->roles->pluck('name')->toArray();

        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }
        return response()->json(['status' => false, 'message' => 'Forbidden'], 403);
    }
}
