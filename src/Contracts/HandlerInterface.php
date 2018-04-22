<?php

namespace Ofcold\LuminousSMS\Contracts;

/**
 *	Interface HandlerInterface
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Contracts\HandlerInterface
 */
interface HandlerInterface
{
	/**
	 *	Return the gateway name.
	 *
	 *	@return		string
	 */
	public function getName() : string;

	/**
	 *	Seed message.
	 *
	 *	The current drive service providers to implement push information content.
	 *
	 *	@param		int|string		$to
	 *	@param		\Ofcold\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\Ofcold\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array;
}