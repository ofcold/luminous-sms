<?php

namespace Ofcold\LuminousSMS\Qcold;

use Ofcold\LuminousSMS\Helpers;
use Ofcold\LuminousSMS\Results;
use Ofcold\LuminousSMS\Exceptions\HandlerBadException;

/**
 * Class SignaTure
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Qcold\SignaTure
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class SignaTure
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

	/**
	 * Add sign.
	 *
	 * @param string $sign
	 * @param string $picture
	 * @param string $remark
	 *
	 * @return array
	 */
	public function add(string $sign, string $picture = '', string $remark = '') : array
	{
		$params = [
			'text'		=> $sign,
			'pic'		=> $picture,
			'remark'	=> $remark,
			'time'		=> time()
		];

		$random = Helpers::random(10);

		$params['sig'] = $this->createSign($params, $random);

		return Results::render($this->qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				$this->requestMehtod('add'),
				$this->qcloud->getConfig('app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'  => $params,
			]
		));
	}

	/**
	 * Edit sign.
	 *
	 * @param  int    $id
	 * @param  string $sign
	 * @param  string $picture
	 * @param  string $remark
	 *
	 * @return array
	 */
	public function edit(int $id, string $sign, string $picture = '', string $remark = '') : array
	{
		$params = [
			'text'		=> $sign,
			'sign_id'	=> $id,
			'pic'		=> $picture,
			'remark'	=> $remark,
			'time'		=> time()
		];

		$random = Helpers::random(10);

		$params['sig'] = $this->createSign($params, $random);

		return Results::render($this->qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				$this->requestMehtod('edit'),
				$this->qcloud->getConfig('app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'  => $params,
			]
		));
	}

	/**
	 * Query sign.
	 *
	 * @param  array  $ids
	 *
	 * @return array
	 */
	public function query(array $ids) : array
	{
		$random = Helpers::random(10);

		$params = [
			'time'	=> time()
		];

		$params['sig'] = $this->createSign($params, $random);
		$params['sign_id'] = $ids;

		return Results::render($this->qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				$this->requestMehtod('query'),
				$this->qcloud->getConfig('app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'  => $params,
			]
		));
	}

	/**
	 * Remove Sign.
	 *
	 * @param  array  $ids
	 *
	 * @return array
	 */
	public function remove($ids) : array
	{
		$random = Helpers::random(10);

		$params = [
			'time'	=> time()
		];

		$params['sig'] = $this->createSign($params, $random);
		$params['sign_id'] = $ids;

		return Results::render($this->qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				$this->requestMehtod('remove'),
				$this->qcloud->getConfig('app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'  => $params,
			]
		));
	}

	/**
	 * Generate Sign.
	 *
	 * @param  array  $params
	 * @param  string  $random
	 *
	 * @return  string
	 */
	protected function createSign(array $params, string $random) : string
	{
		ksort($params);

		return hash(
			'sha256',
			sprintf(
				'appkey=%s&random=%s&time=%s',
				$this->qcloud->getConfig('app_key'),
				$random,
				$params['time']
			),
			false
		);
	}

	/**
	 * Request uri path.
	 *
	 * @param  string $name
	 *
	 * @return  string
	 */
	protected function requestMehtod(string $name) : string
	{
		return Qcloud::REQUEST_METHOD['sign'][$name];
	}

}