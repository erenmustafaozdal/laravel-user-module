<?php

return [
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
            ]
        ]
    ],
];
