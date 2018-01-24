<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
use AnomalyLab\LuminousSMS\Contracts\MessagerInterface;
use AnomalyLab\LuminousSMS\Support\Arrays;
use AnomalyLab\LuminousSMS\Support\Stringy;

/**
 *	Class Qclod
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Handlers\Qclod
 */
class Qclod extends Handler
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
	protected $name = 'qclod';

	/**
	 *	Seed message.
	 *
	 *	The current drive service providers to implement push information content.
	 *
	 *	@param		int|string		$to
	 *	@param		\AnomalyLab\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array
	{
		$params = $this->{$messager->getType()}($messager);

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

	protected function text(MessagerInterface $messager) : array
	{
		return [
			'tel'	=> [
				'nationcode'	=> $messager->getCode(),
				'mobile'		=> $messager->getMobilePhone()
			],
			'type'		=> (int)($messager->getType() !== 'text'),
			'msg'		=> $messager->getContent(),
			'time'		=> time(),
			'extend'	=> '',
			'ext'		=> ''
		];
	}

	protected function voice(MessagerInterface $messager) : array
	{
		return [
			'tel'			=> [
				'nationcode'	=> $messager->getCode(),
				'mobile'		=> $messager->getMobilePhone()
			],
			'promptfile'	=> $messager->getContent(),
			'prompttype'	=> 2,
			'playtimes'		=> 2,
			'time'			=> time(),
			'ext'			=> ''
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