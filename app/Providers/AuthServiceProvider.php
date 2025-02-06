<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    // protected $policies = [
    //     User::class => UserPolicy::class,
    // ];
    /**
     * Register services.
     */
    public function register(): void
    {
        // dd(1);
        // if (!auth()->user()) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return route('login');
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // $this->registerPolicies();

        // Define a gate for super-admin
        Gate::define('isSuperAdmin', function ($user) {
            return $user->role_id === 1; // Assuming 1 is the ID for super-admin
        });

        // Define a gate for admin
        Gate::define('isAdmin', function ($user) {
            return $user->role_id === 2; // Assuming 2 is the ID for admin
        });

        // Define a gate for owner
        Gate::define('isOwner', function ($user) {
            return $user->role_id === 3; // Assuming 3 is the ID for owner
        });

        // Define a gate for tenant
        Gate::define('isTenant', function ($user) {
            return $user->role_id === 4; // Assuming 4 is the ID for tenant
        });

        // Define a gate for security guard
        Gate::define('isSecurityGuard', function ($user) {
            return $user->role_id === 5; // Assuming 5 is the ID for security guard
        });
    }
}
