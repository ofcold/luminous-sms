<?php

namespace Ofcold\LuminousSMS\Handlers;

use Ofcold\LuminousSMS\Exceptions\HandlerBadException;
use Ofcold\LuminousSMS\Contracts\MessagerInterface;
use Ofcold\LuminousSMS\Support\Arrays;

/**
 *	Class Juhe
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Handlers\Juhe
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
	 *	Remove Juhe SMS push does not support methods.
	 *
	 *	@var		array
	 */
	protected $removeMethods = ['voice', 'text_many', 'template_id'];

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
			'mobile'	=> $messager->getMobilePhone(),
			'tpl_id'	=> $messager->getTemplate(),
			'tpl_value'	=> $this->formatTemplateData($messager->getData()),
			'dtype'		=> static::REQUEST_FORMAT,
			'key'		=> Arrays::get($this->config, 'app_key'),
		];

		$result = $this->get(static::REQUEST_URL, $params);

		if ( $result['error_code'] )
		{
			throw new HandlerBadException($result['reason'], $result['error_code'], $result);
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