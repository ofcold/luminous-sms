<?php

namespace AnomalyLab\LuminousSMS\Support;

use Closure;

/**
 *	Class Helpers
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Support\Helpers
 */
class Helpers
{
	/**
	 *	Return the default value of the given value.
	 *
	 *	@param		mixed		$value
	 *
	 *	@return		mixed
	 */
	public static function value($value)
	{
		return $value instanceof Closure ? $value() : $value;
	}
}