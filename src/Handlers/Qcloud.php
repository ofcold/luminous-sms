<?php

namespace Ofcold\LuminousSMS\Handlers;

use Ofcold\LuminousSMS\Exceptions\HandlerBadException;
use Ofcold\LuminousSMS\Contracts\MessagerInterface;
use Ofcold\LuminousSMS\Support\Arrays;
use Ofcold\LuminousSMS\Support\Stringy;

/**
 *	Class Qcloud
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Handlers\Qcloud
 */
class Qcloud extends Handler
{
	protected const REQUEST_URL = 'https://yun.tim.qq.com/v5/';

	protected const REQUEST_METHOD = [
		'text'	=> 'tlssmssvr/sendsms',
		'voice'	=> 'tlsvoicesvr/sendvoiceprompt'
	];

	protected const REQUEST_FORMAT = 'json';

	protected const REQUEST_VERSION = 'v5';

	/**
	 *	The handler name.
	 *
	 *	@var		string
	 */
	protected $name = 'qcloud';

	/**
	 *	Seed message.
	 *
	 *	The current drive service providers to implement push information content.
	 *
	 *	@param		\Ofcold\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\Ofcold\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array
	{
		$params = $this->{$this->getMethod($messager->getType())}($messager);

		//	Set SMS flag.
		if ( $sign = $messager->getSign() )
		{
			$params['sign']	= $sign;
		}

		//	Set the full mobile phone.
		$params['tel']	= [
			'nationcode'	=> $messager->getCode(),
			'mobile'		=> $messager->getMobilePhone()
		];

		$params['time'] = time();
		$params['ext'] = '';

		$random = Stringy::random(10);

		$params['sig'] = $this->generateSign($params, $random);

		$result = $this->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				static::REQUEST_URL,
				static::REQUEST_METHOD[$messager->getType()],
				Arrays::get($this->config, 'app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'		=> $params,
			]
		);

		if ( 0 != $result['result'] )
		{
			throw new HandlerBadException($result['errmsg'], $result['result'], $result);
		}

		return $result;
	}

	/**
	 *	Voicemail.
	 *
	 *	Text SMS request body.
	 *
	 *	@param		MessagerInterface		$messager
	 *
	 *	@return		array
	 */
	protected function text(MessagerInterface $messager) : array
	{
		return [
			'type'		=> (int)($messager->getType() !== 'text'),
			'msg'		=> $messager->getContent(),
			'extend'	=> ''
		];
	}

	/**
	 *	Voicemail.
	 *
	 *	Voice SMS request body.
	 *
	 *	@param		MessagerInterface		$messager
	 *
	 *	@return		array
	 */
	protected function voice(MessagerInterface $messager) : array
	{
		return [
			'promptfile'	=> $messager->getContent(),
			'prompttype'	=> 2,
			'playtimes'		=> 2
		];
	}

	/**
	 *	Generate Sign.
	 *
	 *	@param		array		$params
	 *	@param		string		$random
	 *
	 *	@return		string
	 */
	protected function generateSign(array $params, string $random) : string
	{
		ksort($params);
		return hash(
			'sha256',
			sprintf('appkey=%s&random=%s&time=%s&mobile=%s',
			Arrays::get($this->config, 'app_key'),
			$random,
			$params['time'],
			$params['tel']['mobile']),
			false
		);
	}
}