<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Illuminate\Support\ServiceProvider;

class LaravelUserModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // publish migrations
        $this->publishMigrations();
        // publish config
        $this->publishConfig();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * publish migrations
     *
     * @return void
     */
    public function publishMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * publish migrations
     *
     * @return void
     */
    public function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-user-module.php' => config_path('laravel-user-module.php')
        ], 'config');
    }
}
