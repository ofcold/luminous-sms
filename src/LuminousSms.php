<?php

namespace Ofcold\LuminousSMS;

use Closure;
use InvalidArgumentException;
use Ofcold\LuminousSMS\{
	Support\Configure,
	Contracts\HandlerInterface,
	Handlers\Qcloud,
	Handlers\Yunpian,
	Handlers\Juhe,
	Handlers\Alidayu,
	Handlers\Sendcloud,
	Handlers\Baidu
};

/**
 *	Class LuminousSMS
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\LuminousSMS
 */
class LuminousSMS
{
	/**
	 *	The Messenger instance.
	 *
	 *	@var		\Ofcold\LuminousSMS\Messenger
	 */
	protected $messenger;

	/**
	 *	The default handlers handler.
	 *
	 *	@var		array
	 */
	protected $handlers = [
		'qcloud'	=> Qcloud::class,
		'yunpian'	=> Yunpian::class,
		'alidayu'	=> Alidayu::class,
		'baidu'		=> Baidu::class,
		'juhe'		=> Juhe::class,
		'sendcloud'	=> Sendcloud::class
	];

	/**
	 *	Implement SMS push.
	 *
	 *	@param		callable|array		$callback
	 *	@param		string|null			$handler
	 *
	 *	@return		mixed
	 */
	public function sender($callback, ?string $handler = null)
	{
		//	@var Messenger
		$messenger = $this->getMessenger();

		// //	Check the parameters and throw an exception!
		// if ( !($callback instanceof Closure) || !is_array($callback) )
		// {
		// 	throw new InvalidArgumentException(
		// 		'The first parameter to send the message must be an array or callable.'
		// 	);
		// }

		is_array($callback)
			? array_walk_recursive($callback, function($value, $slug) use($messenger) {

				$method = 'set' . ucfirst($slug);

				if ( method_exists($messenger, $method) )
				{
					$messenger->$method($value);
				}
			})
			: $callback($messenger);

		$smsHandler = $handler !== null
			 ? $this->makeHandler($handler)
			 : $this->getDefaultHandler();

		return $smsHandler->send($messenger);
	}

	/**
	 *	Set global configuration information.
	 *
	 *	@param		mixed		$key
	 *	@param		mixed		$val
	 *
	 *	@return		$this
	 */
	public function setConfig(array $items) : self
	{
		Configure::setItems($items);

		return $this;
	}

	/**
	 *	Return Messenger instance.
	 *
	 *	@return		\Ofcold\LuminousSMS\Messenger
	 */
	public function getMessenger()
	{
		return $this->messenger ?: $this->messenger = new Messenger($this);
	}

	public function getDefaultHandler()
	{
		return $this->makeHandler(Configure::item('default_handler'));
	}

	/**
	 *	Set default handler name.
	 *
	 *	@param		string		$name
	 *
	 *	@return		$this
	 */
	public function setDefaultHandler(string $name) : self
	{
		if ( $this->handlerExists($name) )
		{
			$this->setConfig();
		}

		return $this;
	}

	/**
	 *	Make handler and configure basic information.
	 *
	 *	@param		string		$name
	 *
	 *	@return		\Ofcold\LuminousSMS\Contracts\HandlerInterface
	 *
	 *	@throws		\Ofcold\LuminousSMS\Exceptions\InvalidArgumentException
	 */
	protected function makeHandler(string $name) : HandlerInterface
	{
		$handler = $this->getHandler($name);

		$handler = (new $handler)
			->setConfig(Configure::item('supported.' . $name));

		if ( !($handler instanceof HandlerInterface) )
		{
			throw new InvalidArgumentException(
				sprintf('Handler "%s" not inherited from %s.', $name, HandlerInterface::class)
			);
		}

		return $handler;
	}

	/**
	 *	Check handlers for existence.
	 *
	 *	@param		string		$name
	 *
	 *	@return		bool
	 */
	protected function handlerExists(string $name) : bool
	{
		return isset($this->handlers[$name]) && Configure::hasItem('supported.' . $name);
	}

	/**
	 *	Get the handlers name.
	 *
	 *	@param		string		$name
	 *
	 *	@return		string
	 */
	protected function getHandler(string $name) : string
	{
		if ( ! $this->handlerExists($name)  )
		{
			throw new InvalidArgumentException(sprintf('The handler: "%s" you are using does not exist.', $name));
		}

		return $this->handlers[$name];
	}
}