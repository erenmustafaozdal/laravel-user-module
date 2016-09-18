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
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('ErenMustafaOzdal\LaravelUserModule\LaravelUserModuleComposerServiceProvider');
        $this->app->register('ErenMustafaOzdal\LaravelModulesBase\LaravelModulesBaseServiceProvider');

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-user-module.php', 'laravel-user-module'
        );
        // merge default configs with publish configs
        $this->mergeDefaultConfig();

        $router = $this->app['router'];
        $router->middleware('guest',\ErenMustafaOzdal\LaravelUserModule\Http\Middleware\RedirectIfAuthenticated::class);
        $router->middleware('auth',\ErenMustafaOzdal\LaravelUserModule\Http\Middleware\Authenticate::class);

        // model binding
        $router->model(config('laravel-user-module.url.user'),  'App\User');
        $router->model(config('laravel-user-module.url.role'),  'App\Role');
    }

    /**
     * merge default configs with publish configs
     */
    protected function mergeDefaultConfig()
    {
        $config = $this->app['config']->get('laravel-user-module', []);
        $default = require __DIR__.'/../config/default.php';

        $config['user']['uploads']['photo']['relation'] = $default['user']['uploads']['photo']['relation'];
        $config['user']['uploads']['photo']['relation_model'] = $default['user']['uploads']['photo']['relation_model'];
        $config['user']['uploads']['photo']['type'] = $default['user']['uploads']['photo']['type'];
        $config['user']['uploads']['photo']['number_type'] = $default['user']['uploads']['photo']['number_type'];
        $config['user']['uploads']['photo']['column'] = $default['user']['uploads']['photo']['number_type'];

        $this->app['config']->set('laravel-user-module', $config);
    }
}
