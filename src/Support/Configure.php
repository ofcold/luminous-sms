<?php

namespace AnomalyLab\LuminousSMS\Support;

use Closure;
use ArrayAccess;

/**
 *	Class Configure
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Support\Configure
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
		return static::has(static::$items, $key);
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

		return static::get(static::$items, $key, $default);
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

			$config[$key] = static::get(static::$items, $key, $default);
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
			static::set(static::$items, $key, $value);
		}
	}

	/**
	 *	Determine whether the given value is array accessible.
	 *
	 *	@param		mixed		$value
	 *
	 *	@return		bool
	 */
	public static function accessible($value) : bool
	{
		return is_array($value) || $value instanceof ArrayAccess;
	}

	/**
	 *	Get an item from an array using "dot" notation.
	 *
	 *	@param		\ArrayAccess|array		$array
	 *	@param		string					$key
	 *	@param		mixed					$default
	 *
	 *	@return		mixed
	 */
	public static function get($array, $key, $default = null)
	{
		if ( ! static::accessible($array) )
		{
			return static::value($default);
		}

		if ( is_null($key) )
		{
			return $array;
		}

		if ( static::exists($array, $key) )
		{
			return $array[$key];
		}

		if ( strpos($key, '.') === false )
		{
			return $array[$key] ?? static::value($default);
		}

		foreach ( explode('.', $key) as $segment )
		{
			if ( static::accessible($array) && static::exists($array, $segment) )
			{
				$array = $array[$segment];
			}
			else
			{
				return static::value($default);
			}
		}

		return $array;
	}

	/**
	 *	Check if an item or items exist in an array using "dot" notation.
	 *
	 *	@param		\ArrayAccess|array		$array
	 *	@param		string|array			$keys
	 *
	 *	@return		bool
	 */
	public static function has($array, $keys)
	{
		if ( is_null($keys) )
		{
			return false;
		}

		$keys = (array) $keys;

		if ( ! $array )
		{
			return false;
		}

		if ( $keys === [] )
		{
			return false;
		}

		foreach ( $keys as $key )
		{
			$subKeyArray = $array;

			if ( static::exists($array, $key) )
			{
				continue;
			}

			foreach ( explode('.', $key) as $segment )
			{
				if ( ! static::accessible($subKeyArray) && ! static::exists($subKeyArray, $segment) )
				{
					return false;
				}

				$subKeyArray = $subKeyArray[$segment];
			}
		}

		return true;
	}

	/**
	 *	Determine if the given key exists in the provided array.
	 *
	 *	@param		\ArrayAccess|array		$array
	 *	@param		string|int				$key
	 *
	 *	@return		bool
	 */
	public static function exists($array, $key) : bool
	{
		if ( $array instanceof ArrayAccess )
		{
			return $array->offsetExists($key);
		}

		return array_key_exists($key, $array);
	}

	/**
	 *	Return the default value of the given value.
	 *
	 *	@param		mixed		$value
	 *
	 *	@return		mixed
	 */
	public static function value($value)
	{
		return $value instanceof Closure ? $value() : $value;
	}
}