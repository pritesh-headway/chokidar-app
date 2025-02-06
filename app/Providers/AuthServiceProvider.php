<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Gate::define('isSuperAdmin', function ($user) {
            return $user->role_id === 1;
        });
        Gate::define('isAdmin', function ($user) {
            return $user->role_id === 2;
        });
        Gate::define('isOwner', function ($user) {
            return $user->role_id === 3;
        });
        Gate::define('isTenant', function ($user) {
            return $user->role_id === 4;
        });
        Gate::define('isSecurityGuard', function ($user) {
            return $user->role_id === 5;
        });
    }
}
