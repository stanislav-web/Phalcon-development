<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Http\Response\Exception;

/**
 * Class UnauthorizedException. Represents an HTTP 405 error.
 * The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.
 * The response MUST include an Allow header containing a list of valid methods for the requested resource.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/MethodNotAllowedException.php
 */
class MethodNotAllowedException extends Exception {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Method not allowed';

    /**
     * @const HTTP response code
     */
    const CODE = 405;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Method not allowed' will be the message
     * @param int $code Status code, defaults to 405
     */
     public function __construct() {
         parent::__construct(self::MESSAGE, self::CODE);
     }
}