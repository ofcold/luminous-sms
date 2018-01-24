<?php

namespace AnomalyLab\LuminousSMS\Support;

use Closure;
use ArrayAccess;

/**
 *	Class Arrays
 *
 *	@link			https://anomaly.ink
 *	@author			Anomaly lab, Inc <support@anomaly.ink>
 *	@author			Bill Li <bill@anomaly.ink>
 *	@package		AnomalyLab\LuminousSMS\Support\Arrays
 */
class Arrays
{
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
			return Helpers::value($default);
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
			return $array[$key] ?? Helpers::value($default);
		}

		foreach ( explode('.', $key) as $segment )
		{
			if ( static::accessible($array) && static::exists($array, $segment) )
			{
				$array = $array[$segment];
			}
			else
			{
				return Helpers::value($default);
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
}