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
     * Get shared dispatcher
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher() {
        return $this->getDi()->getShared('dispatcher');
    }

    /**
     * This action track input events before rest execute
     * @throws \Exception
     */
    public function run() {

        $rules = $this->getRules();
        $dispatcher = $this->getDispatcher();

        if(isset($rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]) === true) {

            $methods = explode(',', $rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]['methods']);

            if(in_array($this->getRequest()->getMethod(), $methods) === false) {

                $this->throwError($this->getRequest());
            }
        }
    }

    /**
     * Throw exception errors
     *
     * @param \Phalcon\Http\Request $request
     * @throws \Application\Modules\Rest\Exceptions\MethodNotAllowedException
     * @throws \Exception
     */
    private function throwError($request) {

        try {
            throw new MethodNotAllowedException();
        }
        catch(MethodNotAllowedException $e) {

            $this->getDi()->get('LogMapper')->save($e->getMessage().' IP: '.$request->getClientAddress().' URI: '.$request->getURI(), Logger::ALERT);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}