<?php

namespace drlear\FleetTracking;

use Illuminate\Support\ServiceProvider;
use drlear\FleetTracking\Commands\SyncFleets;
use drlear\FleetTracking\Services\ESIService;

class FleetTrackingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'fleettracking');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'fleettracking');

        $this->publishes([
            __DIR__ . '/config/fleettracking.php' => config_path('fleettracking.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/fleettracking'),
        ], 'views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncFleets::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/fleettracking.php', 'fleettracking'
        );

        $this->app->singleton(ESIService::class, function ($app) {
            return new ESIService(
                config('fleettracking.esi_client_id'),
                config('fleettracking.esi_secret_key'),
                config('fleettracking.esi_callback_url')
            );
        });
    }
}
