<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
use AnomalyLab\LuminousSMS\Contracts\MessagerInterface;
use AnomalyLab\LuminousSMS\Support\Arrays;

/**
 *	Class Yunpian
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Handlers\Qclod
 */
class Yunpian extends Handler
{
	protected const REQUEST_TEMPLATE = 'https://%s.yunpian.com/%s/%s/%s.%s';

	protected const REQUEST_VERSION = 'v2';

	protected const REQUEST_FORMAT = 'json';

	/**
	 *	The handler name.
	 *
	 *	@var		string
	 */
	protected $name = 'yunpian';

	/**
	 *	Remove Yunpian SMS push does not support methods.
	 *
	 *	@var		array
	 */
	protected $removeMethods = ['voice', 'text_many', 'template_id'];

	/**
	 *	Seed message.
	 *
	 *	The current drive service providers to implement push information content.
	 *
	 *	@param		\AnomalyLab\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array
	{
		$result = $this->post(
			//	Build request url.
			sprintf(
				static::ENDPOINT_TEMPLATE,
				'sms',
				static::ENDPOINT_VERSION,
				'sms',
				'single_send',
				static::ENDPOINT_FORMAT
			),
			[
				'apikey'	=> Arrays::get($this->config, 'api_key'),
				'mobile'	=> $messager->getMobilePhone(),
				'text'		=> $message->getContent(),
			]
		);

		if ( $result['code'] )
		{
			throw new HandlerBadException($result['msg'], $result['code'], $result);
		}

		return $result;
	}
}