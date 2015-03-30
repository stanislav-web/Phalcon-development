<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Exceptions\MethodNotAllowedException;
use Application\Modules\Rest\Aware\RestValidatorProvider;

/**
 * ResolveMethod. Watch allowed methods
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveMethod.php
 */
class ResolveMethod extends RestValidatorProvider {

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

        if(isset($rules->methods) === true && is_null($rules->methods) === false) {

            $methods = explode(',', $rules->methods);

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