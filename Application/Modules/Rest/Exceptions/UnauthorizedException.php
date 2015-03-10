<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Http\Response\Exception;

/**
 * Class UnauthorizedException. Represents an HTTP 401 error.
 * The request requires user authentication.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/UnauthorizedException.php
 */
class UnauthorizedException extends Exception {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Unauthorized';

    /**
     * @const HTTP response code
     */
    const CODE = 401;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Unauthorized' will be the message
     * @param int $code Status code, defaults to 401
     */
     public function __construct() {
         parent::__construct(self::MESSAGE, self::CODE);
     }
}