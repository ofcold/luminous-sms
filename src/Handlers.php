<?php

use Ofcold\LuminousSMS\Contracts\MessageInterface;
use Ofcold\LuminousSMS\Contracts\HandersInterface;

/**
 * Class Handlers
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Handlers
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
abstract class Handlers implements HandersInterface
{
	protected $message;

	public function __construct(MessageInterface $message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}
}