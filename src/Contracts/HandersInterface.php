<?php

namespace Ofcold\LuminousSMS\Contracts;

/**
 * Class HandersInterface
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Contracts\HandersInterface
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
interface HandersInterface
{
	/**
	 * Send SMS.
	 *
	 * @param  MessageInterface $message
	 *
	 * @return mixed
	 */
	public function seed(MessageInterface $message);
}