<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\MethodNotAllowedException;

/**
 * ResolveMethodEvent. Watch allowed methods
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveMethodEvent.php
 */
class ResolveMethodEvent {

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
     * Get api rules
     *
     * @return \Phalcon\Config
     */
    public function getRules() {
        return $this->getDi()->getShared('RestRules');
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
     */
    public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher) {

        $rules = $this->getRules();
        if(isset($rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]) === true) {

            $methods = explode(',', $rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]['methods']);

            if(in_array($this->getRequest()->getMethod(), $methods) === false) {

                $this->throwError();
            }
        }
    }

    /**
     * Throw exception errors
     *
     * @throws \Application\Modules\Rest\Exceptions\MethodNotAllowedException
     * @throws \Exception
     */
    private function throwError() {

        try {
            throw new MethodNotAllowedException();
        }
        catch(MethodNotAllowedException $e) {

            //@TODO JSON response need
            $this->getDi()->get('LogMapper')->save($e->getMessage().' File: '.$e->getFile().' Line:'.$e->getLine(), Logger::ALERT);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}