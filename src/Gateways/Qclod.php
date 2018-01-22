<?php

namespace AnomalyLab\LuminousSMS\Gateways;

use AnomalyLab\LuminousSMS\Exceptions\GatewayBadException;

/**
 *	Class Qclod
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Gateways\Qclod
 */
class Qclod extends Gateway
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
	 *	@param		int|string										$to
	 *	@param		\AnomalyLab\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\GatewayBadException;
	 */
	public function send($to, MessagerInterface $messager) : array
	{
		$params = [
			'tel'	=> [
				'nationcode'=> $messager->getCode(),
				'mobile'	=> $to,
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
				'headers'	=> ['Accept' => 'application/json'],
				'json'		=> $params,
			]
		);

		if ( 0 != $result['result'] )
		{
			throw new GatewayBadException($result['errmsg'], $result['result'], $result);
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
		return hash('sha256', sprintf('appkey=%s&random=%s&time=%s&mobile=%s',
			$this->config['app_key'],
			$random,
			$params['time'],
			$params['tel']['mobile']), false);
	}
}