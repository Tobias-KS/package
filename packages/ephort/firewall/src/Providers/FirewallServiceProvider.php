<?php

namespace Ephort\Firewall\Providers;

use Illuminate\Support\ServiceProvider;
use Ephort\Firewall\Console\NumberOfBlockedIPS;
use Ephort\Firewall\Console\WhiteListIPS;
use Ephort\Firewall\Console\Unlist;
use Illuminate\Contracts\Http\Kernel;
use Ephort\Firewall\Middleware\BlockBlacklistedClients;

class FirewallServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //Alias middleware that blocks unwanted users.

        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(BlockBlacklistedClients::class);

        //register commands
        $this->commands([
            NumberOfBlockedIPS::class,
            WhiteListIPS::class,
            Unlist::class,
        ]);

        //Schedule hourly update
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('firewall:status')->everyMinute();
        // });
    }

    public function register()
    {


    }

}
