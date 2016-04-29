<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Illuminate\Support\ServiceProvider;

class LaravelUserModuleComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(config('laravel-user-module.views.user.layout'), 'ErenMustafaOzdal\LaravelUserModule\Http\Composers\AdminComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
