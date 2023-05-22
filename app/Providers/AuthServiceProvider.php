<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

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
