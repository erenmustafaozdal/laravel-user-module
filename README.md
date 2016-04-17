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
//

Kullanım
--------
### User
##### Model
Laravel User Module kendi `User` modelini barındırmaktadır. Bu modeli kullanman için sadece `App\User` sınıfını bu modelden extend etmen gerekiyor.
```php
namespace App;

use ErenMustafaOzdal\LaravelUserModule\User as EMOUser;

class User extends EMOUser
{
    //
}
```
##### Config
Laravel User Module ayar dosyasını aşağıdaki kodla publish etmelisin. Bu ayar dosyasındaki varsayılan değerleri düzenleyebilirsin.
```bash
php artisan vendor:publish --provider="ErenMustafaOzdal\LaravelUserModule\LaravelUserModuleServiceProvider" --tag="config"
```
##### Migration
Öncelikle Laravel ile gelen `...create_users_table.php` dosyasını silin. Ardından `php artisan vendor:publish` komutu ile bütün paketleri publish edebileceğin gibi, dilersen aşağıdaki kod ile sadece Laravel User Module paketinin migration dosyalarını da publish edebilirsin.
```bash
php artisan vendor:publish --provider="ErenMustafaOzdal\LaravelUserModule\LaravelUserModuleServiceProvider" --tag="migrations"
```
###### NOT
> Migration dosyasındaki benzersiz giriş sütununu `config/laravel-user-module.php` dosyasındaki **auth_column** değerini değiştirerek; giriş işlemleri için kendine uygun bir veritabanı yapısı oluşturmuş olursun. Buradaki varsayılan değer *email*'dir.

### Role
//
### Auth
//
Lisans
------
MIT