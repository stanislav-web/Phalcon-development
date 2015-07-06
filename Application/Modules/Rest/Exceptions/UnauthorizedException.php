<?php
namespace Application\Modules\Rest\Exceptions;

/**
 * Class UnauthorizedException. Represents an HTTP 401 error.
 * The request requires user authentication.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/UnauthorizedException.php
 */
class UnauthorizedException extends BaseException {

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
     * @param array $data additional info
     * @param string $message If no message is given 'Unauthorized' will be the message
     * @param int $code Status code, defaults to 401
     */
    public function __construct(array $data = [], $message = null, $code = null) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code, $data);
    }
}