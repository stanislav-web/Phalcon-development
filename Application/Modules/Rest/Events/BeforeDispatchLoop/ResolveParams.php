<?php
namespace Application\Modules\Rest\Events\BeforeDispatchLoop;

/**
 * ResolveParams
 * Resolve dispatcher params to key => value
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeDispatchLoop
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeDispatchLoop/ResolveParams.php
 */
class ResolveParams {

    /**
     * This action track routes before execute any action in the application.
     *
     * @param \Phalcon\Events\Event   $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function beforeDispatchLoop(\Phalcon\Events\Event $event = null, $dispatcher)
    {

        $keyParams = [];
        $params = $dispatcher->getParams();

        if (count($params) > 0) {
            $keyParams['id'] = array_shift($params);

            if (count($params) === 1) {
                $params[$params[0]] = [];
            }

            // use odd parameters as keys and even as values
            foreach ($params as $number => $value) {
                if ($number & 1) {
                    $keyParams[$params[$number - 1]] = $value;
                } else {
                    $keyParams[$params[0]] = $value;
                }
            }
        }
        $event->setType('params');

        //Override parameters
        $dispatcher->setParams($keyParams);
    }
}