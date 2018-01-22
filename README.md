# luminous-sms
A powerful international SMS push.


## Use
```php
	
	use AnomalyLab\LuminousSMS\Contracts\MessagerInterface;
	
	$sms = new AnomalyLab\LuminousSMS\LuminousSms([
		'default_gateway'		=> 'qclod',
		'supported'		=> [
			'qclod'		=> [
				'app_key'			=> 'app key',
				'app_id'			=> 'app id',
			],
			'yunpian'	=> [
				'app_key'
			]
		],

		'gateways'		=> [
			'qclod'			=> AnomalyLab\LuminousSMS\Gateways\Qclod::class
		]
	]);

	$sms->sender('18898726543', function(MessagerInterface $messager) {
		$messager->setCode(86)
			->setContent('{name}，您的注册码是{code}, 有效期 {time}.')
			->setRender([
				'name'	=> 'Hello sms',
				'code'	=> RandomNumber::make(6),
				'time'	=> 10
			])
	});

```