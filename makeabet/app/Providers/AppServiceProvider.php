<?php

namespace App\Providers;

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
        $this->app->bind('App\Modules\Player\Contracts\PlayerRepositoryInterface', 'App\Modules\Player\Repositories\PlayerRepository');
        $this->app->bind('App\Modules\Bet\Contracts\BetRepositoryInterface', 'App\Modules\Bet\Repositories\BetRepository');
        $this->app->bind('App\Modules\Balancetransaction\Contracts\BalanceTransactionRepositoryInterface', 'App\Modules\Balancetransaction\Repositories\BalanceTransactionRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
