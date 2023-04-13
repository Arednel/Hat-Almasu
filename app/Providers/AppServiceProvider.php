<?php

namespace App\Providers;

use App\Models\User;
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

        Gate::define('admin', function () {
            return Auth::user()->userPrivilege == 'Admin';
        });

        Gate::define('support', function () {
            if (in_array(Auth::user()->userPrivilege, ['Admin', 'Support'])) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('viewer', function () {
            if (in_array(Auth::user()->userPrivilege, ['Admin', 'Support', 'Viewer'])) {
                return true;
            } else {
                return false;
            }
        });
    }
}
