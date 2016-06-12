<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'activation_mail_blade'         => 'emails.activation',
    'date_format'                   => 'd.m.Y H:i:s',
    'use_register'                  => true,                    // if you want to use register form

    /*
    |--------------------------------------------------------------------------
    | URL config
    |--------------------------------------------------------------------------
    */
    'url' => [
        'login_route'               => 'login',                 // login url
        'logout_route'              => 'logout',                // logout url
        'register_route'            => 'register',              // register url
        'activate_route'            => 'account-activate',      // account activate url
        'forget_password_route'     => 'forget-password',       // forget password url
        'reset_password_route'      => 'reset-password',        // reset password url
        'user'                      => 'users',                 // users url
        'role'                      => 'roles',                 // users url
        'redirect_route'            => 'admin',                 // redirect dashboard route name after login
        'admin_url_prefix'          => 'admin',                 // admin dashboard url prefix
    ],

    /*
    |--------------------------------------------------------------------------
    | View config
    |--------------------------------------------------------------------------
    | dot notation of blade view path, its position on the /resources/views directory
    */
    'views' => [
        // auth views
        'auth' => [
            'layout'                => 'laravel-modules-core::auth',                // auth layout
            'login'                 => 'laravel-user-module::auth.login',           // get login view blade
            'register'              => 'laravel-user-module::auth.register',        // get register view blade
            'forget_password'       => 'laravel-user-module::auth.forget_password', // get forget password view blade
            'reset_password'        => 'laravel-user-module::auth.reset_password',   // get reset password view blade
        ],
        // user view
        'user' => [
            'layout'                => 'laravel-modules-core::admin',               // user layout
            'index'                 => 'laravel-user-module::user.index',           // get user index view blade
            'create'                => 'laravel-user-module::user.create',          // get user create view blade
            'show'                  => 'laravel-user-module::user.show',            // get user show view blade
            'edit'                  => 'laravel-user-module::user.edit',            // get user edit view blade
        ],
        // role view
        'role' => [
            'layout'                => 'laravel-modules-core::admin',               // role layout
            'index'                 => 'laravel-user-module::role.index',           // get role index view blade
            'create'                => 'laravel-user-module::role.create',          // get role create view blade
            'show'                  => 'laravel-user-module::role.show',            // get role show view blade
            'edit'                  => 'laravel-user-module::role.edit',            // get role edit view blade
        ],
        // email views
        'email' => [
            'activation'            => 'laravel-user-module::emails.activation',    // activation mail view blade
            'forget_password'       => 'laravel-user-module::emails.forget_password'// forget password mail view blade
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    */
    'user' => [
        'avatar' => [
            'thumbnail'             => 'vendor/laravel-modules-core/assets/global/img/avatar_thumbnail.jpg',
            'original'              => 'vendor/laravel-modules-core/assets/global/img/avatar_original.jpg',
        ],
        'upload_photo' => [
            'url'                   => 'uploads/user', // + /{id}/original && /{id}/thumbnail
            'thumbnail_size' => [
                'width'             => '',
                'height'            => '',
            ]
        ]
    ],
];
