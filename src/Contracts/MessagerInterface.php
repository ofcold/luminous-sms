<?php

namespace AnomalyLab\LuminousSMS\Contracts;

/**
 *	Interface MessagerInterface
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Contracts\MessagerInterface
 */
interface MessagerInterface
{
	public const TEXT_MESSAGE = 'text';

	public const VOICE_MESSAGE = 'voice';

	/**
	 *	Return the country code.
	 *
	 *	@return		int
	 */
	public function getCode() : int;

	/**
	 *	Return message content.
	 *
	 *	@return		string
	 */
	public function getContent() : string;

	/**
	 *	Set the content.
	 *
	 *	@param		string		$content
	 */
	public function setContent(string $content) : self;

	/**
	 *	Return the template id of message.
	 *
	 *	@return		string
	 */
	public function getTemplate(): string;
}