<?php

return [
    // register
    'register' => [
        'title'                         => 'Kayıt Ol',
        'first_name'                    => 'Ad',
        'last_name'                     => 'Soyad',
        'email'                         => 'E-posta',
        'password'                      => 'Şifre',
        'password_confirmation'         => 'Şifreni onayla',
        // message and links of terms of service and privacy policy
        'terms_content'                 => '<a href="javascript:;"> Kullanıcı Sözleşmesi </a> ve <a href="javascript:;"> Gizlilik Politikası </a>\'nı kabul ediyorum.',
        'submit'                        => 'Kayıt Ol',
        'login'                         => 'Giriş Yap!',
        'fail'                          => 'Hesabın oluşturulamadı! Lütfen daha sonra tekrar dene.',
        'success'                       => '<p>Hesabın oluşturuldu! Hesabını aktifleştirmen için <strong>:email</strong> e-posta adresine bir posta gönderdik. E-posta adresini ziyaret et ve hesabını aktifleştir.</p><p>Aktivasyon postasının gelmesi sunucumuzdaki yoğunluğa göre, bazen 5 dakika kadar sürebilmektedir. Lütfen e-postanın <em>Spam</em> klasörünü de kontrol etmeyi unutma!</p>',
    ],


    // activation
    'activation' => [
        'mail_subject'                  => 'Lütfen Hesabını Aktifleştir',
        'mail_content'                  => 'Merhaba :name! Lütfen hesabını aktifleştir: <a href="'.route('accountActivate',['id'=> ':id','code' => ':code']).'">'.route('accountActivate',['id'=> ':id','code' => ':code']).'</a>',
        'not_found'                     => 'Aktivasyon bağlantısı bulunamadı.',
        'fail'                          => 'Hesabın aktifleştirilemedi.',
        'success'                       => 'Hesabın aktifleştirildi.'
    ],


    // login
    'login' => [
        'title'                         => 'Giriş Yap',
        'email'                         => 'E-posta',
        'password'                      => 'Şifre',
        'submit'                        => 'Giriş Yap',
        'remember'                      => 'Hatırla',
        'forget_password'               => 'Şifreni mi unuttun?',
        'register'                      => 'Kayıt Ol!',
        'fail'                          => 'Giriş başarısız! Lütfen bilgilerini kontrol ederek tekrar dene. Eğer yeni üye olduysan, hesabını aktifleştirmeden hesabına ulaşamazsın.',
        'exception' => [
            'throttling' => [
                'global'                => 'Sistemimiz şu an saldırı altında gibi görünüyor. Ortalık sakinleşene kadar hizmetimize ara vermek zorunda kaldık. Lütfen giriş yapmayı :date tarihinden sonra tekrar dene.',
                'ip'                    => 'IP adresinden çok fazla yetkisiz giriş denemesi yapılmıştır. :date tarihinden önce tekrar giriş yapmayı denemeden bekle!',
                'user'                  => 'Hesabınıza ulaşmak için çok fazla yetkisiz giriş isteği aldık. Güvenliğin için :date tarihine kadar hesabını kitledik.'
            ],
            'not_activate'              => 'Hesabın aktifleşmediği için giriş yapamazsın.'
        ]
    ],


    // forget password
    'forget_password' => [
        'title'                         => 'Şifreni mi unuttun?',
        'message'                       => 'E-posta adresini yaz ve şifre sıfırlama bağlantısı ile tekrar hesabına giriş yap.',
        'email'                         => 'E-posta',
        'submit'                        => 'Gönder',
        'login'                         => 'Giriş Yap!',
        'mail_subject'                  => 'Şifre Sıfırlama Bağlantın',
        'mail_content'                  => 'Merhaba :name! Şifreni sıfırla: <a href="'.route('getResetPassword',['token'=> ':token']).'">'.route('getResetPassword',['token'=> ':token']).'</a>',
        'success'                       => '<strong>:email</strong> e-posta adresine başarılı bir şekilde şifre sıfırlama bağlantısı gönderildi.',
        'fail'                          => '<strong>:email</strong> e-posta adresi ile kayıtlı bir hesap bulamadık.',
    ],


    // reset password
    'reset_password' => [
        'title'                         => 'Şifreni Sıfırla',
        'message'                       => 'E-posta adresini yaz ve ve yeni şifreni belirle.',
        'email'                         => 'E-posta',
        'password'                      => 'Yeni şifre',
        'password_confirmation'         => 'Yeni şifreni onayla',
        'submit'                        => 'Şifreni Sıfırla',
        'login'                         => 'Giriş Yap!',
        'success'                       => '<strong>:email</strong> e-posta adresi ile kayıtlı bir hesabın şifresi sıfırlandı.',
        'user_not_found'                => '<strong>:email</strong> e-posta adresi ile kayıtlı bir hesap bulamadık.',
        'incorrect_code'                => 'Şifre sıfırlama bağlantın yanlış. Lütfen bu işlemi tekrar dene!'
    ],
];