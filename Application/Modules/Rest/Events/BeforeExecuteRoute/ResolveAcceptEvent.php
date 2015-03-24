<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\NotAcceptableException;

/**
 * ResolveAcceptEvent. Watch allowed methods
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveAcceptEvent.php
 */
class ResolveAcceptEvent {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Setup Dependency container
     *
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di) {
        $this->setDi($di);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function setDi(\Phalcon\DI\FactoryDefault $di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get api config
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->getDi()->getShared('RestConfig')->api;
    }

    /**
     * Get shared request
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest() {
        return $this->getDi()->getShared('request');
    }

    /**
     * This action track routes before execute any action in the application.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @throws NotAcceptableException
     */
    public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher) {

        if($this->isValidQueryParams() === false) {
            $this->throwError();
        }

        if($this->isValidContentType() === false) {
            $this->throwError();
        }

        if($this->isValidLanguage() === false) {
            $this->throwError();
        }
    }

    /**
     * Check query string by wrong parameters
     *
     * @return bool
     */
    private function isValidQueryParams() {

        $queryString = $this->getRequest()->get();

        if(isset($queryString['_url'])) {
            unset($queryString['_url']);
        }

        $undefinedValues = array_diff_key($queryString, array_flip($this->getConfig()->acceptFilters->toArray()));
        return (empty($undefinedValues) === false)  ? false : true;
    }

    /**
     * Check if requested content-type is acceptable by api
     *
     * @return bool
     */
    private function isValidContentType() {

        $format = $this->getRequest()->get('format', 'lower', null);

        if(is_null($format) === true) {
            $format = strtolower($this->getRequest()->getBestAccept());
        }

        return in_array($format, $this->getConfig()->acceptContent->toArray());
    }

    /**
     * Check if requested locale (language) is acceptable by api
     *
     * @return bool
     */
    private function isValidLanguage() {

        $locale = $this->getRequest()->get('locale', 'lower', null);

        if(is_null($locale) === true) {

            $locale = strtolower(substr($this->getRequest()->getBestLanguage(), 0, 2));
        }

        return in_array($locale, $this->getConfig()->acceptLanguage->toArray());
    }

    /**
     * Throw exception errors
     *
     * @throws \Application\Modules\Rest\Exceptions\NotAcceptableException
     * @throws \Exception
     */
    private function throwError() {

        try {
            throw new NotAcceptableException();
        }
        catch(NotAcceptableException $e) {

            //@TODO JSON response need
            $this->getDi()->get('LogMapper')->save($e->getMessage().' File: '.$e->getFile().' Line:'.$e->getLine(), Logger::ALERT);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}