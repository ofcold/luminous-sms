<?php

namespace Ofcold\LuminousSMS\Contracts;

/**
 *	Interface MessagerInterface
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Contracts\MessagerInterface
 */
interface MessagerInterface
{
	public const TEXT_MESSAGE = 'text';

	public const VOICE_MESSAGE = 'voice';

	public const TEXT_MANY_MESSAGE = 'text_many';

	public const TEMPLATE_MESSAGE = 'template';

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