<?php
namespace Application\Modules\Rest\Services\Events\BeforeDispatchLoop;

/**
 * ResolveParamsEvent
 * Resolve dispatcher params to key => value
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeDispatchLoop
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/Events/BeforeDispatchLoop/ResolveParamsEvent.php
 */
class ResolveParamsEvent {

    /**
     * This action track routes before execute any action in the application.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function beforeDispatchLoop(\Phalcon\Events\Event $event, $dispatcher) {

        $keyParams = array();
        $params = $dispatcher->getParams();

        // use odd parameters as keys and even as values
        foreach ($params as $number => $value) {
            if ($number & 1) {
                $keyParams[$params[$number - 1]] = $value;
            }
        }

        //Override parameters
        $dispatcher->setParams($keyParams);
    }
}