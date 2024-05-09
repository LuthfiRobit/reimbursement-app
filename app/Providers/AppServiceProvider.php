<?php

namespace App\Providers;

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
        Gate::define('direktur-role', function ($user) {
            return User::where([['id_user', $user->id_user], ['jabatan', 'DIREKTUR']])->first();
        });

        Gate::define('finance-role', function ($user) {
            return User::where([['id_user', $user->id_user], ['jabatan', 'FINANCE']])->first();
        });

        Gate::define('staff-role', function ($user) {
            return User::where([['id_user', $user->id_user], ['jabatan', 'STAFF']])->first();
        });
    }
}
