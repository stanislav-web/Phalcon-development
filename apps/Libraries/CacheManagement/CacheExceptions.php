<?php
namespace Libraries\CacheManagement;

/**
 * CacheExceptions. Extends rules necessary functionality of Exception class
 * @package Phalcon
 * @subpackage  Libraries\CacheManagement
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource apps/Libraries/CacheManagement/CacheExceptions.php
 */
class CacheExceptions extends \Exception
{
    /**
     * Redefine an exception so that the message parameter becomes mandatory
     * @param string $message required
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {

        //  Make sure that all the parameters passed are correct
        parent::__construct($message, $code, $previous);
    }

    /**
     * Redefine the string representation of the object.
     * @access public
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}