<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\ForbiddenException;
use Application\Modules\Rest\Exceptions\UnauthorizedException;

/**
 * ResolveAccessEvent. Watch access
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveAccessEvent.php
 */
class ResolveAccessEvent {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Access rules to current action
     *
     * @var array $rules
     */
    private $rules;

    /**
     * Security service
     *
     * @var \Application\Modules\Rest\Services\SecurityService $security
     */
    private $security;

    /**
     * Request service
     *
     * @var \Phalcon\Http\Request $request
     */
    private $request;

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
     * @return array
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

            $this->rules = $rules[$dispatcher->getControllerName()][$dispatcher->getActionName()];

            if(isset($this->rules['authentication']) === true) {

                $this->security = $this->getDi()->get('RestSecurityService');

                if($this->security->isAuthenticated() === true) {

                    $this->request = $this->getRequest();
                    $this->isAllowedAccess();
                }
                else {
                    try {
                        throw new UnauthorizedException();
                    }
                    catch(UnauthorizedException $e) {

                        $this->getDi()->get('LogMapper')->save($e->getMessage().' IP: '.$this->getRequest()->getClientAddress().' URI: '.$this->getRequest()->getURI(), Logger::ALERT);
                        throw new \Exception($e->getMessage(), $e->getCode());
                    }
                }
            }
        }
    }

    /**
     * Check access by role
     *
     * @throws ForbiddenException
     */
    public function isAllowedAccess() {

        if(isset($this->rules['access']) === true) {

            foreach($this->rules['access'] as $role => $urls) {

                if($this->security->hasRole($role) === false
                    && in_array(trim($this->request->getURI(), '/'), $urls)) {

                    try {
                        throw new ForbiddenException();
                    }
                    catch(ForbiddenException $e) {
                        $this->getDi()->get('LogMapper')->save($e->getMessage().' IP: '.$this->getRequest()->getClientAddress().' URI: '.$this->getRequest()->getURI(), Logger::ALERT);
                        throw new \Exception($e->getMessage(), $e->getCode());
                    }
                }
            }
        }
    }

    /**
     * Free params
     */
    public function __destruct() {

        unset($this->rules);
        unset($this->request);
        unset($this->security);

    }
}