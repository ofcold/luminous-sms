<?php

namespace Ofcold\LuminousSMS\Qcold;

use Ofcold\LuminousSMS\Handlers;
use Ofcold\LuminousSMS\Exceptions\MethodNotFoundException;

/**
 * Class Qcloud
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Qcold\Qcloud
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Qcloud extends Handlers
{
	/**
	 * Request base url.
	 *
	 * @var string
	 */
	public const REQUEST_URL = 'https://yun.tim.qq.com/v5/';

	/**
	 * Request method.
	 *
	 * @var array
	 */
	public const REQUEST_METHOD = [
		'text'	=> 'tlssmssvr/sendsms',
		'voice'	=> 'tlsvoicesvr/sendvoiceprompt',
		'sign'	=> [
			'add'		=> 'tlssmssvr/add_sign',
			'edit'		=> 'tlssmssvr/mod_sign',
			'remove'	=> 'tlssmssvr/del_sign',
			'query'		=> 'tlssmssvr/get_sign'
		],
		'template'	=> [
			'add'		=> 'tlssmssvr/add_template',
			'edit'		=> 'tlssmssvr/mod_template',
			'remove'	=> 'tlssmssvr/del_template',
			'query'		=> 'tlssmssvr/get_template',
		],
		'tatol'	=> [
			'sender'	=> 'tlssmssvr/pullsendstatus'
		]
	];

	/**
	 * The Signature instance.
	 *
	 * @var Signature
	 */
	protected static $signature;

	/**
	 * The Template instance.
	 *
	 * @var Templatye
	 */
	protected static $template;

	/**
	 * Send SMS to send.
	 *
	 * The current drive service providers to implement push information content.
	 *
	 * @return array
	 *
	 * @throws \Ofcold\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send() : array
	{
		return Sender::render($this);
	}

	/**
	 * Get the SignaTure instance.
	 *
	 * @param  string $method
	 * @param  array  $attributes
	 *
	 * @return mixed
	 */
	public function getSignature(string $method, ...$attributes)
	{
		$instance = static::$signature ?: new SignaTure($this);

		if ( method_exists($instance, $method) )
		{
			return $instance->$method(...$attributes);
		}

		throw new MethodNotFoundException("Add {$method} does not exist object SignaTure");
	}

	/**
	 * Get the Template instance.
	 *
	 * @param  string|null $method
	 * @param  array  $attributes
	 *
	 * @return mixed
	 */
	public function getTemplate(?string $method = null, ...$attributes)
	{
		$instance = static::$template ?: new Template($this);

		if ( method_exists($instance, $method) )
		{
			return $instance->$method(...$attributes);
		}

		throw new MethodNotFoundException("Add {$method} does not exist object Template");
	}
}