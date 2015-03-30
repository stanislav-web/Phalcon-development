<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Logger;

/**
 * Class NotAcceptableException. Represents an HTTP 406 error.
 * The resource identified by the request is only capable of generating response entities
 * which have content characteristics not acceptable according to the accept headers sent in the request.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/NotAcceptableException.php
 */
class NotAcceptableException extends BaseException {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Not Acceptable';

    /**
     * @const HTTP response code
     */
    const CODE = 406;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Not Acceptable' will be the message
     * @param int $code Status code, defaults to 406
     */
    public function __construct($message = null, $code = null, array $data = []) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code, $data);
    }
}