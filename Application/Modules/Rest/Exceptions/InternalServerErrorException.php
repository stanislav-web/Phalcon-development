<?php
namespace Application\Modules\Rest\Exceptions;

use Phalcon\Logger;

/**
 * Class InternalServerErrorException. Represents an HTTP 500 error.
 * The server encountered an unexpected condition which prevented it from fulfilling the request.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/InternalServerErrorException.php
 */
class InternalServerErrorException extends BaseException {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Internal Server Error';

    /**
     * @const HTTP response code
     */
    const CODE = 500;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Internal Server Error' will be the message
     * @param int $code Status code, defaults to 500
     */
     public function __construct($message = null, $code = null) {

         if(is_null($message) === true && is_null($code) === true) {

             $message = self::MESSAGE;
             $code = self::CODE;
         }

         parent::__construct($message, $code, Logger::CRITICAL);
     }
}