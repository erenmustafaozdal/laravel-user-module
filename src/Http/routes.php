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
    'middleware' => ['auth', 'permission'],
    'namespace' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers'
], function()
{
    /*==========  Role Module  ==========*/
    if (config('laravel-user-module.routes.admin.role')) {
        Route::resource(config('laravel-user-module.url.role'), 'RoleController', [
            'names' => [
                'index' => 'admin.role.index',
                'create' => 'admin.role.create',
                'store' => 'admin.role.store',
                'show' => 'admin.role.show',
                'edit' => 'admin.role.edit',
                'update' => 'admin.role.update',
                'destroy' => 'admin.role.destroy',
            ]
        ]);
    }

    /*==========  User Module  ==========*/
    // change password
    if (config('laravel-user-module.routes.admin.user_changePassword')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/change-password', [
            'as' => 'admin.user.changePassword',
            'uses' => 'UserController@changePassword'
        ]);
    }
    // permission change
    if (config('laravel-user-module.routes.admin.user_permission')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/change-permission', [
            'as' => 'admin.user.permission',
            'uses' => 'UserController@permission'
        ]);
    }
    if (config('laravel-user-module.routes.admin.user')) {
        Route::resource(config('laravel-user-module.url.user'), 'UserController', [
            'names' => [
                'index' => 'admin.user.index',
                'create' => 'admin.user.create',
                'store' => 'admin.user.store',
                'show' => 'admin.user.show',
                'edit' => 'admin.user.edit',
                'update' => 'admin.user.update',
                'destroy' => 'admin.user.destroy',
            ]
        ]);
    }
});



/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'api',
    'middleware' => ['auth', 'permission'],
    'namespace' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers'
], function()
{
    /*==========  Role Module  ==========*/
    // api roles
    if (config('laravel-user-module.routes.api.role_models')) {
        Route::post('role/models', [
            'as' => 'api.role.models',
            'uses' => 'RoleApiController@models'
        ]);
    }
    // api group action
    if (config('laravel-user-module.routes.api.role_group')) {
        Route::post('role/group-action', [
            'as' => 'api.role.group',
            'uses' => 'RoleApiController@group'
        ]);
    }
    // data table detail row
    if (config('laravel-user-module.routes.api.role_detail')) {
        Route::get('role/{id}/detail', [
            'as' => 'api.role.detail',
            'uses' => 'RoleApiController@detail'
        ]);
    }
    // get role edit data for modal edit
    if (config('laravel-user-module.routes.api.role_fastEdit')) {
        Route::post('role/{role}/fast-edit', [
            'as' => 'api.role.fastEdit',
            'uses' => 'RoleApiController@fastEdit'
        ]);
    }
    if (config('laravel-user-module.routes.api.role')) {
        Route::resource(config('laravel-user-module.url.role'), 'RoleApiController', [
            'names' => [
                'index' => 'api.role.index',
                'store' => 'api.role.store',
                'update' => 'api.role.update',
                'destroy' => 'api.role.destroy',
            ]
        ]);
    }

    /*==========  User Module  ==========*/
    // api group action
    if (config('laravel-user-module.routes.api.user_group')) {
        Route::post('user/group-action', [
            'as' => 'api.user.group',
            'uses' => 'UserApiController@group'
        ]);
    }
    // data table detail row
    if (config('laravel-user-module.routes.api.user_detail')) {
        Route::get('user/{id}/detail', [
            'as' => 'api.user.detail',
            'uses' => 'UserApiController@detail'
        ]);
    }
    // get user edit data for modal edit
    if (config('laravel-user-module.routes.api.user_fastEdit')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/fast-edit', [
            'as' => 'api.user.fastEdit',
            'uses' => 'UserApiController@fastEdit'
        ]);
    }
    // api activate user
    if (config('laravel-user-module.routes.api.user_activate')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/activate', [
            'as' => 'api.user.activate',
            'uses' => 'UserApiController@activate'
        ]);
    }
    // api not activate user
    if (config('laravel-user-module.routes.api.user_notActivate')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/not-activate', [
            'as' => 'api.user.notActivate',
            'uses' => 'UserApiController@notActivate'
        ]);
    }
    // upload user template profile photo
    if (config('laravel-user-module.routes.api.user_avatarPhoto')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/upload-avatar-photo', [
            'as' => 'api.user.avatarPhoto',
            'uses' => 'UserApiController@avatarPhoto'
        ]);
    }
    // delete user uploaded photo
    if (config('laravel-user-module.routes.api.user_destroyAvatar')) {
        Route::post('user/{' . config('laravel-user-module.url.user') . '}/destroy-avatar-photo', [
            'as' => 'api.user.destroyAvatar',
            'uses' => 'UserApiController@destroyAvatar'
        ]);
    }
    if (config('laravel-user-module.routes.api.user')) {
        Route::resource(config('laravel-user-module.url.user'), 'UserApiController', [
            'names' => [
                'index' => 'api.user.index',
                'store' => 'api.user.store',
                'update' => 'api.user.update',
                'destroy' => 'api.user.destroy',
            ]
        ]);
    }
});
