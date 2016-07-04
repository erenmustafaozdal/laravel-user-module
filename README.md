Laravel User Module
===================
[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](https://laravel.com/docs/5.1/)
[![Source](https://img.shields.io/badge/source-erenmustafaozdal/laravel--user--module-blue.svg?style=flat-square)](https://github.com/erenmustafaozdal/laravel-user-module)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

**Laravel User Module**, Laravel 5.1 projelerinde *kullanıcı*, *rol* ve *giriş* işlemlerini kapsayan bir modül paketidir. Bu paket kullanıcı arayüzü **(views)** hariç, arka plandaki bütün işlemleri barındırmaktadır. İstersen görünümleri kapsayan [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketini kullanarak, modüle tam kapsamıyla sahip olabilirsin.

1. [Kurulum](#kurulum)
    1. [Dosyaların Yayınlanması](#kurulum-dosyalarinYayinlanmasi)
    2. [Migration](#kurulum-migration)
2. [Kullanım](#kullanim)
    1. [Ayar Dosyası](#kullanim-ayarDosyasi)
        1. [Genel Ayarlar](#kullanim-ayarDosyasi-genelAyarlar)
        2. [URL Ayarları](#kullanim-ayarDosyasi-urlAyarlari)
        3. [Görünüm Ayarları](#kullanim-ayarDosyasi-gorunumAyarlari)
        4. [Model Ayarları](#kullanim-ayarDosyasi-modelAyarlari)
    2. [Görünüm Tasarlama](#kullanim-gorunumTasarlama)
        1. [Model Kullanımı](#kullanim-gorunumTasarlama-modelKullanimi)
            1. [User](#kullanim-gorunumTasarlama-modelKullanimi-user)
            2. [Role](#kullanim-gorunumTasarlama-modelKullanimi-role)
        2. [Rotalar](#kullanim-gorunumTasarlama-rotalar)
            1. [Giriş - Çıkış - Kayıt Rotaları](#kullanim-gorunumTasarlama-rotalar-auth)
            2. [Kullanıcı Rotaları](#kullanim-gorunumTasarlama-rotalar-user)
            3. [Kullanıcı Rolü Rotaları](#kullanim-gorunumTasarlama-rotalar-role)
        3. [Form Alanları](#kullanim-gorunumTasarlama-formAlanlari)
            1. [Giriş - Çıkış - Kayıt Formları](#kullanim-gorunumTasarlama-formAlanlari-auth)
            2. [Kullanıcı Formları](#kullanim-gorunumTasarlama-formAlanlari-user)
            3. [Kullanıcı Rolü Formları](#kullanim-gorunumTasarlama-formAlanlari-role)
        4. [İşlem İzin Formları](#kullanim-gorunumTasarlama-islemIzinFormlari)
    3. [Onaylamalar](#kullanim-onaylamalar)
    4. [Olaylar](#kullanim-olaylar)
        1. [Giriş - Çıkış - Kayıt Olayları](#kullanim-olaylar-auth)
        2. [Kullanıcı Olayları](#kullanim-olaylar-user)
        3. [Kullanıcı Rolü Olayları](#kullanim-olaylar-role)
3. [Lisans](#lisans)


<a name="kurulum"></a>
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
        "erenmustafaozdal/laravel-user-module": "~0.1"
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
> :exclamation: Eğer **Laravel Modules Core** paketini kullanacaksan, o paketin service provider dosyasını üstte tanımlamalısın.

<a name="kurulum-dosyalarinYayinlanmasi"></a>
##### Dosyaların Yayınlanması
**Laravel User Module** paketinin dosyalarını aşağıdaki kodla yayınlamalısın.
```bash
php artisan vendor:publish --provider="ErenMustafaOzdal\LaravelUserModule\LaravelUserModuleServiceProvider"
```

<a name="kurulum-migration"></a>
##### Migration
Dosyaları yayınladıktan sonra migration işlemi yapmalısın.
> :exclamation: Migration işleminden önce Laravel'in varsayılan migration dosyalarını silmelisin. Sentinel kendi migration dosyalarını ekleyecek.

> :exclamation: Sentinel'e ait `...migration_cartalyst_sentinel.php` dosyasında **Laravel User Module**'e özgü bazı değişiklikler yapmalısın. `users` tablosunun sütunlarının belirlendiği satırlarda, `last_name` sütunundan sonra aşağıdaki gibi ekleme yapmalısın.

```php
$table->string('last_name')->nullable();        // bu satırdan sonra
$table->boolean('is_active')->default(0);       // bu satırı eklemelisin
$table->boolean('is_super_admin')->default(0);  // bu satırı da eklemelisin
$table->string('photo')->nullable();            // ve arkasından bu satırı
```
Daha sonra migrate işlemini yapabilirsin.
```bash
php artisan migrate
```

> :exclamation: Kullanıcının başarılı kayıt işlemi sonrasında tetiklenen olay ile, kullanıcıya aktivasyon e-postası göndermek gibi bazı işlemler için; `ErenMustafaOzdal\LaravelUserModule\Listeners\LaravelUserModuleListener` dinleyicisini `App\Providers\EventServiceProvider` içinde `$subscribe` dizi özelliğine eklemelisin.

```php
protected $subscribe = [
    'ErenMustafaOzdal\LaravelUserModule\Listeners\LaravelUserModuleListener',
];
```
`config/laravel-user-module.php` dosyasından aktivasyon e-posta blade dosyasını değiştirebilirsin.

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

Son olarak `App\User` ve `App\Role` modellerini uygun bir şekilde tanımlamalısın. Bunun için `App\User` modelini `ErenMustafaOzdal\LaravelUserModule\User` modelinden, `App\Role` modelini `ErenMustafaOzdal\LaravelUserModule\Role` modelinden genişletmelisin.
```php
namespace App;

use ErenMustafaOzdal\LaravelUserModule\User as EMOUser;

class User extends EMOUser
{
    //
}
```
```php
namespace App;

use ErenMustafaOzdal\LaravelUserModule\Role as EMORole;

class Role extends EMORole
{
    //
}
```

<a name="kullanim"></a>
Kullanım
--------

Kurulum tamamlandığında; [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketini de dahil ettiysen, `proje.dev/login` adresinden tüm haliyle seni bekliyor olacak.

> :exclamation: metinler yanlış görünüyorsa, [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketinin İngilizce dil dosyaları hazır olmadığı içindir. Bu sebeple projenin `config/app.php` dosyasında `'locale' => 'tr'` tanımlaması yapmalısın.

> :exclamation: ilk kullanıcı ile giriş yaptığında hiçbir rotaya erişemeyeceksin. Bunu engellemek için veri tabanında `is_super_admin` sütununu **1** olarak tanımlamalısın. bu şekilde bütün izinlere sahip olarak işlemlere devam edebilirsin.

<a name="kullanim-ayarDosyasi"></a>
### Ayar Dosyası

<a name="kullanim-ayarDosyasi-genelAyarlar"></a>
##### Genel Ayarlar
Paketin içinde kullanılan genel ayarlar. Ayar dosyası içinde kök alanda bulunan ayarlar.

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| date_format | Kullanılacak tarih formatı | d.m.Y H:i:s |
| use_register | Kullanıcı kayıt sayfası olacak mı? Eğer bu değer `true` olarak ayarlanırsa; kullanıcların kayıt olması için bir rota tanımlanacak | true |

<a name="kullanim-ayarDosyasi-urlAyarlari"></a>
##### URL Ayarları
Tarayıcının adres çubuğunda görünecek adreslerin tanımlandığı ayarlar. Ayar dosyasının `url` alanında bulunan ayarlardır.

> Örneğin: `activate_route` ayarı ile aktivasyon sayfası adresi `account-activate` şeklinde tanımlanmıştır. Bu şekilde adres çubuğunda şuna benzer bir görünüm olacaktır: `www.siteadi.com/account-activate/{id}/{code}`

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| login_route | Giriş sayfası adresi | login |
| logout_route | Çıkış sayfası adresi | logout |
| register_route | Eğer kayıt sayfası olacaksa, kullanıcıların kayıt olacağı sayfanın adresi | register |
| activate_route | Eğer kayıt sayfası olacaksa, kullanıcıların kayıt sonrası aktivasyon adresi | account-activate |
| forget_password_route | Şifre sıfırlama sayfası adresi | forget-password |
| reset_password_route | Şifre sıfırlama e-postası sonrası gelinecek sıfırlama adresi | reset-password |
| user | Kullanıcı oluşturma, düzenleme vb. sayfalarda kullanılacak adres | users |
| role | Kullanıcı rolü oluşturma, düzenleme vb. sayfalarda kullanılacak adres | roles |
| redirect_route | giriş yapan kullanıcının yönlendirileceği adresin rota adı (`route name`). Ör: dashboard | admin |
| admin_url_prefix | Yönetim panelinin adres çubuğundaki ön adı. Örneğin: `www.siteadi.com/admin/users` | admin |

<a name="kullanim-ayarDosyasi-gorunumAyarlari"></a>
##### Görünüm Ayarları
Paketin kullanacağı görünümlerin tanımlandığı ayarlardır. Ayar dosyasının `views` alanı altında bulunan ayarlardır. Buradaki değerler varsayılan olarak [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketinin görünümlerine tanımlıdır.

| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
|auth.layout | Giriş, kayıt gibi sayfaların şablon görünümü | laravel-modules-core::layouts.auth |
| auth.login | Giriş sayfası görünümü | laravel-modules-core::auth.login |
| auth.register | Kayıt sayfası görünümü | laravel-modules-core::auth.register |
| auth.forget_password | Şifremi unuttum sayfası görünümü | laravel-modules-core::auth.forget_password |
| auth.reset_password | Şifre sıfırlama sayfası görünümü | laravel-modules-core::auth.reset_password |
| user.layout | Kullanıcı sayfaları şablon görünümü | laravel-modules-core::layouts.admin |
| user.index | Kullanıcıların listelendiği sayfanın görünümü | laravel-modules-core::user.index |
| user.create | Kullanıcı ekleme sayfasının görünümü | laravel-modules-core::user.create |
| user.show | Kullanıcı bilgilerinin olduğu sayfanın görünümü | laravel-modules-core::user.show |
| user.edit | Kullanıcı bilgilerinin düzenlendiği sayfanın görünümü | laravel-modules-core::user.edit |
| role.layout | Kullanıcı rolü sayfaları şablon görünümü | laravel-modules-core::layouts.admin |
| role.index | Kullanıcı rollerinin listelendiği sayfanın görünümü | laravel-modules-core::role.index |
| role.create | Kullanıcı rolü ekleme sayfasının görünümü | laravel-modules-core::role.create |
| role.show | Kullanıcı rolü bilgilerinin olduğu sayfanın görünümü | laravel-modules-core::role.show |
| role.edit | Kullanıcı rolü bilgilerinin düzenlendiği sayfanın görünümü | laravel-modules-core::role.edit |
| email.activation | Aktivasyon e-postası görünümü | laravel-modules-core::emails.activation |
| email.forget_password | Şifremi unuttum e-postası görünümü | laravel-modules-core::emails.forget_password |


<a name="kullanim-ayarDosyasi-modelAyarlari"></a>
##### Model Ayarları
Paket içinde kullanılan modeller ile ilgili bazı ayarlamalar. Şu an için sadece `User` modeli ayarları mevcut. Ve bu ayar da; ayar dosyasının `user` alanında bulunmaktadır.


| Ayar | Açıklama | Varsayılan Değer |
|---|---|---|
| avatar_path | Varsayılan avatar fotoğraflarının farklı boyutlarda bulunduğu dizini tanımlar. Burada dikkat edilmesi gereken iki nokta vardır: Birincisi, bu dizin içindeki fotoğrafların isimleri aşağıda tanımlanacak `thumbnails` isimleri ile benzer olmalıdır. İkincisi, dosyalar `.jpg` formatında olmalıdır. Varsayılan değer **Laravel Modules Core** paketine tanımlıdır. | vendor/laravel-modules-core/assets/global/img/avatar |
| uploads.column | Veri tabanındaki fotoğraf sütunu adı | photo |
| uploads.path | Fotoğrafların yükleneceği dosya yolu | uploads/user |
| uploads.thumbnails | Fotoğrafın orjinal hali yukarıdaki dosya yolundan sonra `{id}/original` dizini içine kayıt edilir. Burada ise istenilen adette küçük fotoğraf kayıt edilmesi için tanımlama yapılmalıdır. Ayar formatı dosya içinde anlatıldığı için burada sadece bir örnek verilecektir. | `'smallest' => [ 'width' => 35, 'height' => 35]` |


<a name="kullanim-gorunumTasarlama"></a>
### Görünüm Tasarlama
Paket [Laravel Modules Core](https://github.com/erenmustafaozdal/laravel-modules-core) paketiyle beraber direkt kullanıma hazırdır. Ancak istersen kendine özel görünümlerde tasarlayabilirsin. Bu bölüm özel tasarımlar için bir rehberdir.

<a name="kullanim-gorunumTasarlama-modelKullanimi"></a>
##### Model Kullanımı
Görünümler içinde `User` ve `Role` modellerinin özellik ve metot kullanımı hakkında bilgileri kapsamaktadır. Bu metotlar ve özellikler `App\User` ve `App\Role` içinde üzerine yazılarak değiştirilebilir.

<a name="kullanim-gorunumTasarlama-modelKullanimi-user"></a>
###### User

####### Genel Özellikler
1. **protected $table =** 'users'
2. **protected $fillable =** ['first_name', 'last_name', 'email', 'password', 'is_active', 'photo','permissions']
3. **protected $hidden =** ['password', 'remember_token']

####### $user->getPhoto()
Kullanıcı fotoğrafını HTLM `img` etiketi ile veya sadece url olarak geri döndürür. Eğer fotoğraf yoksa, varsayılan fotoğrafı geri döndürür

| Parametre | Açıklama | Tür | Varsayılan Değer |
|---|---|---|---|
| $attributes | HTML `img` etiketi içinde yer alacak özellikler. Örneğin: *class => 'img-responsive'* | array | [] |
| $type | İstenen resmin türü nedir? `original` değeri fotoğrafın orjinal halini döndürür. Bunun dışında da; ayar dosyasında *thumbnails* alanında belirttiğin isimlerden biri ile çağırabilirsin | string | 'original' |
| $onlyUrl | Resim HTML olarak mı, url olarak mı isteniyor? `true` değeri sadece url'yi geri döndürür | boolean | false |

####### $user->first_name `string`
Baş harfi büyük şekilde kullanıcı ilk adı

####### $user->last_name `string`
Bütün harfler büyük şekilde kullanıcı soyadı

####### $user->fullname `string`
Kullanıcı ilk ve soyadı birleşimi

####### $user->is_active `boolean`
Kullanıcının aktif olup olmadığını döndürür

####### $user->last_login `string`
Kullanıcının son giriş yaptığı tarihi ayar dosyasındaki tanıma göre döndürür

####### $user->last_login_for_humans `string`
Kullanıcının son giriş yaptığı tarihi okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $user->last_login_table `array`
Kullanıcının son giriş yaptığı tarihi `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

####### $user->permissions `array`
Kullanıcı işlem izinlerini dizi şeklinde döndürür

####### $user->permission_collect `Collection`
Kullanıcı işlem izinlerini *Collection objesi* şeklinde döndürür

####### $user->created_at `string`
Kullanıcının kayıt tarihini ayar dosyasındaki tanıma göre döndürür

####### $user->created_at_for_humans `string`
Kullanıcının kayıt tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $user->created_at_table `array`
Kullanıcının kayıt tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

####### $user->updated_at `string`
Kullanıcının güncellenme tarihini ayar dosyasındaki tanıma göre döndürür

####### $user->updated_at_for_humans `string`
Kullanıcının güncellenme tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $user->updated_at_table `array`
Kullanıcının güncellenme tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

<a name="kullanim-gorunumTasarlama-modelKullanimi-role"></a>
###### Role

####### Genel Özellikler
1. **protected $table =** 'roles'
2. **protected $fillable =** ['name', 'slug', 'permissions']

####### $role->name `string`
Baş harfi büyük şekilde kullanıcı rolü adı

####### $role->slug `string`
Kullanıcı rolü url formatındaki hali

####### $role->permissions `array`
Kullanıcı rolü işlem izinlerini dizi şeklinde döndürür

####### $role->permission_collect `Collection`
Kullanıcı rolü işlem izinlerini *Collection objesi* şeklinde döndürür

####### $role->created_at `string`
Kullanıcı rolünün kayıt tarihini ayar dosyasındaki tanıma göre döndürür

####### $role->created_at_for_humans `string`
Kullanıcı rolünün kayıt tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $role->created_at_table `array`
Kullanıcı rolünün kayıt tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur

####### $role->updated_at `string`
Kullanıcı rolünün güncellenme tarihini ayar dosyasındaki tanıma göre döndürür

####### $role->updated_at_for_humans `string`
Kullanıcı rolünün güncellenme tarihini okunaklı veri şeklinde döndürür. Örneğin: *1 hafta önce*

####### $role->updated_at_table `array`
Kullanıcı rolünün güncellenme tarihini `display`(last_login_for_humans) ve `timestamp` şeklinde tutulan bir dizi şeklinde döndürür. Datatable'da kullanılması amacıyla oluşturulmuştur



<a name="kullanim-gorunumTasarlama-rotalar"></a>
##### Rotalar
**Laravel User Module** paketi *CRUD* işlemleri için sahip olduğu rotaların dışında, `ajax` ile işlem yapabileceğin birçok rotaya da sahiptir. Görünümlerini tasarlarken bunları kullanabilirsin.

> Rotalarda kullanılabilecek form elemanları bir sonraki bölümde anlatılacaktır.

<a name="kullanim-gorunumTasarlama-rotalar-auth"></a>
###### Giriş - Çıkış - Kayıt Rotaları
Giriş, çıkış, kayıt, şifre hatırlatma vb. işlemler için kullanılan rotalardır.

| Rota Adı | Açıklama | Tür|
|---|---|---|
| getLogin | Giriş sayfası | GET |
| postLogin | Giriş sayfasından form verilerinin gönderildiği sayfa | POST |
| getLogout | Çıkış sayfası | GET |
| getRegister | Kayıt sayfası | GET |
| postRegister | Kayıt sayfasından form verilerinin gönderildiği sayfa | POST |
| accountActivate | Kayıt sonrası hesabın aktifleştirileceği rota. Bu rotada kullanıcı `id`si ve Sentinel Activation tarafından üretilen `code` kullanılıyor. Paket kayıt sonrası bu adresi direkt kullanıcıya e-posta olarak gönderiyor. | GET |
| getForgetPassword | Şifremi unuttum sayfası | GET |
| postForgetPassword | Şifremi unuttum sayfasından form verilerinin gönderildiği sayfa | POST |
| getResetPassword | Şifre sıfırlama sayfası. Şifremi unuttum işlemi sonrası paket kullanıcıya *şifre sıfırlama* e-postası gönderir. Bu bağlantı burada kullanıcıya ulaşmış olur | GET |
| postResetPassword | Şifre sıfırlama sayfasından form verilerinin gönderildiği sayfa | POST |

<a name="kullanim-gorunumTasarlama-rotalar-user"></a>
###### Kullanıcı Rotaları
Başta kullanıcı CRUD işlemleri olmak üzere, bir kısım *ajax* işlemini de kapsayan rotalar.

| Rota Adı | Açıklama | Tür|
|---|---|---|
| admin.user.index | Kullanıcıların listelendiği sayfa | GET |
| admin.user.create | Yeni kullanıcı eklendiği sayfa | GET |
| admin.user.store | Yeni kullanıcı eklendiği sayfadan form verilerinin gönderildiği sayfa | POST |
| admin.user.show | Kullanıcı bilgilerinin gösterildiği sayfa. Bu sayfayı oluşturulacak görünümlere `$user` değişkeni aktarılır. | GET |
| admin.user.edit | Kullanıcı bilgilerinin düzenlendiği sayfa. Bu sayfayı oluşturulacak görünümlere `$user` değişkeni aktarılır. | GET |
| admin.user.update | Kullanıcı bilgilerinin düzenlendiği sayfadan form verilerinin gönderildiği sayfa | PUT-PATCH |
| admin.user.destroy | Kullanıcının silindiği sayfa | DELETE |
| admin.user.changePassword | Kullanıcı şifresininin güncellenmesi için form verilerinin gönderildiği sayfa | POST |
| admin.user.permission | Kullanıcı işlem izinleri verilerinin gönderileceği sayfa. Kullanıcı izinleri formunu oluşturman için aşağıda bir bahis daha geçecek. | POST |
| api.user.index | Bu rotada ajax ile Datatable türü veriler çekilir. Gelen sütunlar şunlardır: `id`, `photo`, `fullaname` *(first_name ve last_name sütunlarından oluşturulur)*, `created_at`, `status` *(is_active sütunundan oluşturulur)*, `urls` *(tablonun eylemler sütununda kullanılmak üzere oluşturulmuş bazı adreslerdir.)*. Bütün bunlar dışında `action=filter` verisi ile birlikte; *id*, *first_name*, *last_name*, *status*, *created_at_from* ve *created_at_to* verileri gönderilerek; filtrelenmiş veriler elde edebilirsin | GET |
| api.user.store | Yeni kullanıcı eklenmesi için verilerin gönderildiği sayfa. Fotoğraf dışında bütün veriler gönderilebilir | POST |
| api.user.update | Kullanıcı bilgilerinin düzenlenmesi için verilerin gönderildiği sayfa. Fotoğraf dışında bütün veriler gönderilebilir. | PUT-PATCH |
| api.user.destroy | Kullanıcının silinmesi için verilerin gönderildiği sayfa | DELETE |
| api.user.group | Kullanıcılar üzerinde grup işlemleri yapmak için kullanılan bir rota. Aktifleştirme, aktifliği kaldırma ve silme işlemlerini destekliyor. `action=activate` gibi bir veri ile birlikte, dizi içinde işlem yapılacak kullanıcı id'leri gönderilir. Aşağıda veri detayları açıklanmıştır. | POST |
| api.user.detail | Kullanıcı id'si iliştirilmiş rota ile kullanıcı *id*, *email*, *last_login*, *updated_at*, *roles* (virgül ile ayrılmış metin türünde) bilgileri Datatable formatında gönderilir | GET |
| api.user.fastEdit | Hızlı bir şekilde kullanıcı bilgisini düzenlemek için; bilgilerin çekildiği rotadır. Rotaya kullanıcı id'si iliştirilir ve kullanıcı bilgilerinin tamamı çekilir | POST |
| api.user.activate | Id'si iliştirilen kullanıcının hesabını aktifleştirildiği rota | POST |
| api.user.notActivate | Id'si iliştirilen kullanıcının hesabınının aktifliğinin kaldırıldığı rota | POST |
| api.user.avatarPhoto | Kullanıcının fotoğrafının eklendiği rota. Eski fotoğrafı siler ve yeni fotoğrafı ayar dosyasına göre ekler | POST |
| api.user.destroyAvatar | Id'si iliştirilen kullanıcının fotoğrafını siler ve varsayılan fotoğrafın tekrar kullanılmasını sağlar | POST |


<a name="kullanim-gorunumTasarlama-rotalar-role"></a>
###### Kullanıcı Rolü Rotaları
Başta kullanıcı rolü CRUD işlemleri olmak üzere, bir kısım *ajax* işlemini de kapsayan rotalar.

| Rota Adı | Açıklama | Tür|
|---|---|---|
| admin.role.index | Kullanıcı rollerinin listelendiği sayfa | GET |
| admin.role.create | Yeni kullanıcı rolü eklendiği sayfa | GET |
| admin.role.store | Yeni kullanıcı rolü eklendiği sayfadan form verilerinin gönderildiği sayfa | POST |
| admin.role.show | Kullanıcı rolü bilgilerinin gösterildiği sayfa. Bu sayfayı oluşturulacak görünümlere `$role` değişkeni aktarılır. | GET |
| admin.role.edit | Kullanıcı rolü bilgilerinin düzenlendiği sayfa. Bu sayfayı oluşturulacak görünümlere `$role` değişkeni aktarılır. | GET |
| admin.role.update | Kullanıcı rolü bilgilerinin düzenlendiği sayfadan form verilerinin gönderildiği sayfa | PUT-PATCH |
| admin.role.destroy | Kullanıcı rolünün silindiği sayfa | DELETE |
| api.role.index | Bu rotada ajax ile Datatable türü veriler çekilir. Gelen sütunlar şunlardır: `id`, `name`, `slug`, `created_at`, `urls` *(tablonun eylemler sütununda kullanılmak üzere oluşturulmuş bazı adreslerdir.)*. Bütün bunlar dışında `action=filter` verisi ile birlikte; *id*, *name*, *slug*, *created_at_from* ve *created_at_to* verileri gönderilerek; filtrelenmiş veriler elde edebilirsin | GET |
| api.role.store | Yeni kullanıcı rolü eklenmesi için verilerin gönderildiği sayfa | POST |
| api.role.update | Kullanıcı rolü bilgilerinin düzenlenmesi için verilerin gönderildiği sayfa | PUT-PATCH |
| api.role.destroy | Kullanıcı rolünün silinmesi için verilerin gönderildiği sayfa | DELETE |
| api.role.models | Kullanıcı rollerinin isme veya url tanımlamasına göre filtrelenip döndürüldüğü rota  | POST |
| api.role.group | Kullanıcı rolleri üzerinde grup işlemleri yapmak için kullanılan bir rota. Silme işlemini destekliyor. `action=destroy` şeklinde bir veri ile birlikte, dizi içinde işlem yapılacak kullanıcı id'leri gönderilir. Aşağıda veri detayları açıklanmıştır. | POST |
| api.role.detail | Kullanıcı rolü id'si iliştirilmiş rota ile kullanıcı rolü *id*, *name*, *slug*, *created_at*, *updated_at* bilgileri Datatable formatında gönderilir | GET |
| api.role.fastEdit | Hızlı bir şekilde kullanıcı rolü bilgisini düzenlemek için; bilgilerin çekildiği rotadır. Rotaya kullanıcı rolü id'si iliştirilir ve kullanıcı rolü bilgilerinin tamamı çekilir | POST |



<a name="kullanim-gorunumTasarlama-formAlanlari"></a>
##### Form Alanları
İşlemler sırasında görünümlerinde kullanacağın form elemanları veri tabanı tablolarındaki sütun isimleriyle aynı olmalıdır. Aşağıda her işlem için gereken eleman listesi verilmiştir.

:exclamation: Aşağıda belirtilen form isimleri kullanılması zorunlu olup, sırası değişebilir.

> `lang/.../validation.php` dosyanda bu form isimlerinin metin değerlerini belirtmeyi unutma! Ayrıca her dil için validation dosyası oluşturmalısın.

<a name="kullanim-gorunumTasarlama-formAlanlari-auth"></a>
###### Giriş - Çıkış - Kayıt Formları

* `register` işlemi form elemanları
    * first_name
    * last_name
    * email
    * password
    * password_confirmation
    * terms

**RegisterRequest**

```php
public function rules()
{
    return [
        'first_name'    => 'required|max:255',
        'last_name'     => 'required|max:255',
        'email'         => 'required|unique:users|email|max:255',
        'password'      => 'required|confirmed|min:6|max:255',
        'terms'         => 'required|in:1|accepted'
    ];
}
```

* `login` işlemi form elemanları
    * email
    * password
    * remember

**LoginRequest**

```php
public function rules()
{
    return [
        'email'         => 'required|email|max:255',
        'password'      => 'required|min:6|max:255',
    ];
}
```

* `forgetPassword` işlemi form elemanları
    * email

**ForgetPasswordRequest**

```php
public function rules()
{
    return [
        'email'         => 'required|email|max:255',
    ];
}
```

* `resetPassword` işlemi form elemanları
    * email
    * password
    * password_confirmation

**ResetPasswordRequest**

```php
public function rules()
{
    return [
        'email'         => 'required|email|max:255',
        'password'      => 'required|confirmed|min:6|max:255',
    ];
}
```

<a name="kullanim-gorunumTasarlama-formAlanlari-user"></a>
###### Kullanıcı Formları

* `store` işlemi form elemanları
    * first_name
    * last_name
    * email
    * password
    * password_confirmation
    * photo
    * x (fotoğraf kırpılacaksa; kırpılacak halin sol üst köşe konumu x değeri)
    * y (fotoğraf kırpılacaksa; kırpılacak halin sol üst köşe konumu y değeri)
    * width (fotoğraf kırpılacaksa; kırpılacak halin width değeri)
    * height (fotoğraf kırpılacaksa; kırpılacak halin height değeri)
    * permissions

**StoreRequest**

```php
public function rules()
{
    return [
        'first_name'    => 'required|max:255',
        'last_name'     => 'required|max:255',
        'email'         => 'required|unique:users|email|max:255',
        'password'      => 'required|confirmed|min:6|max:255',
        'photo'         => 'max:5120|image|mimes:jpeg,jpg,png',
        'x'             => 'integer',
        'y'             => 'integer',
        'width'         => 'integer',
        'height'        => 'integer',
        'permissions'   => 'array',
    ];
}
```

* `update` işlemi form elemanları
    * first_name
    * last_name
    * email
    * password
    * password_confirmation
    * photo
    * x (fotoğraf kırpılacaksa; kırpılacak halin sol üst köşe konumu x değeri)
    * y (fotoğraf kırpılacaksa; kırpılacak halin sol üst köşe konumu y değeri)
    * width (fotoğraf kırpılacaksa; kırpılacak halin width değeri)
    * height (fotoğraf kırpılacaksa; kırpılacak halin height değeri)
    * permissions

**UpdateRequest**

```php
public function rules()
{
    return [
        'first_name'    => 'required|max:255',
        'last_name'     => 'required|max:255',
        'slug'          => 'email|max:255|unique:users,slug,'.$this->segment(3),
        'password'      => 'confirmed|min:6|max:255',
        'photo'         => 'max:5120|image|mimes:jpeg,jpg,png',
        'x'             => 'integer',
        'y'             => 'integer',
        'width'         => 'integer',
        'height'        => 'integer',
        'permissions'   => 'array',
    ];
}
```

* `changePassword` işlemi form elemanları
    * password
    * password_confirmation

**PasswordRequest**

```php
public function rules()
{
    return [
        'password'      => 'required|confirmed|min:6|max:255'
    ];
}
```

* `permission` işlemi form elemanları
    * permissions

**PermissionRequest**

```php
public function rules()
{
    return [
        'permissions'      => 'array'
    ];
}
```

* Api `index` filtreleme işlemi verileri
    * action=filter
    * id
    * first_name
    * last_name
    * status (is_active sütunu filtrelemesi için; 1 veya 0)
    * created_at_from
    * created_at_to

* Api `store` işlemi verileri, yukarıdaki *store* işlemi ile aynıdır. Sadece fotoğraf verileri kullanılmaz

* Api `update` işlemi verileri, yukarıdaki *update* işlemi ile aynıdır. Sadece fotoğraf verileri kullanılmaz

* Api `group` işlemi verileri
    * action=activate|not_activate|destroy
    * id (array şeklinde model id'leri)

* Api `avatarPhoto` işlemi verileri,
    * photo
    * x (fotoğraf kırpılacaksa; kırpılacak halin sol üst köşe konumu x değeri)
    * y (fotoğraf kırpılacaksa; kırpılacak halin sol üst köşe konumu y değeri)
    * width (fotoğraf kırpılacaksa; kırpılacak halin width değeri)
    * height (fotoğraf kırpılacaksa; kırpılacak halin height değeri)

**PhotoRequest**

```php
public function rules()
{
    return [
        'photo'     => 'required|max:5120|image|mimes:jpeg,jpg,png',
        'x'         => 'integer',
        'y'         => 'integer',
        'width'     => 'integer',
        'height'    => 'integer',
    ];
}
```

<a name="kullanim-gorunumTasarlama-formAlanlari-role"></a>
###### Kullanıcı Rolü Formları

* `store` işlemi form elemanları
    * name
    * slug
    * permissions

**StoreRequest**

```php
public function rules()
{
   return [
        'name'          => 'required|max:255',
        'slug'          => 'alpha_dash|max:255|unique:roles',
        'permissions'   => 'array',
    ];
}
```

* `update` işlemi form elemanları
    * name
    * slug
    * permissions

**UpdateRequest**

```php
public function rules()
{
    return [
        'name'          => 'max:255',
        'slug'          => 'alpha_dash|max:255|unique:roles,slug,'.$this->segment(3),
        'permissions'   => 'array',
    ];
}
```

* Api `index` filtreleme işlemi verileri
    * action=filter
    * id
    * name
    * slug
    * created_at_from
    * created_at_to

* Api `store` işlemi verileri, yukarıdaki *store* işlemi ile aynıdır

* Api `update` işlemi verileri, yukarıdaki *update* işlemi ile aynıdır

* Api `group` işlemi verileri
    * action=destroy
    * id (array şeklinde model id'leri)

* Api `models` işlemi verileri
    * query (metin şeklinde gönderilir ve `name`, `slug` alanlarında `like` yöntemi ile filtreleme yapar)


<a name="kullanim-gorunumTasarlama-islemIzinFormlari"></a>
##### İşlem İzin Formları
Hem kullanıcı hem de rol işlem izinleri formu oluşturmak çok kolaydır. **Laravel User Module** bu işlem için `ErenMustafaOzdal\LaravelUserModule\Services\PermissionService` sınıfını kullanmaktadır. Bu sınıf `admin` ve `api` rota adı başlangıcına sahip tüm tanımlı rotaları alır ve `Collection` türünde döndürür. Bu şekilde izinleri *checkbox* ile foreach kullanarak listeleyebilirsin. Örnek kullanım için öncelikle formu oluşturacağın blade dosyasına bu sınıfı enjekte et, daha sonra da listeleme yap.

```php
@inject('permission', 'ErenMustafaOzdal\LaravelUserModule\Services\PermissionService')

<ul>
@foreach($permission->groupByController() as $namespace => $routes)

    <li>
        <span class="route-name">{!! $route['route'] !!}</span>
        {!! Form::checkbox( "permissions[{$route['route']}]", true, isset($permissions[$route['route']]) ) !!}
    </li>

@endforeach
</ul>
```

###### $permission->getCollection()
`Illuminate\Routing\RouteCollection` türünden bir liste döndürür

###### $permission->getNames()
`Illuminate\Support\Collection` türünden bir liste döndürür. Bu listenin `all` anahtarında bütün rotalar yer alır. `admin` ve `api` anahtarlarında ise ilgili rota listeleri yer alır.

###### $permission->getSpecificNames($prefix)
`Illuminate\Support\Collection` türünden bir liste istenen ön ada sahip rota ismi listesi döndürür. Örneğin: *api*

###### $permission->getNameParts()
`Illuminate\Support\Collection` türünden bir liste döndürür. `$permission->getNames()` metodundan tek farkı `all` anahtarı olmayışıdır.

###### $permission->getAllNames()
`Illuminate\Support\Collection` türünden bir liste döndürür. Sadece `all` anahtarındaki listeyi barındırır.

###### $permission->groupByController()
`Illuminate\Support\Collection` türünden *Controller* türüne göre gruplandırılmış şekilde bütün rotaları döndürür

###### $permission->permissionCount()
İşlem izin sayısını, yani rota ismi sayısını döndürür

###### $permission->permissionRate($count)
Metoda gönderilen kullanıcı veya kullanıcı rolü izinli işlem sayısı sonucunda; yüzde kaç yetkiye sahip olduğunu döndürür. Döndürdüğü değer türü: *integer*



<a name="kullanim-onaylamalar"></a>
### Onaylamalar
**Laravel User Module** paketi yapılan her form isteği için onaylama kurallarını belirlemiştir. Bu tür form istek onaylama kuralları için yapman gereken bir şey yoktur. Yukarıda `Request` sınıflarının `rules` metotlarında açıklamaları yapılmıştır.


<a name="kullanim-olaylar"></a>
### Olaylar
Paket içindeki hemen hemen tüm işlemler belli bir olayı tetikler. Sen kendi listener dosyanda bu olayları dinleyebilir ve tetiklendiğinde istediğin işlemleri kolay bir şekilde yapabilirsin.

<a name="kullanim-olaylar-auth"></a>
##### Giriş - Çıkış - Kayıt Olayları

| Olay | İsim Uzayı | Olay Verisi | Açıklama |
|------|------------|-------------|----------|
| RegisterSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı kayıt olduğunda tetiklenir |
| RegisterFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Kayıt formu verileri *(Array)* | Kayıt başarısız olduğunda tetiklenir |
| LoginSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı giriş olduğunda tetiklenir |
| LoginFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Giriş formu verileri *(Array)* | Giriş başarısız olduğunda tetiklenir |
| Logout | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Çıkış yapıldığında tetiklenir |
| ActivateSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı aktivasyon işleminde tetiklenir |
| ActivateRemove | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı aktifliği kaldırma işleminde tetiklenir |
| ActivateFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Aktivasyon bağlantı bilgileri *(id,code)* | Aktivasyon işlemi başarısız olduğunda tetiklenir |
| PasswordResetMailSend | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Şifre sıfırlama e-postası gönderildiğinde tetiklenir |
| ForgetPasswordFail | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Şifremi unuttum formu verileri *(Array)* | Şifremi unuttum formundan gelen e-posta adresi ile bir kullanıcı eşleşmediğinde tetiklenir |
| ResetPasswordSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Başarılı şifre sıfırlama işleminde tetiklenir |
| PasswordResetUserNotFound | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Şifre sıfırlama formu verileri (token dahil) *(Array)* | Şifre sıfırlama işlemi sırasında gönderilen e-posta adresi ile bağlantılı bir hesap bulunamadığında tetiklenir |
| ResetPassowrdIncorrectCode | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | User Model | Şifre sıfırlama bağlantısında bulunan kod yanlış olduğunda tetiklenir |
| SentinelNotActivated | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Sentinel NotActivatedException | Giriş işlemi yapmak isteyen kullanıcı aktif bir kullanıcı değilse tetiklenir |
| SentinelThrottling | `ErenMustafaOzdal\LaravelUserModule\Events\Auth` | Sentinel ThrottlingException | Üst üste yanlış hatalı giriş yapıldığında Sentinel tarfında fırlatılan hata olduğunda tetiklenir |
 

<a name="kullanim-olaylar-user"></a>
##### Kullancı Olayları

| Olay | İsim Uzayı | Olay Verisi | Açıklama |
|------|------------|-------------|----------|
| StoreSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\User` | User Model | Ekleme işlemi başarılı olduğunda tetiklenir |
| StoreFail | `ErenMustafaOzdal\LaravelUserModule\Events\User` | Form verileri *(Array)* | Ekleme işlemi başarısız olduğunda tetiklenir |
| UpdateSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\User` | User Model | Düzenleme işlemi başarılı olduğunda tetiklenir |
| UpdateFail | `ErenMustafaOzdal\LaravelUserModule\Events\User` | User Model | Düzenleme işlemi başarısız olduğunda tetiklenir |
| DestroySuccess | `ErenMustafaOzdal\LaravelUserModule\Events\User` | User Model | Silme işlemi başarılı olduğunda tetiklenir |
| DestroyFail | `ErenMustafaOzdal\LaravelUserModule\Events\User` | User Model | Silme işlemi başarısız olduğunda tetiklenir |
 

<a name="kullanim-olaylar-role"></a>
##### Kullancı Rolü Olayları

| Olay | İsim Uzayı | Olay Verisi | Açıklama |
|------|------------|-------------|----------|
| StoreSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Role` | Role Model | Ekleme işlemi başarılı olduğunda tetiklenir |
| StoreFail | `ErenMustafaOzdal\LaravelUserModule\Events\Role` | Form verileri *(Array)* | Ekleme işlemi başarısız olduğunda tetiklenir |
| UpdateSuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Role` | Role Model | Düzenleme işlemi başarılı olduğunda tetiklenir |
| UpdateFail | `ErenMustafaOzdal\LaravelUserModule\Events\Role` | Role Model | Düzenleme işlemi başarısız olduğunda tetiklenir |
| DestroySuccess | `ErenMustafaOzdal\LaravelUserModule\Events\Role` | Role Model | Silme işlemi başarılı olduğunda tetiklenir |
| DestroyFail | `ErenMustafaOzdal\LaravelUserModule\Events\Role` | Role Model | Silme işlemi başarısız olduğunda tetiklenir |
 
 
 <a name="lisans"></a>
Lisans
------
MIT
