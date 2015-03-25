<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\MethodNotAllowedException;
use Application\Modules\Rest\Aware\RestValidatorProvider;

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
class ResolveMethodEvent extends RestValidatorProvider {

    /**
     * This action track input events before rest execute
     * @throws \Exception
     */
    public function run(\Phalcon\DI\FactoryDefault $di) {

        $this->setDi($di);

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