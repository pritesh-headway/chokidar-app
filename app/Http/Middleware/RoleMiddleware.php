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

        // Check if the user is authenticated
        $user = auth()->user();

        $userRoles = $user->roles->pluck('name')->toArray();

        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);  // Allow access if a matching role is found
            }
        }

        // If no matching role is found, return a 403 Unauthorized response
        return response()->json(['status' => false, 'message' => 'Forbidden'], 403);
    }
}
