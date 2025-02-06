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
        Gate::define('isSuperAdmin', function ($user) {
            return $user->role_id === 1;
        });
        Gate::define('isAdmin', function ($user) {
            return $user->role_id === 2;
        });

        DB::listen(function ($query) {
            logger($query->sql);
        });
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
