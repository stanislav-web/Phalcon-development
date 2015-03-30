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
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveRequestLimit.php
 */
class ResolveRequestLimit extends RestValidatorProvider  {

    /**
     * Current action name
     *
     * @var string $action
     */
    private $action = '';

    /**
     * Current action rules
     *
     * @var string $rules
     */
    private $rules = '';

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
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \StdClass                  $rules
     * @return bool|void
     * @throws \Exception
     */
    public function run(\Phalcon\DI\FactoryDefault $di, \StdClass $rules) {

        $this->setDi($di);

        $dispatcher = $this->getDispatcher();


        if(isset($rules->requests) === true) {

            $this->session  = $this->getDi()->getShared('session');
            $this->ip       = $this->getRequest()->getClientAddress();
            $this->action   = $dispatcher->getActionName();
            $this->rules    = $rules;

            if($this->session->has($this->action)) {
                if((int)$this->session->get($this->action)+(int)$this->rules->requests['time'] > time()) {

                    // disallow access, because to many requests per  $rules->requests['time']
                    throw new ToManyRequestsException([
                        'TO_MANY_REQUESTS'  =>  'Too many requests for this action'
                    ]);
                }
                else {
                    // reset user requests counter
                    $this->reset();
                }
            }

            // iterate counter
            $this->iterate($rules);
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
     * @param \StdClass $rules
     */
    private function iterate(\StdClass $rules) {

        // iterate request for current IP address
        $this->session->set($this->ip, (int)$this->session->get($this->ip)+1);

        if($this->session->get($this->ip) >= $rules->requests['limit']) {
            $this->session->set($this->action, time());
        }
    }

    /**
     * Free params
     */
    public function __destruct() {

        unset($this->ip, $this->action, $this->rules);
    }
}