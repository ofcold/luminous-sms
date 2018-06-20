<?php

namespace Ofcold\LuminousSMS;

/**
 * Class Helpers
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Helpers
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Helpers
{
	/**
	 * Generate a more truly "random" alpha-numeric string.
	 *
	 * @param  int  $length
	 *
	 * @return  string
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