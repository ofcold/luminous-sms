<?php

use Ofcold\LuminousSMS\Contracts\HandersInterface;

class Sender
{
	protected $qcloud;

	public function __construct(HandersInterface $qcloud)
	{
		$this->qcloud = $qcloud;
	}

	public function render()
	{

	}

	/**
	 * Voicemail.
	 *
	 * Text SMS request body.
	 *
	 * @param  MessagerInterface  $messager
	 *
	 * @return  array
	 */
	protected function text(MessagerInterface $messager) : array
	{
		return [
			'type'		=> (int)($messager->getType() !== 'text'),
			'msg'		=> $messager->getContent(),
			'extend'	=> ''
		];
	}

	/**
	 * Voicemail.
	 *
	 * Voice SMS request body.
	 *
	 * @param  MessagerInterface  $messager
	 *
	 * @return  array
	 */
	protected function voice(MessagerInterface $messager) : array
	{
		return [
			'promptfile'	=> $messager->getContent(),
			'prompttype'	=> 2,
			'playtimes'		=> 2
		];
	}

	public function templateId()
	{

	}
}