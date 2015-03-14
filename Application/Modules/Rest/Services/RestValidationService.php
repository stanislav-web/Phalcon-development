<?php
namespace Application\Modules\Rest\Services;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Modules\Rest\Aware\RestValidatorInterface;
use Application\Modules\Rest\Exceptions;

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
class RestValidationService implements InjectionAwareInterface, RestValidatorInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

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

        /**
         *
         */
        call_user_func($this->setRequestParams(function() use ($rqst, $dsp) {

            $this->request = $rqst;
            $this->params = array_merge($rqst->get(), $dsp->getParams());
        }));

var_dump($this->request);
        //$this->setParams($this->request, $dsp);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
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

    public function validate() {

        $this->isAllowMethods();
    }

    /**
     * Check if request method is allowed by current action
     *
     * @return bool
     * @throws Exceptions\MethodNotAllowedException
     */
    public function isAllowMethods() {

        $methods = explode(',', $this->getRules()->methods);
        if(in_array($this->request->getMethod(),$methods) === false) {
            throw new Exceptions\MethodNotAllowedException();
        }

        return true;
    }
}