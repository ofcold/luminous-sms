<?php

namespace Ofcold\LuminousSMS\Qcold;

/**
 * trait GenerateSign
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Qcold\GenerateSign
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class GenerateSign
{
	/**
	 * Generate Sign.
	 *
	 * @param  array  $params
	 * @param  string  $random
	 * @param  string  $appKey
	 *
	 * @return  string
	 */
	public static function make(array $params, string $random, string $appKey) : string
	{
		ksort($params);

		return hash(
			'sha256',
			sprintf(
				'appkey=%s&random=%s&time=%s&mobile=%s',
				$appKey,
				$random,
				$params['time'],
				$params['tel']['mobile']
			),
			false
		);
	}
}