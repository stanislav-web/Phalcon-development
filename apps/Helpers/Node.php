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
class Node
{
    /**
     * Convert object to array
     * @param $obj
     * @access static
     * @return array
     */
    public static function objectToArray($obj)
    {
        if (is_object($obj)) $obj = (array)$obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = self::objectToArray($val);
            }
        } else $new = $obj;
        return $new;
    }

    /**
     * Convert multidimensional array to key => pair array
     * @param $obj
     * @access static
     * @return array
     */
    public static function arrayToPair(array $array)
    {
        $result = [];
        if (!empty($array)) {
            foreach ($array as $n => $values) {
                if (sizeof($values) == 2) {
                    $values = array_values($values);
                    $result[$values[0]] = $values[1];
                }
            }
        }
        return $result;
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
        foreach ($array as $key => $val) {
            if (is_array($val))
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
        if (self::isSerialized($original) === true)
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
    public static function isSerialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;

        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;

        if (isset($badions[1])) {
            switch ($badions[1]) {
                case 'a' :
                case 'O' :
                case 's' :
                    if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                        return true;
                    break;
                case 'b' :
                case 'i' :
                case 'd' :
                    if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                        return true;
                    break;
            }
        }
        return false;
    }

    /**
     * Check if callable class has constructor
     * @param mixed $class Class, object , namespace
     * @return bool
     */
    public static function isHasConstructor($class)
    {
        $array = get_class_methods($class);
        if ($parent_class = get_parent_class($class)) {
            $array2 = get_class_methods($parent_class);
            $result = array_diff($array, $array2);
        } else
            $result = $array;

        return (is_numeric(array_search('__construct', $result))) ? true : false;
    }
}