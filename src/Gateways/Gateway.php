<?php

namespace AnomalyLab\LuminousSMS\Gateways;

use AnomalyLab\LuminousSMS\HttpRequestTraits;
use AnomalyLab\LuminousSMS\Contracts\GatewayInterface;

/**
 *	Class Gateway
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Gateways\Gateway
 */
abstract class Gateway implements GatewayInterface
{
	use HttpRequestTraits;

	/**
	 *	The gateway name.
	 *
	 *	@var		string
	 */
	protected $name;

	/**
	 *	Return the gateway name.
	 *
	 *	@return		string
	 */
	public function getName() : string
	{
		return $this->name;
	}
}