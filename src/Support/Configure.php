<?php

namespace Ofcold\LuminousSMS\Support;

use Closure;
use ArrayAccess;

/**
 *	Class Configure
 *
 *	@link			https://ofcold.com
 *
 *	@author			Ofcold, Inc <support@ofcold.com>
 *	@author			Bill Li <bill.li@ofcold.com>
 *
 *	@package		Ofcold\LuminousSMS\Support\Configure
 */
class Configure
{
	/**
	 *	All of the configuration items.
	 *
	 *	@var		array
	 */
	protected static $items = [];

	/**
	 *	Set the configuration items.
	 *
	 *	@param		array		$items
	 *
	 *	@return		void
	 */
	public static function setItems(array $items) : void
	{
		static::$items = $items;
	}

	/**
	 *	Determine if the given configuration value exists.
	 *
	 *	@param		string		$key
	 *
	 *	@return		bool
	 */
	public static function hasItem(string $key) : bool
	{
		return Arrays::has(static::$items, $key);
	}

	/**
	 *	Get the specified configuration value.
	 *
	 *	@param		array|string	$key
	 *	@param		mixed		 	$default
	 *
	 *	@return		mixed
	 */
	public static function item($key, $default = null)
	{
		if ( is_array($key) )
		{
			return $this->getMany($key);
		}

		return Arrays::get(static::$items, $key, $default);
	}

	/**
	 *	Get many configuration values.
	 *
	 *	@param		array		$keys
	 *
	 *	@return		array
	 */
	public static function getMany(array $keys) : array
	{
		$config = [];

		foreach ( $keys as $key => $default )
		{
			if ( is_numeric($key) )
			{
				list($key, $default) = [$default, null];
			}

			$config[$key] = Arrays::get(static::$items, $key, $default);
		}

		return $config;
	}

	/**
	 *	Set a given configuration value.
	 *
	 *	@param		array|string	$key
	 *	@param		mixed		 	$value
	 *
	 *	@return		void
	 */
	public static function set($key, $value = null) : void
	{
		$keys = is_array($key) ? $key : [$key => $value];

		foreach ( $keys as $key => $value )
		{
			Arrays::set(static::$items, $key, $value);
		}
	}
}