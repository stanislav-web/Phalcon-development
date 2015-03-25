<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\ToManyRequestsException;
use Application\Modules\Rest\Aware\RestValidatorProvider;

/**
 * ResolveRequestEvent. Monitors the limit of requests
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveRequestLimitEvent.php
 */
class ResolveRequestLimitEvent extends RestValidatorProvider  {

    /**
     * Current action name
     *
     * @var string $action
     */
    private $action = '';

    /**
     * Current client IP
     *
     * @var string $ip
     */
    private $ip = '';

    /**
     * Session adapter
     *
     * @var \Phalcon\Session\Adapter\Memcache $session
     */
    private $session;

    /**
     * This action track input events before rest execute
     * @throws \Exception
     */
    public function run() {

        $rules = $this->getRules();
        $dispatcher = $this->getDispatcher();

        if(isset($rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]) === true) {

            $rule = $rules[$dispatcher->getControllerName()][$dispatcher->getActionName()];

            if(isset($rule['requests']) === true) {

                $this->session  = $this->getDi()->getShared('session');
                $this->ip       = $this->getRequest()->getClientAddress();
                $this->action   = $dispatcher->getActionName();

                if($this->session->has($this->action)) {
                    if((int)$this->session->get($this->action)+(int)$rule['requests']['time'] > time()) {

                        // disallow access, because to many requests per  $rules->requests['time']

                        $this->throwError();
                    }
                    else {
                        // reset user requests counter
                        $this->reset();
                    }
                }

                // iterate counter
                $this->iterate($rule);
            }
        }
    }

    /**
     * Reset session requests counter
     *
     * @return null
     */
    private function reset() {
        $this->session->remove($this->action);
        $this->session->remove($this->ip);
    }

    /**
     * Iterate request counter
     *
     * @param array $rule
     */
    private function iterate(array $rule) {

        // iterate request for current IP address
        $this->session->set($this->ip, (int)$this->session->get($this->ip)+1);

        if($this->session->get($this->ip) >= $rule['requests']['limit']) {

            $this->session->set($this->action, time());
        }
    }

    /**
     * Free params
     */
    public function __destruct() {

        unset($this->action);
        unset($this->ip);

    }

    /**
     * Throw exception errors
     *
     * @throws \Application\Modules\Rest\Exceptions\ToManyRequestsException
     * @throws \Exception
     */
    private function throwError() {

        try {
            throw new ToManyRequestsException();
        }
        catch(ToManyRequestsException $e) {

            $this->getDi()->get('LogMapper')->save($e->getMessage().' IP: '.$this->getRequest()->getClientAddress().' URI: '.$this->getRequest()->getURI(), Logger::ALERT);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}