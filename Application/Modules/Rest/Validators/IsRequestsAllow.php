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
     * Check if requests allow for ip
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \StdClass $rules
     * @throws ToManyRequestsException
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di, \StdClass $rules) {

        if(isset($rules->requests) === true) {

            $session = $di->getShared('session');
            $ip = $di->getShared('request')->getClientAddress();

            if($session->has('disallow')) {
                if(intval($session->get('disallow'))+intval($rules->requests['time']) > time()) {
                    // disallow access, because to many requests per  $rules->requests['time']
                    throw new ToManyRequestsException();
                }
                else {
                    // reset user requests counter
                    $this->reset($session, $ip);
                }
            }

            // iterate counter
            $this->iterate($session, $ip, $rules);
        }
    }

    /**
     * Reset session requests counter
     *
     * @param \Phalcon\Session\Adapter\Memcache $session
     * @param $ip
     */
    private function reset($session, $ip) {
        $session->remove('disallow');
        $session->remove($ip);
    }

    /**
     * Iterate request counter
     *
     * @param \Phalcon\Session\Adapter\Memcache $session
     * @param $ip
     * @param \StdClass $rules
     */
    private function iterate($session, $ip, $rules) {

        // iterate request for current IP address
        $session->set($ip, intval($session->get($ip)+1));

        if($session->get($ip) >= $rules->requests['limit']) {

            $session->set('disallow', time());
        }
    }
}