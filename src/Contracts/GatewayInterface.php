<?php

namespace AnomalyLab\LuminousSMS\Contracts;

/**
 *	Interface GatewayInterface
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Contracts\GatewayInterface
 */
interface GatewayInterface
{
	/**
	 *	Return the gateway name.
	 *
	 *	@return		string
	 */
	public function getName() : string;
}