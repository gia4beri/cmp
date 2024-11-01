<?php

namespace App\Providers;

use App\Models\UserModel;
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
        Gate::define('isAdmin', function (UserModel $user) {
            return $user->role == 'admin';
        });

        Gate::define('isReception', function (UserModel $user) {
            return $user->role == 'reception';
        });

        Gate::define('isAdminOrReception', function (UserModel $user) {
            return $user->role == 'admin' || $user->role == 'reception';
        });

        Gate::define('isDoctor', function (UserModel $user) {
            return $user->role == 'doctor';
        });

        Gate::define('isAdminOrReceptionOrDoctor', function (UserModel $user) {
            return $user->role == 'admin' || $user->role == 'reception' || $user->role == 'doctor';
        });

        Gate::define('isUser', function (UserModel $user) {
            return $user->role == 'user';
        });
    }
}
