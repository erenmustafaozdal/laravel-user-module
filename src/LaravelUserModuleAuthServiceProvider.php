<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;

class LaravelUserModuleAuthServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //overriden register method, called the singleton rebinding in registerAccessGate
        $this->registerAccessGate();
    }

    /**
     * authentication user to sentinel user for the laravel gate
     */
    protected function registerAccessGate()
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new Gate($app, function () use ($app) {
                return $this->app['sentinel']->getUser();
            });
        });
    }
}
