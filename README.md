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

#### Service Provider

```php
Caffeinated\Modules\ModulesServiceProvider::class,
```

Kullanım
--------
//
Lisans
------
MIT