<?php

namespace AnomalyLab\LuminousSMS\Handlers;

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