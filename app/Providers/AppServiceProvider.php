<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Partido;
use App\Observers\PartidoObserver;


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
        //
        Partido::observe(PartidoObserver::class);

    }
}
