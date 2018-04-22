<?php

namespace Ofcold\LuminousSMS\Support;


/**
 *	Class Stringy
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Support\Stringy
 */
class Stringy
{
	/**
	 *	Generate a more truly "random" alpha-numeric string.
	 *
	 *	@param		int		$length
	 *
	 *	@return		string
	 */
	public static function random(int $length = 16) : string
	{
		$string = '';

		while ( ($len = strlen($string)) < $length )
		{
			$size = $length - $len;

			$bytes = random_bytes($size);

			$string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
		}

		return $string;
	}
}