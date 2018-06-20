<?php

namespace Ofcold\LuminousSMS;

use Ofcold\LuminousSMS\Contracts\MessageInterface;

/**
 * Class MessageHydrator
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\MessageHydrator
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class MessageHydrator
{
	/**
	 * Hydrate an MessageInterface with parameters.
	 *
	 * @param  MessageInterface $message
	 * @param  array            $parameters
	 *
	 * @return void
	 */
	public function make(MessageInterface $message, array $parameters) : void
	{
		foreach ( $parameters as $key => $value )
		{
			$method = $method = 'set' . ucfirst($key);

			if ( method_exists($message, $method) )
			{
				$message->method($value);
			}
		}
	}
}