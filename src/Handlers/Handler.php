<?php

namespace AnomalyLab\LuminousSMS\Handlers;

use AnomalyLab\LuminousSMS\HttpRequestTraits;
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
	use HttpRequestTraits;

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