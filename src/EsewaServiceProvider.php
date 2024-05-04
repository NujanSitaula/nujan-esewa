<?php

namespace Nujan\Esewa;

use Illuminate\Support\ServiceProvider;

class EsewaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('esewa', function ($app) {
            return new Esewa();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/esewa.php' => config_path('esewa.php'),
        ]);
    }
}
