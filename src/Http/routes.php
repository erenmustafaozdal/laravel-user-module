<?php

// Authentication routes...
Route::get(config('laravel-user-module.login_route'),  [
    'as' => 'getLogin',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@getLogin'
]);
Route::post(config('laravel-user-module.login_route'), [
    'as' => 'postLogin',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@postLogin'
]);
Route::get(config('laravel-user-module.logout_route'), [
    'as' => 'getLogout',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@getLogout'
]);

// Registration routes...
Route::get(config('laravel-user-module.register_route'), [
    'as' => 'getRegister',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@getRegister'
]);
Route::post(config('laravel-user-module.register_route'), [
    'as' => 'postRegister',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@postRegister'
]);
Route::get(config('laravel-user-module.activate_route').'/{id}/{code}', [
    'as' => 'accountActivate',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\AuthController@accountActivate'
]);

// Password reset link request routes...
Route::get(config('laravel-user-module.forget_password_route'), [
    'as' => 'getForgetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@getForgetPassword'
]);
Route::post(config('laravel-user-module.forget_password_route'), [
    'as' => 'postForgetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@postForgetPassword'
]);

// Password reset routes...
Route::get(config('laravel-user-module.reset_password_route').'/{token}', [
    'as' => 'getResetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@getResetPassword'
]);
Route::post(config('laravel-user-module.reset_password_route'), [
    'as' => 'postResetPassword',
    'uses' => 'ErenMustafaOzdal\LaravelUserModule\Http\Controllers\PasswordController@postResetPassword'
]);
