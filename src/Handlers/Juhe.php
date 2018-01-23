<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
use AnomalyLab\LuminousSMS\Contracts\MessagerInterface;
use AnomalyLab\LuminousSMS\Support\Configure;

/**
 *	Class Juhe
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Handlers\Juhe
 */
class Juhe extends Handler
{
	protected const REQUEST_URL = 'http://v.juhe.cn/sms/send';

	protected const REQUEST_FORMAT = 'json';

	/**
	 *	The handler name.
	 *
	 *	@var		string
	 */
	protected $name = 'juhe';

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
			'mobile'	=> $messager->getMobilePhone(),
			'tpl_id'	=> $message->getTemplate(),
			'tpl_value'	=> $this->formatTemplateData($message->getData()),
			'dtype'		=> static::REQUEST_FORMAT,
			'key'		=> Configure::get($this->config, 'app_key'),
		];

		$result = $this->get(static::REQUEST_URL, $params);

		if ( $result['error_code'] )
		{
			throw new GatewayErrorException($result['reason'], $result['error_code'], $result);
		}

		return $result;
	}

	/**
	 *	Format the template data.
	 *
	 *	@param		array		$data
	 *
	 *	@return		string
	 */
	protected function formatTemplateData(array $data) : string
	{
		$formatted = [];

		foreach ( $data as $key => $value )
		{
			$formatted[sprintf('#%s#', trim($key, '#'))] = $value;
		}

		return http_build_query($formatted);
	}
}