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
$card = [
	'cardID' => '123',
	'cardNo' => '123',
	'cardMon' => '100',
	'serialNo' => '111',
	'cardBalance' => '1000',
	'applyTime' => '20180404000000',
	'beginDate' => '20181212',
	'expiryDate' => '20991231',
	'isRegister' => '0',
	'rev' => ''
];

FengKongCloudFacade :: sendCard($card); //发卡

$recharge = [];
FengKongCloudFacade :: addRecharge($recharge); //充值

$consumption = [];
FengKongCloudFacade :: addConsumption($consumption); //消费

```
