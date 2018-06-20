<?php

namespace Ofcold\LuminousSMS\Contracts;

/**
 * Class HandersInterface
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Contracts\HandersInterface
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
interface HandersInterface
{
	/**
	 * Get the Message instance.
	 *
	 * @return MessageInterface
	 */
	public function getMessage() : MessageInterface;

	/**
	 * Set the config items.
	 *
	 * @param array $config
	 *
	 * @return $this
	 */
	public function setConfig(array $config);

	/**
	 * Get the config item.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
	public function getConfig(string $key);

	/**
	 * Get config items.
	 *
	 * @return array
	 */
	public function getConfigs() : array;

	/**
	 * Return timeout.
	 *
	 * @return  float
	 */
	public function getTimeout() : float;

	/**
	 * Set the timeout.
	 *
	 * @param  float  $timeout
	 */
	public function setTimeout(float $timeout);

	/**
	 * Send SMS to send.
	 *
	 * The current drive service providers to implement push information content.
	 *
	 * @return array
	 *
	 * @throws \Ofcold\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send() : array;
}