<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            \URL::forceScheme('https');
        }

        Gate::define('admin', function () {
            return Auth::user()->user_privilege == 'Admin';
        });

        Gate::define('support', function () {
            if (in_array(Auth::user()->user_privilege, ['Admin', 'Support'])) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('viewer', function () {
            if (in_array(Auth::user()->user_privilege, ['Admin', 'Support', 'Viewer'])) {
                return true;
            } else {
                return false;
            }
        });
    }
}
