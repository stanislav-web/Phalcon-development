<?php
namespace Helpers;

/**
 * Helper Node. Work with data type
 * @package Phalcon
 * @subpackage Helpers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Helpers/Node.php
 */
class Node extends \Phalcon\Tag
{
	/**
	 * Convert object to array
	 * @param $obj
	 * @access static
	 * @return array
	 */
	public static function objectToArray($obj)
	{
		if(is_object($obj)) $obj = (array)$obj;
		if(is_array($obj))
		{
			$new = array();
			foreach($obj as $key => $val) {
				$new[$key] = self::objectToArray($val);
			}
		}
		else $new = $obj;
		return $new;
	}

	/**
	 * Add handler to even array values
	 * @param $obj
	 * @access static
	 * @return array
	 */
	public static function arrayMapDeep($array, $callback)
	{
		$new = [];
		foreach ($array as $key => $val)
		{
			if(is_array($val))
				$new[$key] = self::arrayMapDeep($val, $callback);
			 else
				 $new[$key] = call_user_func($callback, $val);
		}
		return $new;
	}

	/**
	 * Unserialize string
	 * @param $original
	 * @access static
	 * @return mixed
	 */
	public static function dataUnserialize($original)
	{
		// don't attempt to unserialize data that wasn't serialized going in

		if(self::isSerialized($original))
			return unserialize($original);
		return $original;
	}

	/**
	 * If is serialized value
	 * @param string $value
	 * @param string $value
	 * @access static
	 * @return boolean
	 */
	public function isSerialized($value, &$result = null)
	{
		// Bit of a give away this one
		if(!is_string($value))
			return false;

		// Serialized false, return true. unserialize() returns false on an
		// invalid string or it could return false if the string is serialized
		// false, eliminate that possibility.
		if($value === 'b:0;')
		{
			$result = false;
			return true;
		}

		$length	= strlen($value);
		$end	= '';

		if(!isset($value[0])) return false;
		switch ($value[0])
		{
			case 's':
				if($value[$length - 2] !== '"')
					return false;

			case 'b':
			case 'i':
			case 'd':
				// This looks odd but it is quicker than isset()ing
				$end .= ';';
			case 'a':
			case 'O':
				$end .= '}';
				if($value[1] !== ':')
					return false;

				switch ($value[2])
				{
					case 0:
					case 1:
					case 2:
					case 3:
					case 4:
					case 5:
					case 6:
					case 7:
					case 8:
					case 9:
						break;

					default:
						return false;
				}
			case 'N':
				$end .= ';';
				if($value[$length - 1] !== $end[0])
					return false;
				break;

			default:
				return false;
		}

		if(($result = @unserialize($value)) === false)
		{
			$result = null;
			return false;
		}
		return true;
	}
}