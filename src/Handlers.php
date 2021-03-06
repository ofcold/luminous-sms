<?php

namespace Ofcold\LuminousSMS;

use Ofcold\LuminousSMS\Contracts\MessageInterface;
use Ofcold\LuminousSMS\Contracts\HandersInterface;

/**
 * Class Handlers
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Handlers
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
abstract class Handlers implements HandersInterface
{
	use HttpClientRequest;

	protected const DEFAULT_TIMEOUT = 5.0;

	/**
	 * The message instance.
	 *
	 * @var MessageInterface
	 */
	protected $message;

	/**
	 * The handler config.
	 *
	 * @var array
	 */
	protected $config = [];

	/**
	 * The timeout.
	 *
	 * @var  float
	 */
	protected $timeout;

	/**
	 * Set the Message instance.
	 *
	 * @param MessageInterface $message
	 */
	public function setMessage(MessageInterface $message)
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * Get the Message instance.
	 *
	 * @return MessageInterface
	 */
	public function getMessage() : MessageInterface
	{
		return $this->message;
	}

	/**
	 * Set the config items.
	 *
	 * @param array $config
	 *
	 * @return $this
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;

		return $this;
	}

	/**
	 * Get the config item.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
	public function getConfig(string $key)
	{
		return $this->config[$key] ?? null;
	}

	/**
	 * Get config items.
	 *
	 * @return array
	 */
	public function getConfigs() : array
	{
		return $this->config;
	}

	/**
	 * Return timeout.
	 *
	 * @return  float
	 */
	public function getTimeout() : float
	{
		return $this->timeout ?: static::DEFAULT_TIMEOUT;
	}

	/**
	 * Set the timeout.
	 *
	 * @param  float  $timeout
	 */
	public function setTimeout(float $timeout)
	{
		$this->timeout = $timeout;

		return $this;
	}

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
		throw new HandlerBadException('message failed to send');
	}
}