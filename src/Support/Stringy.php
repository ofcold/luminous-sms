<?php

namespace AnomalyLab\LuminousSMS\Support;


/**
 *	Class Stringy
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Support\Stringy
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