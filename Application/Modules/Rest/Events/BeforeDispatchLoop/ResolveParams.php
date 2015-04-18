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

            foreach($params as $value) {

                if(empty($value) === false && is_numeric($value) === false) {
                    $keyParams[$value] = (is_numeric(current($params)) === true ) ? current($params) : [];
                }
                else {
                    $keyParams[] = end($params);
                }
            }
            foreach($keyParams as $key => $value){
                if(is_numeric($key)) unset($keyParams[$key]);
            }
        }

        // Override parameters
        $dispatcher->setParams($keyParams);
    }
}