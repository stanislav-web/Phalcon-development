<?php
namespace Application\Services\Http;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Modules\Rest\Exceptions;

use \Valitron\Validator;

/**
 * Class RestValidationService. Rest validator
 *
 * @package Application\Services
 * @subpackage Http
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Http/RestValidationService.php
 */
class RestValidationService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

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
        $this->setParams($rqst, $dsp);
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
    public function setParams(\Phalcon\Http\Request $request, \Phalcon\Mvc\Dispatcher $dispatcher)
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
    public function setRules(array $rules)
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
        return $this->rules;
    }

    public function validate() {
        
    }
}