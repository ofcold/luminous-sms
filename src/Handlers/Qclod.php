<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;

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

	protected const REQUEST_METHOD = 'tlssmssvr/sendsms';

	protected const REQUEST_FORMAT = 'json';

	protected const REQUEST_VERSION = 'v5';

	/**
	 *	The gateway name.
	 *
	 *	@var		string
	 */
	protected $name = 'qclod';

	/**
	 *	@param		int|string		$to
	 *	@param		\AnomalyLab\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array
	{
		$params = [
			'tel'	=> [
				'nationcode'	=> $messager->getCode(),
				'mobile'		=> $messager->getMobilePhone()
			],
			'type'		=> $messager->getType(),
			'msg'		=> $messager->getContent(),
			'time'		=> time(),
			'extend'	=> '',
			'ext'		=> ''
		];

		$random = str_random(10);

		$params['sig'] = $this->generateSign($params, $random);

		$result = $this->post(
			sprintf('%s%s?sdkappid=%s&random=%s', self::REQUEST_URL, self::REQUEST_METHOD, $config['sdk_app_id'], $random),
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
			Configure::get($this->config, 'app_key'),
			$random,
			$params['time'],
			$params['tel']['mobile']),
			false
		);
	}
}