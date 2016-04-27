<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'activation_mail_blade'         => 'emails.activation',
    'date_format'                   => 'd.m.Y H:i:s',

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
        'admin_url_prefix'          => 'admin'                  // admin dashboard url prefix
    ],

    /*
    |--------------------------------------------------------------------------
    | View config
    |--------------------------------------------------------------------------
    | dot notation of blade view path, its position on the /resources/views directory
    */
    'views' => [
        // all layouts default values
        'html_lang'                     => 'tr',
        'html_head' => [
            'content_type'              => 'text/html; charset=UTF-8',
            'charset'                   => 'utf-8',
            'default_title'             => 'Laravel User Module',   // default page title of all pages
            'meta_description'          => 'Laravel User Module package',
            'meta_author'               => 'Eren Mustafa ÖZDAL',
            'meta_keywords'             => 'laravel,user,module,package',
            'meta_robots'               => 'noindex,nofollow',
            'meta_googlebot'            => 'noindex,nofollow'
        ],
        // auth views
        'auth' => [
            'layout'                => 'laravel-user-module::layouts.auth',     // auth layout
            'login'                 => 'laravel-user-module::auth.login',       // get login view blade
            'register'              => 'auth.register',         // get register view blade
            'forget_password'       => 'auth.forget_password',  // get forget password view blade
            'reset_password'        => 'auth.reset_password',   // get reset password view blade
        ],
        // user view
        'user' => [
            'index'                 => 'admin.user.index',      // get user index view blade
            'create'                => 'admin.user.create',     // get user create view blade
            'show'                  => 'admin.user.show',       // get user show view blade
            'edit'                  => 'admin.user.edit',       // get user edit view blade
        ],
        // role view
        'role' => [
            'index'                 => 'admin.role.index',      // get role index view blade
            'create'                => 'admin.role.create',     // get role create view blade
            'show'                  => 'admin.role.show',       // get role show view blade
            'edit'                  => 'admin.role.edit',       // get role edit view blade
        ]
    ]

];
