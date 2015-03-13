<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Http\Response\Exception;

/**
 * Class ForbiddenException. Represents an HTTP 403 error.
 * Similar to 403 Forbidden,
 * but specifically for use when authentication is required and has failed or has not yet been provided.
 * The response must include a WWW-Authenticate header
 * field containing a challenge applicable to the requested resource.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/ForbiddenException.php
 */
class ForbiddenException extends Exception {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Forbidden';

    /**
     * @const HTTP response code
     */
    const CODE = 403;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Forbidden' will be the message
     * @param int $code Status code, defaults to 403
     */
     public function __construct() {
         parent::__construct(self::MESSAGE, self::CODE);
     }
}