<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Logger;

/**
 * Class BadRequestException. Represents an HTTP 400 error.
 * The request could not be understood by the server due to malformed syntax.
 * The client SHOULD NOT repeat the request without modifications.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/BadRequestException.php
 */
class BadRequestException extends BaseException {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Bad Request';

    /**
     * @const HTTP response code
     */
    const CODE = 400;

    /**
     * Constructor
     *
     * @param array $data additional info
     * @param string $message If no message is given 'Bad Request' will be the message
     * @param int $code Status code, defaults to 400
     */
    public function __construct(array $data = [], $message = null, $code = null) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code, $data);
    }
}