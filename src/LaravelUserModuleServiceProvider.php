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
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-user-module');
        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/laravel-user-module'),
        ]);

        $this->publishes([
            __DIR__.'/../config/laravel-user-module.php' => config_path('laravel-user-module.php')
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-user-module');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/laravel-user-module'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('ErenMustafaOzdal\LaravelUserModule\LaravelUserModuleComposerServiceProvider');
        $this->app->register('Illuminate\Html\HtmlServiceProvider');
        $this->app->register('Laracasts\Flash\FlashServiceProvider');
        $this->app->register('Cartalyst\Sentinel\Laravel\SentinelServiceProvider');
        $this->app->register('Yajra\Datatables\DatatablesServiceProvider');

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Html', 'Illuminate\Html\HtmlFacade');
            $loader->alias('Form', 'Illuminate\Html\FormFacade');
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-user-module.php', 'laravel-user-module'
        );

        $router = $this->app['router'];
        $router->middleware('guest',\ErenMustafaOzdal\LaravelUserModule\Http\Middleware\RedirectIfAuthenticated::class);
        $router->middleware('auth',\ErenMustafaOzdal\LaravelUserModule\Http\Middleware\Authenticate::class);

        // model binding
        $router->model(config('laravel-user-module.url.user'),  'App\User');
    }
}
