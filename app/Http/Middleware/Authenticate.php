<?php

// namespace App\Http\Middleware;

// use Closure;
// use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Contracts\Providers\Auth;
// use Illuminate\Auth\AuthenticationException;

// class Authenticate
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @param  string|null  $guard
//      * @return mixed
//      */
//     public function handle($request, Closure $next, ...$guards)
//     {
//         if (Auth::guard('api')->guest()) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         return $next($request);
//     }
// }

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // app/Http/Middleware/Authenticate.php

    // public function handle($request, Closure $next, ...$guards)
    // {
    //     // Modify the behavior when the user is not authenticated
    //     if (JWTAuth::parseToken()->authenticate()) {
    //         return $next($request);
    //     }

    //     // Return unauthorized if not authenticated
    //     return response()->json(['error' => 'Unauthorized'], 401);
    // }

    // app/Http/Middleware/Authenticate.php

    public function handle($request, Closure $next, ...$guards)
    {
        // If the user is not authenticated using JWT
        if (!auth()->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
