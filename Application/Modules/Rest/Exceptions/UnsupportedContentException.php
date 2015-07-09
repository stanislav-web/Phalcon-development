<?php
namespace Application\Modules\Rest\Exceptions;

/**
 * Class UnsupportedContentException. Represents an HTTP 415 error.
 * The server (running the Web site) thinks that the HTTP data stream sent by the client
 * (e.g. your Web browser or our CheckUpDown robot) identifies a URL resource
 * whose actual media type 1) does not agree with the media type specified on the request or 2) is incompatible with the current data for the resource or 3)
 * is incompatible with the HTTP method specified on the request.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/UnsupportedContentException.php
 */
class UnsupportedContentException extends BaseException {

    /**
     * @const HTTP response message
     */
    const MESSAGE = 'Unsupported Media Content-Type';

    /**
     * @const HTTP response code
     */
    const CODE = 415;

    /**
     * Constructor
     *
     * @param array $data additional info
     * @param string $message If no message is given 'Unsupported Media Content-Type' will be the message
     * @param int $code Status code, defaults to 415
     */
    public function __construct(array $data = [], $message = null, $code = null) {

        if(is_null($message) === true && is_null($code) === true) {

            $message = self::MESSAGE;
            $code = self::CODE;
        }

        parent::__construct($message, $code, $data);
    }
}