Laravel User Module
===================
[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](https://laravel.com/docs/5.1/)
[![Source](https://img.shields.io/badge/source-erenmustafaozdal/laravel--user--module-blue.svg?style=flat-square)](https://github.com/erenmustafaozdal/laravel-user-module)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

**Laravel User Module**, Laravel 5.1 projelerinde *kullanıcı*, *rol* ve *giriş* işlemlerini kapsayan bir modül paketidir. Bu paket kullanıcı arayüzü **(views)** hariç, arka plandaki bütün işlemleri barındırmaktadır.
Laravel User Module kurulumu ve kullanımı oldukça kolay bir pakettir. Dizin yapısı Laravel'in dizin yapısına benzer olduğu için geliştirici için alışıldık bir görünüm sunar.

Kurulum
-------
Composer ile yüklemek için aşağıdaki kodu kullanabilirsin.

```bash
composer require erenmustafaozdal/laravel-user-module
```
Ya da `composer.json` dosyana, aşağıdaki gibi ekleme yapıp, paketleri güncelleyebilirsin.
```json
{
    "require": {
        "erenmustafaozdal/laravel-user-module": "dev-master"
    }
}
```

```bash
$ composer update
```
Bu işlem bittikten sonra, service provider'i projenin `config/app.php` dosyasına eklemelisin.

```php
ErenMustafaOzdal\LaravelUserModule\LaravelUserModuleServiceProvider::class,
```
##### Dosyaların Yayınlanması
**Laravel User Module** paketi [Cartaklyst/Sentinel](https://github.com/cartalyst/sentinel) ve [Laracasts/Flash](https://github.com/laracasts/flash) paketleriyle bağımlıdır. Bu sebeple ilgili paketlerin de dosyalarının publish edilmesi için aşağıdaki kodu çalıştırmalısın.
```bash
php artisan vendor:publish
```
##### Migration
Dosyaları yayınladıktan sonra migration işlemi yapmalısın.
> :exclamation: Migration işleminden önce Laravel'in varsayılan migration dosyalarını silmelisin. Sentinel kendi migration dosyalarını ekleyecek.

> :exclamation: Sentinel'e ait `...migration_cartalyst_sentinel.php` dosyasında **Laravel User Module**'e özgü bazı değişiklikler yapmalısın. `users` tablosunun sütunlarının belirlendiği satırlarda, `last_name` sütunundan sonra aşağıdaki gibi ekleme yapmalısın.

```php
$table->string('last_name')->nullable();    // bu satırdan sonra
$table->boolean('is_active')->default(0);   // bu satırı eklemelisin
```
Daha sonra migrate işlemini yapabilirsin.
```bash
php artisan migrate
```

> :exclamation: Başarılı kayıt işlemi ile tetiklenen olay sonrası, kullanıcıya aktivasyon e-postası göndermek için; `ErenMustafaOzdal\LaravelUserModule\Listeners\LaravelUserModuleListener` dinleyicisini `App\Providers\EventServiceProvider` içinde `$subscribe` dizi özelliğine eklemelisin.

```php
protected $subscribe = [
    'ErenMustafaOzdal\LaravelUserModule\Listeners\LaravelUserModuleListener',
];
```
`config/laravel-user-module.php` dosyasından aktivasyon e-posta blade dosyasını değiştirebilirsin. Varsayılan olarak `emails.activation` değeridir.

> Aktivasyon epostası blade dosyasına kullanıcı bilgileri (`user`) ve Sentinel Aktivasyon nesnesi gönderilmektedir (`activation`). Sentinel Aktivasyon nesnesinden `$activation->code` şeklinde kodu eposta içindeki aktivasyon bağlantısına ekleyebilirsin.

> :exclamation: Paketin bağımlılıklarından Sentinel ayar dosyasında (`config/cartalyst.sentinel.php`) *users* ve *roles* model değerlerini güncellemelisin.

```php
'users' => [
    'model' => 'App\User',
],
'roles' => [
    'model' => 'App\Role',
],
```

Kullanım
--------
### User Model
Laravel User Module kendi `User` modelini barındırmaktadır. Bu modeli kullanman için sadece `App\User` sınıfını bu modelden extend etmen gerekiyor.
```php
namespace App;

use ErenMustafaOzdal\LaravelUserModule\User as EMOUser;

class User extends EMOUser
{
    //
}
```
### Role Model
Laravel User Module kendi `Role` modelini barındırmaktadır. Bu modeli kullanman için de `App\Role` modelini oluşturman ve bu modelden extend etmen gerekiyor.
```php
namespace App;

use ErenMustafaOzdal\LaravelUserModule\Role as EMORole;

class Role extends EMORole
{
    //
}
```
### Rotalar
**Laravel User Module** aşağıdaki tabloda yer alan rotalara sahiptir. Ancak `config/laravel-user-module.php` dosyasında kendine uygun rotaları düzenleyebilirsin.

|  Tür |              Rota             |     Ayar Anahtarı     |
|----|-----------------------------|---------------------|
| get  | /login                        | login_route           |
| post | /login                        | login_route           |
| get  | /logout                       | logout_route          |
| get  | /register                     | register_route        |
| post | /register                     | register_route        |
| get  | /account-activate/{id}/{code} | activate_route        |
| get  | /forget-password              | forget_password_route |
| post | /forget-password              | forget_password_route |
| get  | /reset-password/{token}       | reset_password_route  |
| post | /reset-password               | reset_password_route  |
| get  | /admin                        | redirect_route        |

### Görünümler
Paket içinde bütün view dosyaları varsayılan olarak ayarlanmıştır. Ancak sen kendi projenin yapısına göre `config/laravel-user-module.php` dosyasında yapılandırmaları değiştirebilirsin.

|     Ayar Anahtarı     |   Varsayılan Değer   |         Görünüm Dosyası        |                  Açıklama                  |
|---------------------|--------------------|------------------------------|------------------------------------------|
| views.login           | auth.login           | auth/login.blade.php           | giriş yapılacak sayfa                      |
| views.register        | auth.register        | auth/register.blade.php        | kayıt olunacak sayfa                       |
| views.forget_password | auth.forget_password | auth/forget_password.blade.php | şifremi unuttum sayfası                    |
| views.reset_password  | auth.reset_password  | auth/reset_password.blade.php  | şifre resetleme sayfası                    |
| views.user.index      | user.index           | user/index.blade.php           | kullanıcıların listeleneceği sayfa         |
| views.user.create     | user.create          | user/create.blade.php          | yeni kullanıcı eklenecek sayfa             |
| views.user.show       | user.show            | user/show.blade.php            | kullanıcı bilgilerinin gösterileceği sayfa |
| views.user.edit       | user.edit            | user/edit.blade.php            | kullanıcı bilgilerinin düzenleneceği sayfa |
| views.role.index      | role.index           | role/index.blade.php           | rollerin listeleneceği sayfa               |
| views.role.create     | role.create          | role/create.blade.php          | yeni rol eklenecek sayfa                   |
| views.role.show       | role.show            | role/show.blade.php            | rol bilgilerinin gösterileceği sayfa       |
| views.role.edit       | role.edit            | role/edit.blade.php            | rol bilgilerinin düzenleneceği sayfa       |

##### Görünümlerde kullanılması gereken form isimleri
:exclamation: Aşağıda belirtilen form isimleri kullanılması zorunlu olup, sırası değişebilir.
> `lang/.../validation.php` dosyanda bu form isimlerinin metin değerlerini belirtmeyi unutma!

###### Auth
1. `auth.register` blade dosyası içindeki register formu
    * first_name
    * last_name
    * email
    * password
    * password_confirmation
2. `auth.login` blade dosyası içindeki login formu
    * email
    * password
    * remember

### Onaylamalar
**Laravel User Module** paketi yapılan her form isteği için onaylama kurallarını belirlemiştir. Bu tür form istek onaylama kuralları için yapmanız gereken bir şey yoktur.

### Olaylar
Paket içindeki hemen hemen tüm işlemler belli bir olayı tetikler. Sen kendi listener dosyanda bu olayları dinleyebilir ve tetiklendiğinde istediğin işlemleri kolay bir şekilde yapabilirsin.

| Olay | İsim Uzayı | Olay Verisi | Açıklama |
|------|------------|-------------|----------|
| RegisterSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı kayıt olduğunda tetiklenir |
| RegisterFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Kayıt formu verileri *(Array)* | Kayıt başarısız olduğunda tetiklenir |
| LoginSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı giriş olduğunda tetiklenir |
| LoginFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Giriş formu verileri *(Array)* | Giriş başarısız olduğunda tetiklenir |
| Logout | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Çıkış yapıldığında tetiklenir |
| ActivateSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı aktivasyon işleminde tetiklenir |
| ActivateFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Aktivasyon bağlantı bilgileri *(id,code)* | Aktivasyon işlemi başarısız olduğunda tetiklenir |
| PasswordResetMailSend | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Şifre sıfırlama e-postası gönderildiğinde tetiklenir |
| UserNotFound | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Şifremi unuttum formu verileri *(Array)* | Şifremi unuttum formundan gelen e-posta adresi ile bir kullanıcı eşleşmediğinde tetiklenir |
| PasswordResetSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı şifre sıfırlama işleminde tetiklenir |
| PasswordResetFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Şifre sıfırlama formu verileri (token dahil) *(Array)* | Şifre sıfırlama işlemi başarısız olduğunda tetiklenir |
 
 
Lisans
------
MIT
