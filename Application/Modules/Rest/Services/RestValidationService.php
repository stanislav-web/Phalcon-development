<?php
namespace Application\Modules\Rest\Services;

use Application\Modules\Rest\Aware\RestValidatorInterface;
use Application\Modules\Rest\Exceptions;

use \Valitron\Validator;

/**
 * Class RestValidationService. Rest validator
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestValidationService.php
 */
class RestValidationService implements RestValidatorInterface {

    /**
     * Request service
     *
     * @var \Phalcon\Http\Request $request;
     */
    private $request;

    /**
     * Request rules
     *
     * @var array $rules;
     */
    private $rules  = [];

    /**
     * Request rules
     *
     * @var array $rules;
     */
    private $params  = [];

    /**
     * Init validator rules
     *
     * @param \Phalcon\Http\Request $rqst
     * @param \Phalcon\Mvc\Dispatcher $dsp
     * @param array $rules
     */
    public function __construct(\Phalcon\Http\Request $rqst,
                                \Phalcon\Mvc\Dispatcher $dsp, array $rules) {

        // Checkout validation rules

        if(isset($rules[$dsp->getControllerName()]) === true
            && isset($rules[$dsp->getControllerName()][$dsp->getActionName()]) === true) {

            $this->setRules($rules[$dsp->getControllerName()][$dsp->getActionName()]);

        }

        // Set request params
        $this->request = $rqst;
        $this->setParams($this->request, $dsp);
    }

    /**
     * Set possible request params
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return RestValidationService
     */
    private function setParams(\Phalcon\Http\Request $request, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $this->params = array_merge($request->get(), $dispatcher->getParams());

        return $this;
    }

    /**
     * Get request params
     *
     * @return array $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set validation rules
     *
     * @param array $rules
     * @return RestValidationService
     */
    private function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get validation rules
     *
     * @return array $rules
     */
    public function getRules()
    {
        return (object)$this->rules;
    }

    /**
     * Check if request method is allowed by current action
     *
     * @return bool
     * @throws Exceptions\MethodNotAllowedException
     * @return RestValidationService
     */
    public function isAllowMethods() {

        $methods = explode(',', $this->getRules()->methods);

        if(in_array($this->request->getMethod(),$methods) === false) {

            throw new Exceptions\MethodNotAllowedException();
        }

        return $this;
    }
}