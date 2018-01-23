<?php

namespace AnomalyLab\LuminousSMS\Contracts;

/**
 *	Interface HandlerInterface
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Contracts\HandlerInterface
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
	 *	@param		\AnomalyLab\LuminousSMS\Contracts\MessagerInterface		$messager
	 *
	 *	@return		array
	 *
	 *	@throws		\AnomalyLab\LuminousSMS\Exceptions\HandlerBadException;
	 */
	public function send(MessagerInterface $messager) : array;
}