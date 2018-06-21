<?php

namespace Ofcold\LuminousSMS\Qcold;

use Ofcold\LuminousSMS\Results;
use Ofcold\LuminousSMS\Helpers;
use Ofcold\LuminousSMS\Exceptions\HandlerBadException;

/**
 * Class Sender
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Qcold\Sender
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Sender
{
	/**
	 * Sender SMS
	 *
	 * @return mixed
	 */
	public static function render(Qcloud $qcloud)
	{
		$method = method_exists(__CLASS__, $qcloud->getMessage()->getType())
			 ? $qcloud->getMessage()->getType()
			 : 'text';

		$params = static::$method($qcloud);

		//	Set SMS flag.
		if ( $sign = $qcloud->getMessage()->getSign() )
		{
			$params['sign']	= $sign;
		}

		//	Set the full mobile phone.
		$params['tel']	= [
			'nationcode'	=> $qcloud->getMessage()->getCode(),
			'mobile'		=> $qcloud->getMessage()->getMobilePhone()
		];

		$params['time'] = time();
		$params['ext'] = '';

		$random = Helpers::random(10);

		$params['sig'] = static::createSign($params, $random, $qcloud);

		return Results::render($qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				Qcloud::REQUEST_METHOD[$qcloud->getMessage()->getType()],
				$qcloud->getConfig('app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'  => $params,
			]
		));

	}

	/**
	 * Voicemail.
	 *
	 * Text SMS request body.
	 *
	 * @param  Qcloud  $qcloud
	 *
	 * @return  array
	 */
	protected static function text(Qcloud $qcloud) : array
	{
		return [
			'type'		=> (int)($qcloud->getMessage()->getType() !== 'text'),
			'msg'		=> $qcloud->getMessage()->getContent(),
			'extend'	=> ''
		];
	}

	/**
	 * Voicemail.
	 *
	 * Voice SMS request body.
	 *
	 * @param  Qcloud  $qcloud
	 *
	 * @return  array
	 */
	protected static function voice(Qcloud $qcloud) : array
	{
		return [
			'promptfile'	=> $qcloud->getMessage()->getContent(),
			'prompttype'	=> 2,
			'playtimes'		=> 2
		];
	}

	public static function templateId(Qcloud $qcloud)
	{

	}

	/**
	 * Generate Sign.
	 *
	 * @param  array  $params
	 * @param  string  $random
	 * @param  Qcloud  $qcloud
	 *
	 * @return  string
	 */
	protected static function createSign(array $params, string $random, Qcloud $qcloud) : string
	{
		ksort($params);

		return hash(
			'sha256',
			sprintf(
				'appkey=%s&random=%s&time=%s&mobile=%s',
				$qcloud->getConfig('app_key'),
				$random,
				$params['time'],
				$params['tel']['mobile']
			),
			false
		);
	}
}