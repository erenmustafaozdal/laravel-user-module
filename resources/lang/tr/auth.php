<?php

return [
    // register
    'register' => [
        'fail'                          => 'Hesabın oluşturulamadı! Lütfen daha sonra tekrar dene.',
        'success'                       => '<p>Hesabın oluşturuldu! Hesabını aktifleştirmen için <strong>:email</strong> e-posta adresine bir posta gönderdik. E-posta adresini ziyaret et ve hesabını aktifleştir.</p><p>Aktivasyon postasının gelmesi sunucumuzdaki yoğunluğa göre, bazen 5 dakika kadar sürebilmektedir. Lütfen e-postanın <em>Spam</em> klasörünü de kontrol etmeyi unutma!</p>',
    ],


    // activation
    'activation' => [
        'not_found'                     => 'Aktivasyon bağlantısı bulunamadı.',
        'fail'                          => 'Hesabın aktifleştirilemedi.',
        'success'                       => 'Hesabın aktifleştirildi.'
    ],


    // login
    'login' => [
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
        'success'                       => '<strong>:email</strong> e-posta adresine başarılı bir şekilde şifre sıfırlama bağlantısı gönderildi.',
        'fail'                          => '<strong>:email</strong> e-posta adresi ile kayıtlı bir hesap bulamadık.',
    ],


    // reset password
    'reset_password' => [
        'success'                       => '<strong>:email</strong> e-posta adresi ile kayıtlı bir hesabın şifresi sıfırlandı.',
        'user_not_found'                => '<strong>:email</strong> e-posta adresi ile kayıtlı bir hesap bulamadık.',
        'incorrect_code'                => 'Şifre sıfırlama bağlantın yanlış. Lütfen bu işlemi tekrar dene!'
    ],
];