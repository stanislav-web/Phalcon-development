<?php
namespace Libraries\GlobalSearch\Exceptions;

/**
 * Class InvalidTypeException
 * @package Libraries
 * @subpackage Libraries\GlobalSearch\Exceptions
 */
class InvalidTypeException extends \RuntimeException
{
	public function __construct($objectName, $object, $expected, $message = '', $code = 0) {
        return parent::__construct('Wrong Type: '.$objectName.'. Expected $expected, received '.gettype($object), $code);
    }
}