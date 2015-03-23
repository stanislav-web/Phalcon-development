<?php
namespace Application\Modules\Rest\Exceptions;

use \Phalcon\Http\Response\Exception;
use \Phalcon\DI;
use \Phalcon\Logger;
/**
 * Class BaseException
 *
 * @package Application\Modules\Rest
 * @subpackage    Exceptions
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Exceptions/BaseException.php
 */
class BaseException extends Exception {

    /**
     * Constructor
     *
     * @param string $message
     * @param int $code
     * @param \Phalcon\Logger|int $status
     */
    public function __construct($message, $code, $status = Logger::CRITICAL) {

        if($this->getDi()->get('RestConfig')->api->exceptionLog === true) {

            $this->getDi()->get('LogMapper')
                ->save($this->format($code, $message), $status);
        }

        parent::__construct($message, $code);
    }

    /**
     * Format log  messages
     *
     * @param int $code
     * @param string $message
     * @return string
     */
    private function format($code, $message) {

        $request = $this->getDi()->getRequest();

        return  $code.' '.$message.' '.$request->getURI().' '.$request->getClientAddress()
            .PHP_EOL.' '.$this->getFile()
            .PHP_EOL.' '.$this->getLine();
    }

    /**
     * @return \Phalcon\DiInterface
     */
    private function getDi() {
        return DI::getDefault();
    }
}

