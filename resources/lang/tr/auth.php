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
        'submit'                        => 'Kayıt Ol',
        'login_message'                 => 'Daha önce kayıt oldun mu?',
        'login'                         => 'Giriş Yap!',
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
        'forget_password'               => 'Şifreni mi unuttun?',
        'register_message'              => 'Yeni misin?',
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


    // forget password and reset password
    'mail_subject'                  => 'Şifre Sıfırlama Bağlantın',
];