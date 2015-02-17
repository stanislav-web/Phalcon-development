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

    const NOT_FOUND_CODE                =   404;
    const UNCAUGHT_EXCEPTION_CODE       =   500;
    const NOT_FOUND_MESSAGE             =   'Page Not Found';
    const UNCAUGHT_EXCEPTION_MESSAGE    =   'Internal Server Error';

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
     * Set content to response
     *
     * @param string $template view template
     * @param string $contentType
     * @param string $charset
     * @return \Phalcon\Http\Response
     */
    public function setJsonContent($title, $template, $contentType = 'application/json', $charset = 'UTF-8') {
        $this->getResponse()->setJsonContent([
            'title'     => $title,
            'content'   => $template,
        ])->setContentType($contentType, $charset);

        return $this->getResponse();
    }

    /**
     * Exception logger
     *
     * @param string $message
     */
    public function log($message) {
        if ($this->getDi()->has('LogDbService') === true) {
            $this->getDi()->get('LogDbService')->save($message, \Phalcon\Logger::ERROR);
        }
    }
}