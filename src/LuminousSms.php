<?php

namespace AnomalyLab\LuminousSMS;

use AnomalyLab\LuminousSMS\Support\Configure;
use AnomalyLab\LuminousSMS\Contracts\HandlerInterface;

/**
 *	Class LuminousSMS
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\LuminousSMS
 */
class LuminousSMS
{
	/**
	 *	The Messenger instance.
	 *
	 *	@var		\AnomalyLab\LuminousSMS\Messenger
	 */
	protected $messenger;

	/**
	 *	The default handlers handler.
	 *
	 *	@var		array
	 */
	protected $handlers = [
		'qclod'	=> AnomalyLab\LuminousSMS\Handlers\Qclod::class
	];

	public function sender(string $to, callable $callback, ?string $gateway = null)
	{
		$callback($this->getMessenger());

		$instance = $gateway
			 ? $this->makeHandler($gateway)
			 : $this->getDefaultHandler();

		return $instance->send();
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
	 *	@return		\AnomalyLab\LuminousSMS\Messenger
	 */
	public function getMessenger()
	{
		return $this->messenger ?: $this->messenger = new Messenger($this);
	}

	public function getDefaultHandler()
	{
		return $this->makeHandler(Configure::item('default_gateway'));
	}

	/**
	 *	Set default gateway name.
	 *
	 *	@param		string		$name
	 *
	 *	@return		$this
	 */
	public function setDefaultHandler(string $name) : self
	{
		if ( $this->gatewayExists($name) )
		{
			$this->setConfig();
		}
		
		return $this;
	}

	/**
	 *	Make gateway and configure basic information.
	 *
	 *	@param		string		$name
	 *
	 *	@return		\AnomalyLab\LuminousSMS\Contracts\HandlerInterface
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\InvalidArgumentException
	 */
	protected function makeHandler(string $name) : HandlerInterface
	{
		$gateway = (new $this->getHandler($name))
			->setConfig(Configure::item('supported.' . $name));

		if ( !($gateway instanceof HandlerInterface) )
		{
			throw new InvalidArgumentException(sprintf('Handler "%s" not inherited from %s.', $name, HandlerInterface::class));
		}

		return $gateway;
	}

	/**
	 *	Check handlers for existence.
	 *
	 *	@param		string		$name
	 *
	 *	@return		bool
	 */
	protected function gatewayExists(string $name) : bool
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
		if ( ! $this->gatewayExists($string)  )
		{
			throw new InvalidArgumentException(sprintf('The gateway: "%s" you are using does not exist.', $name));
		}

		return $this->handlers[$name];
	}
}