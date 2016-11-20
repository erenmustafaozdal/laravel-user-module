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
        $router->bind(config('laravel-user-module.url.user'),  function($id)
        {
            $user = \App\User::findOrFail($id);
            if (config('laravel-user-module.non_visibility.super_admin') && ! \Sentinel::getUser()->is_super_admin && $user->is_super_admin) {
                abort(403);
            }
            return $user;
        });
        $router->model(config('laravel-user-module.url.role'),  'App\Role');
        $router->model('role',  'App\Role');
    }

    /**
     * merge default configs with publish configs
     */
    protected function mergeDefaultConfig()
    {
        $config = $this->app['config']->get('laravel-user-module', []);
        $default = require __DIR__.'/../config/default.php';

        // admin page category routes
        $route = $config['routes']['admin']['role'];
        $default['routes']['admin']['role'] = $route;
        // admin page routes
        $route = $config['routes']['admin']['user'];
        $default['routes']['admin']['user'] = $route;
        $default['routes']['admin']['user_changePassword'] = $route;
        $default['routes']['admin']['user_permission'] = $route;

        // api page category routes
        $route = $config['routes']['api']['role'];
        $default['routes']['api']['role'] = $route;
        $default['routes']['api']['role_models'] = $route;
        $default['routes']['api']['role_group'] = $route;
        $default['routes']['api']['role_detail'] = $route;
        $default['routes']['api']['role_fastEdit'] = $route;
        // api page routes
        $model = $config['routes']['api']['user'];
        $default['routes']['api']['user'] = $model;
        $default['routes']['api']['user_group'] = $model;
        $default['routes']['api']['user_detail'] = $model;
        $default['routes']['api']['user_fastEdit'] = $model;
        $default['routes']['api']['user_activate'] = $model;
        $default['routes']['api']['user_notActivate'] = $model;
        $default['routes']['api']['user_avatarPhoto'] = $model;
        $default['routes']['api']['user_destroyAvatar'] = $model;

        $config['routes'] = $default['routes'];

        $config['user']['uploads']['photo'] = [];
        $default['user']['uploads']['photo']['path'] = unsetReturn($config['user']['uploads'],'path');
        $default['user']['uploads']['photo']['max_size'] = unsetReturn($config['user']['uploads'],'max_size');
        $default['user']['uploads']['photo']['aspect_ratio'] = unsetReturn($config['user']['uploads'],'aspect_ratio');
        $default['user']['uploads']['photo']['mimes'] = unsetReturn($config['user']['uploads'],'mimes');
        $default['user']['uploads']['photo']['thumbnails'] = unsetReturn($config['user']['uploads'],'thumbnails');
        $config['user']['uploads']['photo'] = $default['user']['uploads']['photo'];

        $this->app['config']->set('laravel-user-module', $config);
    }
}
