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
	protected $type;

	protected $code;

	protected $content;

	protected $template;

	protected $parserData = [];

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
		return $this->code ?: 86;
	}

	/**
	 *	Set the country code.
	 *
	 *	@return		int
	 */
	public function setCode(int $code) : MessagerInterface
	{
		$this->code = $code;

		return $this;
	}

	/**
	 *	Return message content.
	 *
	 *	@return		string
	 */
	public function getContent() : string
	{
		return (new \StringTemplate\Engine)
			->render(
				$this->content,
				$this->parserData
			);
	}

	/**
	 *	Set the content.
	 *
	 *	@param		string		$content
	 */
	public function setContent(string $content) : MessagerInterface
	{
		$this->content = $content;

		return $this;
	}

	public function setData(array $data) : MessagerInterface
	{
		$this->parserData = $data;

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