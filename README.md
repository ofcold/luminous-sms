<p align="center"><img src="https://github.com/ofcold/luminous-sms/raw/master/sms.svg?sanitize=true"></p>
A powerful international SMS push.

## Features

1. Support the current market more than service providers.
1. Simple configuration can flexibly increase or decrease service providers.
1. Unified return format, easy to log and monitor.
1. Automatic polling Select available service providers.

## Platform support
- [腾讯云 SMS](https://cloud.tencent.com/product/sms)
- [云片](https://www.yunpian.com)
- [阿里大鱼](https://www.alidayu.com)
- [聚合数据](https://www.juhe.cn)
- [百度云](https://cloud.baidu.com)

## Environmental

- PHP >= 7.1

## Intalling

```shell
$ composer require ofcold/luminous-sms
```

## Usage

```php

use Ofcold\LuminousSMS\Contracts\MessagerInterface;

$sms = (new Ofcold\LuminousSMS\LuminousSms)
	->setConfig([
	'default_handler'		=> 'qcloud',
	'supported'		=> [
		'qcloud'			=> [
			'app_key'			=> 'app key',
			'app_id'			=> 'app id',
		],
		'yunpian'	=> [
			'app_key'
		]
	]
]);

```

#### Seeding

```php
$sms->sender(function($messager) {
	$messager
		->setMobilePhone('18898726543')
		//	Use voice.
		->setType(Ofcold\LuminousSMS\Contracts\MessagerInterface::VOICE_MESSAGE)
		->setContent('{name},您的验证码是{code}, 验证码将在{time}分钟后失效！请及时使用。')
		->setData([
			'name'	=> 'Hello',
			'code'	=> rand(100000, 999999),
			'time'	=> 10
		]);
});
```

##### OR
```php
$sms->sender([
	'mobilePhone'	=> '18898726543',
	'content'		=> '{name},您的验证码是{code}, 验证码将在{time}分钟后失效！请及时使用。',
	'data'			=> [
		'name'	=> 'Hello',
		'code'	=> rand(100000, 999999),
		'time'	=> 10
	]
]);
```

## SMS content

A message to support multi-platform send, each sent in a different way, but we abstractly define the following common attributes:

- `content` Text content, use similar to Tencent cloud to send text messages to the platform
- `template` Template ID, used in the template ID to send text messages platform
- `data`  Template variable, used in the template ID to send sms platform

## Platform configuration instructions

###### [云片](https://www.yunpian.com)

```php
    'yunpian' => [
        'api_key' => '',
    ],
```

###### [腾讯云 SMS](https://cloud.tencent.com/product/sms)

```php
    'qcloud' => [
        'app_id' => '',  // APP ID
        'app_key' => '', // APP KEY
    ],
```

###### [聚合数据](https://www.juhe.cn)

```php
    'juhe' => [
        'app_key' => '',
    ],
```


######[阿里大鱼](https://www.alidayu.cn)

```php
    'alidayu' => [
        'sign_name' => '',
        'app_key' => '',
        'app_secret' => '',
    ],
```

###### [百度云](https://cloud.baidu.com/)

```php
    'baidu' => [
        'ak' 		=> '',
        'sk' 		=> '',
        'invoke_id' => '',
        'domain'	=> '',
    ],
```

## API

```php
	Ofcold\LuminousSMS\LuminousSMS
```

##### sender(callable | array $callback, null|string $handler)

###### Arguments

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Key</th>
			<th>Required</th>
			<th>Type</th>
			<th>Default</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>$callback</td>
			<td>true</td>
			<td>callable | array</td>
			<td>none</td>
			<td>Send information data, Ofcold\LuminousSMS\Messenger::class</td>
		</tr>

		<tr>
			<td>$handler</td>
			<td>false</td>
			<td>null | string</td>
			<td>qcloud</td>
			<td>Send the drive settings using SMS. We will default to Tencent cloud sms.</td>
		</tr>
	</tbody>
</table>

## License

MIT