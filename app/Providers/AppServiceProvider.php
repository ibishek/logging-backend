<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Macros\ResponseMacro;
use App\Models\SiteAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::before(function (SiteAdmin|User $user, $ability) {
            if ($user instanceof User) {
                return null;
            }

            return $user->hasRole(UserRole::APP_ADMIN->value) ? true : null;
        });

        ResponseMacro::macros();
    }
}
