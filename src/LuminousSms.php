<?php

use Ofcold\LuminousSMS\Contracts\MessageInterface;

/**
 * Class LuminousSms
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\LuminousSms
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class LuminousSms
{
	protected static $handlers = [];

	/**
	 * The configuration items.
	 *
	 * @var arary
	 */
	protected $config;

	/**
	 * the Message instance.
	 *
	 * @var Message
	 */
	protected $message;

	/**
	 * Create an new LuminousSms instance.
	 *
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function sender($callback, ?string $handler = null)
	{
		$message = $this->getMessage();

		switch (true)
		{
			case is_callable($callback):
					$callback($message);
				break;

			case is_array($callback):
					new MessageHydrator($message, $callback);
				break;

			default:
					throw new InvalidArgumentException('The [1] parameter only supports arrays or closures');
				break;
		}

		$handler = $this->createHandler($handler);

		return $handler->send($message);
	}

	/**
	 * Get the message instance.
	 *
	 * @return MessageInterface
	 */
	public function getMessage() : MessageInterface
	{
		return $this->message ?: new Message;
	}

	/**
	 * Create a new handler instance.
	 *
	 * @param  string|null $handler
	 *
	 * @return HandlersInterface
	 *
	 * @throws InvalidArgumentException
	 */
	public function createHandler(?string $handler = null) : HandlersInterface
	{
		if ( !$this->handlerExists($handler) || is_null($handler) )
		{
			$handler = $this->getDefaultHandler();
		}

		$method = 'create' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $handler))) . 'Handler';

		if ( method_exists($this, $method) )
		{
			return $this->$method;
		}

		throw new InvalidArgumentException("Handler [$handler] not supported.");
	}

	/**
	 * Get the Qcloud handler instance.
	 *
	 * @return HandlersInterface
	 */
	protected function getQcloudHandler() : HandlersInterface
	{
		return new Qcloud($this->config['supported']['qcloud']);
	}

	/**
	 * Get the default handler name.
	 *
	 * @return string
	 */
	protected function getDefaultHandler() : string
	{
		if ( $this->handlerExists($default = $this->config['supported']['default_handler']) )
		{
			return $default;
		}

		return 'qcloud';
	}

	/**
	 * Checks if the used handler is supported.
	 *
	 * @param  string $handler
	 *
	 * @return boolean
	 */
	protected function handlerExists(string $handler) : bool
	{
		return isset($this->config['supported'][$handler]);
	}
}