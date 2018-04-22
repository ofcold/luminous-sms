<?php

namespace Ofcold\LuminousSMS;

use Ofcold\LuminousSMS\Contracts\MessagerInterface;

/**
 *	Class Messenger
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Messenger
 */
class Messenger implements MessagerInterface
{
	protected $sign;

	protected $type;

	protected $code;

	protected $content;

	protected $template;

	protected $parserData = [];

	protected $mobilePhone;

	public function getSign() : ?string
	{
		return $this->sign;
	}

	public function setSign(string $sign) : MessagerInterface
	{
		$this->sign = $sign;

		return $this;
	}

	public function getType()
	{
		return $this->type ?: static::TEXT_MESSAGE;
	}

	public function setType(string $type) : MessagerInterface
	{
		$this->type = $type;

		return $this;
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

	public function getMobilePhone() : string
	{
		return $this->mobilePhone;
	}

	public function setMobilePhone(string $mobilePhone) : MessagerInterface
	{
		$this->mobilePhone = $mobilePhone;

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
	 *	Return the template id of messager.
	 *
	 *	@return		string
	 */
	public function getTemplate(): string
	{
		return $this->template;
	}

	/**
	 *	Set the template id of messager.
	 *
	 *	@return		string
	 */
	public function setTemplate(string $template) : MessagerInterface
	{
		$this->template = $template;

		return $this;
	}
}