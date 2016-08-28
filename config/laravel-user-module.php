<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'date_format'                   => 'd.m.Y H:i:s',
    'use_register'                  => true,                    // if you want to use register form
    'icons' => [
        'role'                  => 'icon-users',
        'user'                  => 'icon-user'
    ],

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
            'layout'                => 'laravel-modules-core::layouts.auth',        // auth layout
            'login'                 => 'laravel-modules-core::auth.login',          // get login view blade
            'register'              => 'laravel-modules-core::auth.register',       // get register view blade
            'forget_password'       => 'laravel-modules-core::auth.forget_password',// get forget password view blade
            'reset_password'        => 'laravel-modules-core::auth.reset_password', // get reset password view blade
        ],
        // user view
        'user' => [
            'layout'                => 'laravel-modules-core::layouts.admin',       // user layout
            'index'                 => 'laravel-modules-core::user.index',          // get user index view blade
            'create'                => 'laravel-modules-core::user.operation',      // get user create view blade
            'show'                  => 'laravel-modules-core::user.show',           // get user show view blade
            'edit'                  => 'laravel-modules-core::user.operation',      // get user edit view blade
        ],
        // role view
        'role' => [
            'layout'                => 'laravel-modules-core::layouts.admin',       // role layout
            'index'                 => 'laravel-modules-core::role.index',          // get role index view blade
            'create'                => 'laravel-modules-core::role.operation',      // get role create view blade
            'show'                  => 'laravel-modules-core::role.show',           // get role show view blade
            'edit'                  => 'laravel-modules-core::role.operation',      // get role edit view blade
        ],
        // email views
        'email' => [
            'activation'            => 'laravel-modules-core::emails.activation',   // activation mail view blade
            'forget_password'       => 'laravel-modules-core::emails.forget_password'// forget password mail view blade
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    |
    | ## Options
    |
    | - default_img_path                : model default avatar or photo
    |
    | --- uploads                       : model uploads options
    | - relation                        : file is in the relation table and what is relation type [false|hasOne|hasMany]
    | - relation_model                  : relation model [\App\Model etc...]
    | - type                            : file type [image,file]
    | - number_type                     : file number type [multiple,single]
    | - column                          : file database column
    | - path                            : file path
    | - max_size                        : file allowed maximum size
    | - aspect_ratio                    : if file is image; crop aspect ratio
    | - mimes                           : file allowed mimes
    | - thumbnails                      : if file is image; its thumbnails options
    |
    | NOT: Thumbnails fotoğrafları yüklenirken bakılır:
    |       1. eğer post olarak x1, y1, x2, y2, width ve height değerleri gönderilmemiş ise bu değerlere göre
    |       thumbnails ayarlarında belirtilen resimleri sistem içine kaydeder.
    |       Yani bu değerler post edilmişse aşağıdaki değerleri yok sayar.
    |       2. Eğer yukarıdaki ilgili değerler post edilmemişse, thumbnails ayarlarında belirtilen değerleri
    |       dikkate alarak thumbnails oluşturur
    |
    |       Ölçü Belirtme:
    |       1. İstenen resmin width ve height değerleri verilerek istenen net bir ölçüde resimler oluşturulabilir
    |       2. Width değeri null verilerek, height değerine göre ölçeklenebilir
    |       3. Height değeri null verilerek, width değerine göre ölçeklenebilir
    |--------------------------------------------------------------------------
    */
    'user' => [
        'default_img_path'          => 'vendor/laravel-modules-core/assets/global/img/avatar',
        'uploads' => [
            // profile photo options
            'photo' => [
                'relation'              => false,
                'relation_model'        => null,
                'type'                  => 'image',
                'number_type'           => 'single',
                'column'                => 'photo',
                'path'                  => 'uploads/user',
                'max_size'              => '5120',
                'aspect_ratio'          => 1,
                'mimes'                 => 'jpeg,jpg,jpe,png',
                'thumbnails' => [
                    'smallest'          => [ 'width' => 35, 'height' => 35],
                    'small'             => [ 'width' => 150, 'height' => 150],
                    'normal'            => [ 'width' => 300, 'height' => 300],
                    'big'               => [ 'width' => 500, 'height' => 500],
                    'biggest'           => [ 'width' => 800, 'height' => 800],
                ]
            ]
        ]
    ],
];
