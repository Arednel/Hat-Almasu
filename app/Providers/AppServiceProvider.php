<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use TCG\Voyager\Facades\Voyager;

use App\Actions\ApproveSupportTicket;
use App\Actions\RejectSupportTicket;

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

        //Reject Support Ticket
        Voyager::addAction(RejectSupportTicket::class);
        //Approve Support Ticket
        Voyager::addAction(ApproveSupportTicket::class);
    }
}
