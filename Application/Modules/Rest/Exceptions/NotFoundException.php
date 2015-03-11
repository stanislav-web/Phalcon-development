<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Http\Response\Exception;

/**
 * Class NotFoundException. Represents an HTTP 404 error.
 * The request could not be understood by the server due to malformed syntax.
 * The client SHOULD NOT repeat the request without modifications.
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
     public function __construct() {
         parent::__construct(self::MESSAGE, self::CODE);
     }
}