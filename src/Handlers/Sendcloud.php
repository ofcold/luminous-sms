<?php

namespace Ofcold\LuminousSMS\Handlers;

use Ofcold\LuminousSMS\Exceptions\HandlerBadException;
use Ofcold\LuminousSMS\Contracts\MessagerInterface;
use Ofcold\LuminousSMS\Support\Arrays;
use Ofcold\LuminousSMS\Support\Stringy;

/**
 *	Class Sendcloud
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Handlers\Sendcloud
 */
class Sendcloud extends Handler
{
	const REQUEST_TEMPLATE = 'http://www.sendcloud.net/smsapi/%s';

	/**
	 *	The handler name.
	 *
	 *	@var		string
	 */
	protected $name = 'sendcloud';

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
			'smsUser'		=> Arrays::get($this->config, 'sms_user'),
			'templateId'	=> $message->getTemplate($this),
			'phone'			=> is_array($to) ? implode(',', $to) : $to,
			'vars'			=> $this->formatTemplateVars($message->getData($this)),
		];

		if ( $config->get('timestamp', false) )
		{
			$params['timestamp'] = time() *	1000;
		}

		$params['signature'] = $this->sign($params, Arrays::get($this->config, 'sms_key'));
		$result = $this->post(sprintf(self::REQUEST_TEMPLATE, 'send'), $params);

		if ( !$result['result'] )
		{
			throw new HandlerBadException($result['message'], $result['statusCode'], $result);
		}
		return $result;
	}

	/**
	 *	@param		array		$vars
	 *
	 *	@return		string
	 */
	protected function formatTemplateVars(array $vars) : string
	{
		$formatted = [];
		foreach ( $vars as $key => $value )
		{
			$formatted[sprintf('%%%s%%', trim($key, '%'))] = $value;
		}

		return json_encode($formatted, JSON_FORCE_OBJECT);
	}

	/**
	 *	@param		array		$params
	 *	@param		string		$key
	 *
	 *	@return		string
	 */
	protected function sign($params, $key)
	{
		ksort($params);
		return md5(sprintf('%s&%s&%s', $key, urldecode(http_build_query($params)), $key));
	}
}
