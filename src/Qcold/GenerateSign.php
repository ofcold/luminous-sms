<?php

trait GenerateSign
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
	public static function createSign(array $params, string $random, string $appKey) : string
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