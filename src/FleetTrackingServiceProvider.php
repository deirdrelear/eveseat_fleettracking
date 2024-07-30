<?php

namespace Drlear\FleetTracking;

use Illuminate\Support\ServiceProvider;
use Drlear\FleetTracking\Commands\SyncFleets;
use Drlear\FleetTracking\Services\ESIService;
use Seat\Services\AbstractSeatPlugin;

class FleetTrackingServiceProvider extends AbstractSeatPlugin
{
    public function boot()
    {
        $this->addCommands();
        $this->addRoutes();
        $this->addViews();
        $this->addTranslations();
        $this->addMigrations();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fleettracking.php', 'fleettracking');

        $this->app->singleton(ESIService::class, function ($app) {
            return new ESIService(
                config('fleettracking.esi_client_id'),
                config('fleettracking.esi_secret_key'),
                config('fleettracking.esi_callback_url')
            );
        });
    }

    private function addCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncFleets::class,
            ]);
        }
    }

    private function addRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    private function addViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'fleettracking');
    }

    private function addTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'fleettracking');
    }

    private function addMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function getName(): string
    {
        return 'Fleet Tracking';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/deirdrelear/seat-fleet-tracking';
    }

    public function getPackagistPackageName(): string
    {
        return 'drlear/seat-fleet-tracking';
    }

    public function getPackagistVendorName(): string
    {
        return 'drlear';
    }
}