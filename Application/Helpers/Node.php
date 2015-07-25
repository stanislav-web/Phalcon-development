<?php
namespace Application\Helpers;

/**
 * Node class. Work with data type
 *
 * @package Application
 * @subpackage Helpers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /Application/Helpers/Node.php
 */
trait Node {
    /**
     * Check if array have nested tree
     *
     * @param $a
     * @return bool
     */
    public static function isNestedArray(array $array) {
        foreach ($array as $v) {
            if (is_array($v) === true) return true;
        }
        return false;
    }

    /**
     * Search in array by pair key => value
     *
     * @param array|string $array
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    public static function searchInArray($array, $key, $value) {

        $results = [];

        if (is_array($array)) {
            if (isset($array[$key]) === true && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subArray) {
                $results = array_merge($results, self::searchInArray($subArray, $key, $value));
            }
        }

        return $results;
    }

    /**
     * Convert object to array
     *
     * @param $obj
     * @return array
     */
    public static function objectToArray($obj)
    {
        if (is_object($obj)) $obj = (array)$obj;
        if (is_array($obj)) {
            $new = [];
            foreach ($obj as $key => $val) {
                $new[$key] = self::objectToArray($val);
            }
        } else $new = $obj;
        return $new;
    }

    /**
     * Convert multidimensional array to key => pair array
     *
     * @param array $array
     * @return array
     */
    public static function arrayToPair(array $array)
    {
        $result = [];
        if (!empty($array)) {
            foreach ($array as $n => $values) {
                if (count($values) == 2) {
                    $values = array_values($values);
                    $result[$values[0]] = $values[1];
                }
            }
        }
        return $result;
    }

    /**
     * Nested Tree builder
     *
     * @param array $elements
     * @param int   $parentId
     * @return array
     */
    public static function setNestedTree(array $elements, $parentId = null) {

        $branch = [];

        foreach ($elements as $element) {

            if ($element['parent_id'] == $parentId) {
                $children = self::setNestedTree($elements, $element['id']);
                if ($children) {
                    $element['childs'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    /**
     * Reverse object to an array
     *
     * @param object $obj
     * @return array
     */
    public static function asRealArray($obj) {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? self::asRealArray($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }

    /**
     * Set key for multidimensional array
     *
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function arraySetKey(array $array, $key)
    {
        $result = [];
        if (!empty($array)) {
            foreach ($array as $n => $values) {
                if (isset($values[$key])) {
                    $result[$values[$key]] = $values;
                }
            }
        }

        return $result;
    }

    /**
     * Add handler to even array values
     *
     * @param $obj
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
     *
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
     *
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
     *
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

    /**
     * Get object properties
     *
     * @param     $object
     * @param int $flag
     *
     * @return array
     */
    public static function getObjectProperties($object, $flag = \ReflectionProperty::IS_PUBLIC) {

        $data = [];
        $reflectionClass = new \ReflectionClass($object);
        $properties   = $reflectionClass->getProperties($flag);

        foreach($properties as $property) {
            $data[$property->getName()] = $reflectionClass->getProperty($property->getName())->getValue($object);
        }

        return $data;
    }
}