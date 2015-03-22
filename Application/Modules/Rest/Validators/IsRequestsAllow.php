<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\ToManyRequestsException;

/**
 * Class IsRequestsAllow. Check if requests allow
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsRequestsAllow.php
 */
class IsRequestsAllow {

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
     * Check if requests allow for ip
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @param \StdClass $rules
     * @throws ToManyRequestsException
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di,
                                \Phalcon\Mvc\Dispatcher $dispatcher,
                                \StdClass $rules) {

        if(isset($rules->requests) === true) {

            $this->session = $di->getShared('session');
            $this->ip = $di->getShared('request')->getClientAddress();
            $this->action = $dispatcher->getActionName();

            if($this->session->has($this->action)) {
                if((int)$this->session->get($this->action)+(int)$rules->requests['time'] > time()) {

                    // disallow access, because to many requests per  $rules->requests['time']

                    throw new ToManyRequestsException();
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
    private function iterate($rules) {

        // iterate request for current IP address
        $this->session->set($this->ip, (int)$this->session->get($this->ip)+1);

        if($this->session->get($this->ip) >= $rules->requests['limit']) {

            $this->session->set($this->action, time());
        }
    }

    /**
     * Free params
     */
    public function destruct() {

        unset($this->action);
        unset($this->ip);

    }

}