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
    | model non visibility
    |--------------------------------------------------------------------------
    */
    'non_visibility' => [
        'super_admin'   => true,
        'role_slugs'    => ['customer']
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
    | Routes on / off
    | if you don't use any route; set false
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'admin' => [
            'role'                  => true,                // admin role resource route
            'user'                  => true,                // admin user resource route
            'user_changePassword'   => true,                // admin user publish get route
            'user_permission'       => true,                // admin user not publish get route
        ],
        'api' => [
            'role'                  => true,                // api role resource route
            'role_models'           => true,                // api role model post route
            'role_group'            => true,                // api role group post route
            'role_detail'           => true,                // api role detail get route
            'role_fastEdit'         => true,                // api role fast edit post route
            'user'                  => true,                // api user resource route
            'user_group'            => true,                // api user group post route
            'user_detail'           => true,                // api user detail get route
            'user_fastEdit'         => true,                // api user fast edit post route
            'user_activate'         => true,                // api user activate get route
            'user_notActivate'      => true,                // api user not activate get route
            'user_avatarPhoto'      => true,                // api user avatar photo post route
            'user_destroyAvatar'    => true,                // api user destroy avatar photo post route
        ]
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
                'aspect_ratio'          => 1,
                'max_size'              => '5120',
                'mimes'                 => 'jpeg,jpg,jpe,png',
                'thumbnails' => [
                    'small'             => [ 'width' => 35, 'height' => 35],
                    'normal'            => [ 'width' => 300, 'height' => 300],
                    'big'               => [ 'width' => 800, 'height' => 800],
                ]
            ]
        ]
    ],






    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'role' => [
            'title'                 => 'Yönetici Rolleri',
            'routes' => [
                'admin.role.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar yönetici rolleri veri tablosu sayfasına gidebilir.',
                ],
                'admin.role.create' => [
                    'title'         => 'Ekleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar yönetici rolü ekleme sayfasına gidebilir',
                ],
                'admin.role.store' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar yönetici rolü ekleyebilir',
                ],
                'admin.role.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar yönetici rolü bilgilerini görüntüleyebilir',
                ],
                'admin.role.edit' => [
                    'title'         => 'Düzenleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar yönetici rolünü düzenleme sayfasına gidebilir',
                ],
                'admin.role.update' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar yönetici rolünü düzenleyebilir',
                ],
                'admin.role.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar yönetici rolünü silebilir',
                ],
                'api.role.index' => [
                    'title'         => 'Listeleme',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini veri tablosunda listeleyebilir',
                ],
                'api.role.store' => [
                    'title'         => 'Hızlı Ekleme',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini veri tablosunda hızlı ekleyebilir.',
                ],
                'api.role.update' => [
                    'title'         => 'Hızlı Düzenleme',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini veri tablosunda hızlı düzenleyebilir.',
                ],
                'api.role.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini veri tablosunda silebilir',
                ],
                'api.role.models' => [
                    'title'         => 'Seçim İçin Listeleme',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini bazı seçim kutularında listeleyebilir',
                ],
                'api.role.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini veri tablosunda toplu işlem yapabilir',
                ],
                'api.role.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini tablosunda detayını görebilir.',
                ],
                'api.role.fastEdit' => [
                    'title'         => 'Hızlı Düzenleme Bilgileri',
                    'description'   => 'Bu izne sahip olanlar yönetici rollerini tablosunda hızlı düzenleme amacıyla bilgileri getirebilir.',
                ],
            ],
        ],
        'user' => [
            'title'                 => 'Yöneticiler',
            'routes' => [
                'admin.user.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar yöneticiler veri tablosu sayfasına gidebilir.',
                ],
                'admin.user.create' => [
                    'title'         => 'Ekleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar yönetici ekleme sayfasına gidebilir',
                ],
                'admin.user.store' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar yönetici ekleyebilir',
                ],
                'admin.user.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar yönetici bilgilerini görüntüleyebilir',
                ],
                'admin.user.edit' => [
                    'title'         => 'Düzenleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar yöneticiyi düzenleme sayfasına gidebilir',
                ],
                'admin.user.update' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar yöneticiyi düzenleyebilir',
                ],
                'admin.user.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar yöneticiyi silebilir',
                ],
                'admin.user.changePassword' => [
                    'title'         => 'Şifre Değiştirme',
                    'description'   => 'Bu izne sahip olanlar yönetici şifresini değiştirebilir.)',
                ],
                'admin.user.permission' => [
                    'title'         => 'İşlem İzinleri',
                    'description'   => 'Bu izne sahip olanlar yönetici işlem izinlerini güncelleyebilir.',
                ],
                'api.user.index' => [
                    'title'         => 'Listeleme',
                    'description'   => 'Bu izne sahip olanlar yöneticileri veri tablosunda listeleyebilir',
                ],
                'api.user.store' => [
                    'title'         => 'Hızlı Ekleme',
                    'description'   => 'Bu izne sahip olanlar yöneticileri veri tablosunda hızlı ekleyebilir.',
                ],
                'api.user.update' => [
                    'title'         => 'Hızlı Düzenleme',
                    'description'   => 'Bu izne sahip olanlar yöneticileri veri tablosunda hızlı düzenleyebilir.',
                ],
                'api.user.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar yöneticileri veri tablosunda silebilir',
                ],
                'api.user.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar yöneticiler veri tablosunda toplu işlem yapabilir',
                ],
                'api.user.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar yöneticiler tablosunda detayını görebilir.',
                ],
                'api.user.fastEdit' => [
                    'title'         => 'Hızlı Düzenleme Bilgileri',
                    'description'   => 'Bu izne sahip olanlar yöneticiler tablosunda hızlı düzenleme amacıyla bilgileri getirebilir.',
                ],
                'api.user.activate' => [
                    'title'         => 'Aktifleştirme',
                    'description'   => 'Bu izne sahip olanlar yöneticinin durumunu aktifleştirebilir.',
                ],
                'api.user.notActivate' => [
                    'title'         => 'Aktifliği Kaldırma',
                    'description'   => 'Bu izne sahip olanlar yöneticinin aktifliğini kaldırabilir.',
                ],
                'api.user.avatarPhoto' => [
                    'title'         => 'Profil Fotoğrafı',
                    'description'   => 'Bu izne sahip olanlar yöneticinin profil fotoğrafını güncelleyebilir.',
                ],
                'api.user.destroyAvatar' => [
                    'title'         => 'Profil Fotoğrafı Silme',
                    'description'   => 'Bu izne sahip olanlar yöneticinin profil fotoğrafını silebilir.',
                ],
            ],
        ],
    ],
];
