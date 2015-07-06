<?php
namespace Application\Modules\Rest\Exceptions;

/**
 * Class ConflictException. Represents an HTTP 409 error.
 * The Web server (running the Web site) thinks that the request submitted by the client
 * (e.g. your Web browser or our CheckUpDown robot) can not be completed because it conflicts with some rule
 * already established. For example, you may get a 409 error if you try to upload a file to the Web server
 * which is older than the one already there - resulting in a version control conflict.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/ConflictException.php
 */
class ConflictException extends BaseException {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Conflict';

    /**
     * @const HTTP response code
     */
    const CODE = 409;

    /**
     * Constructor
     *
     * @param array $data additional info
     * @param string $message If no message is given 'Conflict' will be the message
     * @param int $code Status code, defaults to 409
     */
    public function __construct(array $data = [], $message = null, $code = null) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code, $data);
    }
}