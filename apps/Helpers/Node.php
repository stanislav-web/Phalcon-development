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
}