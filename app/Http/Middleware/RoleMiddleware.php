<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        // dd(auth()->user()->roles);
        // Get the roles of the logged-in user
        $userRoles = $user->roles->pluck('name')->toArray();
        // dd($userRoles);
        // dd($roles);
        // dd(auth()->user()->id);
        // Check if the user has at least one of the specified roles
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);  // Allow access if a matching role is found
            }
        }

        // If no matching role is found, return a 403 Unauthorized response
        return response()->json(['status' => false, 'message' => 'Forbidden'], 403);
    }
}
