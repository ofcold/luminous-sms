<?php

namespace Ofcold\LuminousSMS\Qcold;

use Ofcold\LuminousSMS\Helpers;
use Ofcold\LuminousSMS\Exceptions\HandlerBadException;

/**
 * Class Sender
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Qcold\Sender
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Sender
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
	 * Sender SMS
	 *
	 * @return mixed
	 */
	public function render()
	{
		$method = method_exists($this, $this->qcloud->getMessage()->getType())
			 ? $this->qcloud->getMessage()->getType()
			 : 'text';

		$params = $this->$method();

		//	Set SMS flag.
		if ( $sign = $this->qcloud->getMessage()->getSign() )
		{
			$params['sign']	= $sign;
		}

		//	Set the full mobile phone.
		$params['tel']	= [
			'nationcode'	=> $this->qcloud->getMessage()->getCode(),
			'mobile'		=> $this->qcloud->getMessage()->getMobilePhone()
		];

		$params['time'] = time();
		$params['ext'] = '';

		$random = Helpers::random(10);

		$params['sig'] = $this->createSign($params, $random);

		$result = $this->qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				Qcloud::REQUEST_METHOD[$this->qcloud->getMessage()->getType()],
				$this->qcloud->getConfig('app_id'),
				$random
			),
			[
				'headers'	=> [
					'Accept' => 'application/json'
				],
				'json'  => $params,
			]
		);

		if ( 0 != $result['result'] )
		{
			throw new HandlerBadException($result['errmsg'], $result['result'], $result);
		}

		return $result;

	}

	/**
	 * Voicemail.
	 *
	 * Text SMS request body.
	 *
	 * @return  array
	 */
	protected function text() : array
	{
		return [
			'type'		=> (int)($this->qcloud->getMessage()->getType() !== 'text'),
			'msg'		=> $this->qcloud->getMessage()->getContent(),
			'extend'	=> ''
		];
	}

	/**
	 * Voicemail.
	 *
	 * Voice SMS request body.
	 *
	 * @return  array
	 */
	protected function voice() : array
	{
		return [
			'promptfile'	=> $this->qcloud->getMessage()->getContent(),
			'prompttype'	=> 2,
			'playtimes'		=> 2
		];
	}

	public function templateId()
	{

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
				'appkey=%s&random=%s&time=%s&mobile=%s',
				$this->qcloud->getConfig('app_key'),
				$random,
				$params['time'],
				$params['tel']['mobile']
			),
			false
		);
	}
}