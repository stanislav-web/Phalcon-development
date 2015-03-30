<?php
namespace Application\Modules\Rest\Exceptions;
use \Phalcon\Logger;

/**
 * Class BaseException.
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/NotFoundException.php
 */
class BaseException extends \Exception {

    /**
     * Constructor
     *
     * @param string $message If no message is given default from child
     * @param int $code Status code, default from child
     * @param array $data Additional data to be represent by exception throw
     */
    public function __construct($message = null, $code = null, array $data) {

        if(empty($data) === false) {
            parent::__construct(json_encode(['data' => array_merge(['message' => $message], $data)]), $code);
        }
        else {
            parent::__construct($message, $code);
        }
    }
}