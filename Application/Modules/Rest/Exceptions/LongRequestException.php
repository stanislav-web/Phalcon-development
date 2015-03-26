<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Logger;

/**
 * Class LongRequestException. Represents an HTTP 414 error.
 * The Web server (running the Web site) thinks that the HTTP data stream sent by the client
 * (e.g. your Web browser or our CheckUpDown robot) contains a URL that is simply too large i.e. too many bytes.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/LongRequestException.php
 */
class LongRequestException extends \Exception {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Request URI Too Long';

    /**
     * @const HTTP response code
     */
    const CODE = 414;

    /**
     * Constructor
     *
     * @param string $message If no message is given 'Request URI Too Long' will be the message
     * @param int $code Status code, defaults to 414
     */
    public function __construct($message = null, $code = null) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code);
    }
}