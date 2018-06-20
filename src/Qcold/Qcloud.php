<?php

namespace Ofcold\LuminousSMS\Qcold;

use Ofcold\LuminousSMS\Handlers;

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
		'voice'	=> 'tlsvoicesvr/sendvoiceprompt'
	];

	/**
	 * Request format
	 *
	 * @var string
	 */
	public const REQUEST_FORMAT = 'json';

	/**
	 * Seed message.
	 *
	 * The current drive service providers to implement push information content.
	 *
	 * @return array
	 *
	 * @throws \Ofcold\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array
	{
		return (new Qcloud($this))
			->render();
	}
}