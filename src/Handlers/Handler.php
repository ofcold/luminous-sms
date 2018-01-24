<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
use AnomalyLab\LuminousSMS\Traits\HttpRequest;
use AnomalyLab\LuminousSMS\Contracts\HandlerInterface;

/**
 *	Class Handler
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Handlers\Handler
 */
abstract class Handler implements HandlerInterface
{
	use HttpRequest;

	protected const DEFAULT_TIMEOUT = 5.0;

	/**
	 *	The gateway name.
	 *
	 *	@var		string
	 */
	protected $name;

	/**
	 *	The config of Qcold information.
	 *
	 *	@var		array
	 */
	protected $config = [];

	/**
	 *	The timeout.
	 *
	 *	@var		float
	 */
	protected $timeout;

	/**
	 *	Drive supports sending SMS.
	 *
	 *	@var		array
	 */
	protected $methods = [
		'voice'			=> 'voice',
		'text'			=> 'text',
		'text_many'		=> 'textMany',
		'template'		=> 'template'
	];

	/**
	 *	Remove the SMS push method that this driver does not support.
	 *
	 *	@var		array
	 */
	protected $removeMethods = [];

	/**
	 * Remove methods not currently supported by the vendor.
	 *
	 *	@return		array
	 */
	public function getMethods() : array
	{
		$remove = $this->removeMethods;

		return array_filter(
			$this->methods,
			function($key) use($remove) {

				return ! in_array($key, $remove);
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 *	Get the handler sender method.
	 *
	 *	@param		string		$method
	 *
	 *	@return		string
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\HandlerBadException
	 */
	public function getMethod(string $method) : string
	{
		if ( ! isset($this->getMethods()[$method]) || ! method_exists($this, $method = $this->getMethods()[$method]) )
		{
			throw new HandlerBadException(
				sprintf(
					'Supplier: %s does not support this behavior: "%s" to send text messages.',
					$this->getName(),
					$method
				)
			);
		}

		return $method;
	}

	/**
	 *	Return timeout.
	 *
	 *	@return		float
	 */
	public function getTimeout() : float
	{
		return $this->timeout ?: static::DEFAULT_TIMEOUT;
	}

	/**
	 *	Set the timeout.
	 *
	 *	@param		float		$timeout
	 */
	public function setTimeout(float $timeout) : self
	{
		$this->timeout = $timeout;

		return $this;
	}

	/**
	 *	Return the gateway name.
	 *
	 *	@return		string
	 */
	public function getName() : string
	{
		return $this->name;
	}

	/**
	 *	Set of the handler configuration.
	 *
	 *	@param		array		$config
	 *
	 *	@return		$this
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;

		return $this;
	}
}