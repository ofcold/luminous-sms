<?php

namespace Ofcold\LuminousSMS\Handlers;

use Ofcold\LuminousSMS\Exceptions\HandlerBadException;
use Ofcold\LuminousSMS\Contracts\MessagerInterface;
use Ofcold\LuminousSMS\Support\Arrays;

/**
 *	Class Alidayu
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Handlers\Alidayu
 */
class Alidayu extends Handler
{
	protected const REQUEST_URL = 'https://eco.taobao.com/router/rest';

	protected const REQUEST_METHOD = 'alibaba.aliqin.fc.sms.num.send';

	protected const REQUEST_VERSION = '2.0';

	protected const REQUEST_FORMAT = 'json';

	/**
	 *	The handler name.
	 *
	 *	@var		string
	 */
	protected $name = 'alidayu';

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
		$params = [
			'method'				=> static::REQUEST_METHOD,
			'format'				=> static::REQUEST_FORMAT,
			'v'						=> static::REQUEST_VERSION,
			'sign_method'			=> 'md5',
			'timestamp'				=> date('Y-m-d H:i:s'),
			'sms_type'				=> 'normal',
			'sms_free_sign_name'	=> Arrays::get($this->config, 'sign_name'),
			'app_key'				=> Arrays::get($this->config, 'app_key'),
			'sms_template_code'		=> $messager->getTemplate(),
			'rec_num'				=> strval($messager->getMobilePhone()),
			'sms_param'				=> json_encode($messager->getData()),
		];

		$params['sign'] = $this->generateSign($params);
		$result = $this->post(static::REQUEST_URL, $params);

		if ( ! empty($result['error_response']) )
		{
			throw new HandlerBadException(
				$result['error_response']['sub_msg']) ?? $result['error_response']['msg'],
				$result['error_response']['code'],
				$result
			);
		}

		return $result;
	}

	/**
	 *	Generate Sign.
	 *
	 *	@param		array		$params
	 *
	 *	@return		string
	 */
	protected function generateSign(array $params) : string
	{
		ksort($params);
		$signed = Arrays::get($this->config, 'app_secret');

		foreach ( $params as $key => $value )
		{
			if ( is_string($value) && '@' != substr($value, 0, 1) )
			{
				$signed .= "$key$value";
			}
		}

		$signed .= Arrays::get($this->config, 'app_secret');
		return strtoupper(md5($signed));
	}
}