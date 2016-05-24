<?php
//max level nested function 100 hatasını düzeltiyor
ini_set('xdebug.max_nesting_level', 300);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
// Authentication routes...
Route::get(config('laravel-user-module.url.login_route'),  [
    'as' => 'getLogin',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@getLogin'
]);
Route::post(config('laravel-user-module.url.login_route'), [
    'as' => 'postLogin',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@postLogin'
]);
Route::get(config('laravel-user-module.url.logout_route'), [
    'as' => 'getLogout',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@getLogout'
]);

// Registration routes...
if (config('laravel-user-module.use_register')) {
    Route::get(config('laravel-user-module.url.register_route'), [
        'as' => 'getRegister',
        'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@getRegister'
    ]);
    Route::post(config('laravel-user-module.url.register_route'), [
        'as' => 'postRegister',
        'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@postRegister'
    ]);
    Route::get(config('laravel-user-module.url.activate_route') . '/{id}/{code}', [
        'as' => 'accountActivate',
        'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@accountActivate'
    ]);
}

// Password reset link request routes...
Route::get(config('laravel-user-module.url.forget_password_route'), [
    'as' => 'getForgetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@getForgetPassword'
]);
Route::post(config('laravel-user-module.url.forget_password_route'), [
    'as' => 'postForgetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@postForgetPassword'
]);

// Password reset routes...
Route::get(config('laravel-user-module.url.reset_password_route').'/{token}', [
    'as' => 'getResetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@getResetPassword'
]);
Route::post(config('laravel-user-module.url.reset_password_route'), [
    'as' => 'postResetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@postResetPassword'
]);



/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => config('laravel-user-module.url.admin_url_prefix'),
    'middleware' => ['auth'],
    'namespace' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers'
], function()
{
    /*==========  Role Module  ==========*/
    Route::resource(config('laravel-user-module.url.role'), 'RoleController', [
        'names' => [
            'index'     => 'admin.role.index',
            'create'    => 'admin.role.create',
            'store'     => 'admin.role.store',
            'show'      => 'admin.role.show',
            'edit'      => 'admin.role.edit',
            'update'    => 'admin.role.update',
            'destroy'   => 'admin.role.destroy',
        ]
    ]);

    /*==========  User Module  ==========*/
    Route::resource(config('laravel-user-module.url.user'), 'UserController', [
        'names' => [
            'index'     => 'admin.user.index',
            'create'    => 'admin.user.create',
            'store'     => 'admin.user.store',
            'show'      => 'admin.user.show',
            'edit'      => 'admin.user.edit',
            'update'    => 'admin.user.update',
            'destroy'   => 'admin.user.destroy',
        ]
    ]);
});



/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'api',
    'middleware' => ['auth'],
    'namespace' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers'
], function()
{
    /*==========  Role Module  ==========*/

    /*==========  User Module  ==========*/
    Route::get('user-detail/{id}',  [
        'as' => 'api.user.index.detail',
        'uses' => 'UserApiController@userDetail'
    ]);
    Route::resource(config('laravel-user-module.url.user'), 'UserApiController', [
        'names' => [
            'index'     => 'api.user.index',
            'store'     => 'api.user.store',
            'update'    => 'api.user.update',
            'destroy'   => 'api.user.destroy',
        ]
    ]);
});
