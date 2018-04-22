<?php

namespace Ofcold\LuminousSMS\Support;

use Closure;

/**
 *	Class Helpers
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Support\Helpers
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