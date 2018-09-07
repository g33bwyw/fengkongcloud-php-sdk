数美天网系统php-sdk

==============

## 安装

通过  composer 安装:

```bash
composer require bqrd/fengkongcloud-php-sdk
```

修改bootstrap/app.php 增加

```php
$app->register(Bqrd\IShuMei\FengKongCloudServiceProvider::class);
```

## 配置

增加配置文件 `config/fengkongcloud-php-sdk.php`

```php

return  [
    'version'    => '2.0',
    'requestUrl' => 'http://api.fengkongcloud.com/',
    'accessKey'  => '',
    'appId'      => '',
    'options'    => [
       'timeout' => 1.0,
    ],
];

```

## 使用

```php
use Bqrd\IShuMei\FengKongCloudFacade;
$register = [
          'tokenId' => '23432',
          'eventName' => '注册',
          'deviceId' => 'dfafasfdas',
          'ip' => '172.16.76.251',
          'signupPlatform' => 'phone',
          'phone' => '18611615170',
          'getCoupon' => 0,
];

FengKongCloudFacade::register($register); //注册

```
