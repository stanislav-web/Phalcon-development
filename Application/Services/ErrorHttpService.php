<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;

/**
 * Class ErrorHttpService. Http exceptions handler
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/ErrorHttpService.php
 */
class ErrorHttpService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get server request
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest()
    {
        return $this->getDi()->get('request');
    }

    /**
     * Get server response
     *
     * @return \Phalcon\Http\Response
     */
    public function getResponse()
    {
        return $this->getDi()->get('response');
    }

    /**
     * Set status and message
     *
     * @param int $code response code
     * @param string $message response message
     * @return ErrorHttpService
     */
    public function setStatus($code, $message = '') {
        $this->getResponse()->setStatusCode($code, $message);
        return $this;
    }

    /**
     * Exception logger
     *
     * @param string $message
     */
    public function log($message) {
        if ($this->getDi()->has('LogService') === true) {
            $this->getDi()->get('LogService')->save($message, \Phalcon\Logger::ERROR);
        }
    }
}