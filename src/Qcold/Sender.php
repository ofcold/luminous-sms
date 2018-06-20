<?php

use Ofcold\LuminousSMS\Handlers;

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

		$params['sig'] = GenerateSign::make($params, $randomm, $this->qcloud->getConfig('app_key'));

		$result = $this->qcloud->request(
			'post',
			sprintf(
				'%s%s?sdkappid=%s&random=%s',
				Qcloud::REQUEST_URL,
				Qcloud::REQUEST_METHOD[$this->qcloud->getType()],
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
}