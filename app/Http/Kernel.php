<?php

namespace App\Http;

use App\Http\Middleware\WebMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // Add middleware you need globally here
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Http\Middleware\HandleCors::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\WebMiddleware::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // 'auth.jwt' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        // 'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        // 'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        // 'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        // 'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        // 'role' => \App\Http\Middleware\RoleMiddleware::class,
        // 'route' => \App\Http\Middleware\RoleMiddleware::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'auth.api' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        'auth.web' => \Illuminate\Auth\Middleware\Authenticate::class,
        'web' => \App\Http\Middleware\WebMiddleware::class,


    ];
}
