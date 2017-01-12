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

        $router = $this->app['router'];
        $router->middleware('guest',\ErenMustafaOzdal\LaravelUserModule\Http\Middleware\RedirectIfAuthenticated::class);
        $router->middleware('auth',\ErenMustafaOzdal\LaravelUserModule\Http\Middleware\Authenticate::class);

        // model binding
        $router->bind(config('laravel-user-module.url.user'),  function($id)
        {
            $user = \App\User::findOrFail($id);
            if (\Sentinel::check() && config('laravel-user-module.non_visibility.super_admin') && ! \Sentinel::getUser()->is_super_admin && $user->is_super_admin) {
                abort(403);
            }
            return $user;
        });
        $router->model(config('laravel-user-module.url.role'),  'App\Role');
        $router->model('role',  'App\Role');
    }
}
