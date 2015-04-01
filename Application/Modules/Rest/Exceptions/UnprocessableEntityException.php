<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Logger;

/**
 * Class UnprocessableEntityException. Represents an HTTP 422 error.
 * The request was well-formed but was unable to be followed due to semantic errors.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/UnprocessableEntityException.php
 */
class UnprocessableEntityException extends BaseException {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Unprocessable Entity';

    /**
     * @const HTTP response code
     */
    const CODE = 422;

    /**
     * Constructor
     *
     * @param array $data additional info
     * @param string $message If no message is given 'Unprocessable Entity' will be the message
     * @param int $code Status code, defaults to 422
     */
    public function __construct(array $data = [], $message = null, $code = null) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code, $data);
    }
}