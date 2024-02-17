<?php

namespace Zerkxubas\EsewaLaravel\Laravel;

use Illuminate\Support\ServiceProvider;

use Zerkxubas\EsewaLaravel\Facades\Esewa;

class EsewaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishes the configuration file
        $this->publishes([
            __DIR__.'/../config/esewa.php' => config_path('esewa.php'),
        ], 'esewa');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Registering the Esewa facade
        $this->app->bind('Esewa', function ($app) {
            return new Esewa();
        });
    }
}