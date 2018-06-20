<?php

namespace Ofcold\LuminousSMS;

use Ofcold\LuminousSMS\Exceptions\HandlerBadException;

/**
 * Class Results
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Results
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Results
{
	public static function render(array $result)
	{
		if ( 0 != $result['result'] )
		{
			throw new HandlerBadException($result['errmsg'], $result['result'], $result);
		}

		return $result;
	}
}