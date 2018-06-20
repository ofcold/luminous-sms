<?php

namespace Ofcold\LuminousSMS;

use Ofcold\LuminousSMS\Contracts\MessageInterface;

/**
 * Class Message
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Message
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
class Message implements MessageInterface
{
	/**
	 * The code.
	 *
	 * @var int
	 */
	protected $code;

	/**
	 * The content.
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * The template.
	 *
	 * @var string
	 */
	protected $template;

	/**
	 * Get the sign.
	 *
	 * @return string
	 */
	public function getSign() : string
	{
		return $this->sign;
	}

	/**
	 * Set the sign.
	 *
	 * @param string $sign
	 */
	public function setSign(string $sign) : MessageInterface
	{
		$this->sign = $sign;

		return $this;
	}

	/**
	 * Send SMS type.
	 *
	 * @return  string
	 */
	public function getType() : string
	{
		return $this->type ?: static::TEXT_MESSAGE;
	}

	/**
	 * Set the send SMS type.
	 *
	 * @param string $type
	 */
	public function setType(string $type) : MessageInterface
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * Return message content.
	 *
	 * @return  string
	 */
	public function getContent() : string
	{
		return $this->content;
	}

	/**
	 * Set the content.
	 *
	 * @param  string  $content
	 */
	public function setContent(string $content) : MessageInterface
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Return the template id of message.
	 *
	 * @return  string
	 */
	public function getTemplate(): string
	{
		return $this->template;
	}
}