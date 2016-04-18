<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route config
    |--------------------------------------------------------------------------
    */
    'login_route'               => 'login',             // what is login route etc: giris-yap
    'logout_route'              => 'logout',            // what is logout route etc: cikis-yap
    'register_route'            => 'register',          // what is register route etc: uye-ol
    'activate_route'            => 'account-activate',  // what is account activate route etc: hesabi-aktiflestir
    'forget_password_route'     => 'forget-password',   // what is forget password route etc: sifremi-unuttum
    'reset_password_route'      => 'reset-password',    // what is reset password route etc: sifremi-sifirla
    'redirect_route'            => 'admin',             // what is redirect route after login etc: yonetim

    /*
    |--------------------------------------------------------------------------
    | View config
    |--------------------------------------------------------------------------
    | dot notation of blade view path, its position on the /resources/views directory
    */
    'views' => [
        // auth views
        'login'                 => 'auth.login',            // get login view blade
        'register'              => 'auth.register',         // get register view blade
        'forget_password'       => 'auth.forget_password',  // get forget password view blade
        'reset_password'        => 'auth.reset_password',   // get reset password view blade
    ]

];
