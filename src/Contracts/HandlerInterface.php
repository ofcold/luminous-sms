<?php

namespace AnomalyLab\LuminousSMS\Contracts;

/**
 *	Interface HandlerInterface
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Contracts\HandlerInterface
 */
interface HandlerInterface
{
	/**
	 *	Return the gateway name.
	 *
	 *	@return		string
	 */
	public function getName() : string;
}