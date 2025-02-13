<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::user());
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }

        // Check if the authenticated user is a super-admin
        if (Auth::user()->role_id !== 1) { // Assuming '1' is the role ID for super-admin
            return response()->json([
                'status' => false,
                'message' => 'Forbidden: Only Super Admins can access this resource'
            ], 403);
        }

        return $next($request);
    }
}
