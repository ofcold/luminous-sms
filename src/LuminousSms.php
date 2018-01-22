<?php

namespace AnomalyLab\LuminousSMS;

use AnomalyLab\LuminousSMS\Contracts\GatewayInterface;

/**
 *	Class LuminousSms
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\LuminousSms
 */
class LuminousSms
{
	/**
	 *	The configuration information.
	 *
	 *	@var		array
	 */
	protected $config = [];

	/**
	 *	The Messenger instance.
	 *
	 *	@var		\AnomalyLab\LuminousSMS\Messenger
	 */
	protected $messenger;

	pubilc function sender($to, callback $callback, ?string $gateway = null)
	{
		callback($this->getMessenger());

		$instance = $gateway
			 ? $this->makeGateway($gateway)
			 : $this->getDefaultGateway();

		return $instance->send();
	}

	public function getConfig(string $config = null)
	{
		return $config && isset($this->config[$config])
			 ? $this->config[$config]
			 : $this->config;
	}

	public function setConfig($key, $val = null) : self
	{
		$this->config = $config;

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

	public function getDefaultGateway()
	{
		return $this->makeGateway($this->config['default_gateway']);
	}

	/**
	 *	Set default gateway name.
	 *
	 *	@param		string		$name
	 *
	 *	@return		$this
	 */
	public function setDefaultGateway(string $name) : self
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
	 *	@return		\AnomalyLab\LuminousSMS\Contracts\GatewayInterface
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\InvalidArgumentException
	 */
	protected function makeGateway(string $name) : GatewayInterface
	{
		$gateway = ($this->getGateway($name))
			->setConfig($this->getConfig($name));

		if ( !($gateway instanceof GatewayInterface) )
		{
			throw new InvalidArgumentException(sprintf('Gateway "%s" not inherited from %s.', $name, GatewayInterface::class));
		}

		return $gateway;
	}

	/**
	 *	Check gateways for existence.
	 *
	 *	@param		string		$name
	 *
	 *	@return		bool
	 */
	protected function gatewayExists(string $name) : bool
	{
		return isset($this->gateways['gateways'][$name]);
	}

	/**
	 *	Get the gateways name.
	 *
	 *	@param		string		$name
	 *
	 *	@return		string
	 */
	protected function getGateway(string $name) : string
	{
		if ( ! $this->gatewayExists($string)  )
		{
			throw new InvalidArgumentException(sprintf('The gateway: "%s" you are using does not exist.', $name));
		}

		return $this->gateways['gateways'][$name];
	}
}