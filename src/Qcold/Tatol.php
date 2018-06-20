<?php

namespace Ofcold\LuminousSMS\Qcold;

use Ofcold\LuminousSMS\Helpers;
use Ofcold\LuminousSMS\Results;
use Ofcold\LuminousSMS\Exceptions\HandlerBadException;

/**
 * Class Tatol
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Qcold\Tatol
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Tatol
{
	/**
	 * The qcloud instance.
	 *
	 * @var Qcloud
	 */
	protected $qcloud;

	/**
	 * Create an a new Sender.
	 *
	 * @param Qcloud $qcloud
	 */
	public function __construct(Qcloud $qcloud)
	{
		$this->qcloud = $qcloud;
	}
}