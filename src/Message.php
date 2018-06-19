<?php

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
	protected $code;

	protected $content;

	protected $template;

	/**
	 * Return the country code.
	 *
	 * @return  int
	 */
	public function getCode() : int
	{

	}

	/**
	 * Return message content.
	 *
	 * @return  string
	 */
	public function getContent() : string
	{

	}

	/**
	 * Set the content.
	 *
	 * @param  string  $content
	 */
	public function setContent(string $content) : MessageInterface
	{

	}

	/**
	 * Return the template id of message.
	 *
	 * @return  string
	 */
	public function getTemplate(): string
	{

	}
}