<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Forms\Components;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Components::resolve('logo', \Filament\Forms\Components\Logo::class);
        // Register Filament components if needed


        // $this->registerPolicies();

        // Define a gate for super-admin
        Gate::define('isSuperAdmin', function ($user) {
            return $user->role_id === 1; // Assuming 1 is the ID for super-admin
        });

        // Define a gate for admin
        Gate::define('isAdmin', function ($user) {
            return $user->role_id === 2; // Assuming 2 is the ID for admin
        });

        DB::listen(function ($query) {
            logger($query->sql);
        });
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
