<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Http\Response\Exception;

/**
 * Class NotFoundException. Represents an HTTP 404 error.
 * The server has not found anything matching the Request-URI.
 * No indication is given of whether the condition is temporary or permanent.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/NotFoundException.php
 */
class NotFoundException extends Exception {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Not Found';

    /**
     * @const HTTP response code
     */
    const CODE = 404;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Not Found' will be the message
     * @param int $code Status code, defaults to 404
     */
    public function __construct($message = null, $code = null) {
        if(is_null($message) === true && is_null($code) === true) {
            parent::__construct(self::MESSAGE, self::CODE);
        }
        else {
            parent::__construct($message, $code);
        }
    }
}