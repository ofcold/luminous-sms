<p align="center"><img src="https://github.com/ofcold/luminous-sms/raw/master/sms.svg?sanitize=true"></p>
A powerful international SMS push.

## Features

- Support the current market more than service providers.
- Simple configuration can flexibly increase or decrease service providers.
- Unified return format, easy to log and monitor.
- Automatic polling Select available service providers.
- Full support for various api interfaces of vendors.
- Support console operation API.

## Platform support
|供应商|开发状态|时间|
|--------|--------|--------|
|[腾讯云 SMS](https://cloud.tencent.com/product/sms)|:white_check_mark:|2018-06-20|
|[云片](https://www.yunpian.com)|:clock8:|2018-06-21|
|[阿里大鱼](https://www.alidayu.com)|:x:|--|
|[百度云](https://cloud.baidu.com)|:x:|--|

## Environmental

- PHP >= 7.1

## Intalling

```shell
$ composer require ofcold/luminous-sms
```

## Usage

```php
use Ofcold\LuminousSMS\LuminousSMS;
use Ofcold\LuminousSMS\Helpers;
use Ofcold\LuminousSMS\Contracts\MessageInterface;

$sms = new LuminousSMS(include __DIR__ . '/resources/config/sms.php');

//	------------------------------------------------------------------------------------------------
//	Send Message.
$result = $sms->sender(function($messager) {
	$messager
		->setMobilePhone('18898726543')
		->setType(Ofcold\LuminousSMS\Contracts\MessageInterface::VOICE_MESSAGE)
		->setContent('您的验证码是{code}, 验证码将在2分钟后失效！请及时使用。')
		->setPaserData(['code'	=> rand(1000, 9999)]);
});

var_dump($result);

//	------------------------------------------------------------------------------------------------

//	Signature manager
//	Add
//$resuts = $sms->createHandler('qcloud')->getSignature('add', '衣衣布舍');
//
// Query
//$resuts = $sms->createHandler('qcloud')->getSignature('query', [15858, 15859]);
//
//	Edit
$resuts = $sms->createHandler('qcloud')->getSignature('edit', '150986', '你是哪里来');

var_dump($resuts);

```
## License

MIT