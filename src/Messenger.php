<?php

namespace AnomalyLab\LuminousSMS;

use AnomalyLab\LuminousSMS\Contracts\MessagerInterface;

/**
 *	Class Messenger
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Messenger
 */
class Messenger implements MessagerInterface
{
	/**
	 *	Return the message type.
	 *
	 *	@return		string
	 */
	public function getMessageType() : string
	{
		return $this->type;
	}

	/**
	 *	Return the country code.
	 *
	 *	@return		int
	 */
	public function getCode() : int
	{
		return $this->code;
	}

	/**
	 *	Return message content.
	 *
	 *	@return		string
	 */
	public function getContent() : string
	{
		return $this->content;
	}

	/**
	 *	Set the content.
	 *
	 *	@param		string		$content
	 */
	public function setContent(string $content) : self
	{
		$this->content = $content;

		return $this;
	}

	/**
	 *	Return the template id of message.
	 *
	 *	@return		string
	 */
	public function getTemplate(): string
	{
		return $this->template;
	}
}