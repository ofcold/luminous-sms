<?php

namespace Ofcold\LuminousSMS\Contracts;

/**
 * Class MessageInterface
 *
 * @link  https://ofcold.com
 * @link  https://ofcold.com/license
 *
 * @author  Ofcold <support@ofcold.com>
 * @author  Olivia Fu <olivia@ofcold.com>
 * @author  Bill Li <bill.li@ofcold.com>
 *
 * @package  Ofcold\LuminousSMS\Contracts\MessageInterface
 *
 * @copyright  Copyright (c) 2017-2018, Ofcold. All rights reserved.
 */
interface MessageInterface
{
	/**
	 * Text messages.
	 *
	 * @var string
	 */
	public const TEXT_MESSAGE = 'text';

	/**
	 * Voice messages.
	 *
	 * @var string
	 */
	public const VOICE_MESSAGE = 'voice';

	/**
	 * Template messages.
	 *
	 * @var string
	 */
	public const TEMPLATE_MESSAGE = 'template';

	/**
	 * Return the country code.
	 *
	 * @return  int
	 */
	public function getCode() : int;

	/**
	 * Return message content.
	 *
	 * @return  string
	 */
	public function getContent() : string;

	/**
	 * Set the content.
	 *
	 * @param  string  $content
	 */
	public function setContent(string $content) : self;

	/**
	 * Return the template id of message.
	 *
	 * @return  string
	 */
	public function getTemplate(): string;
}