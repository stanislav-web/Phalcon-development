<?php
namespace Application\Modules\Rest\Services;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Filter;
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
class RestValidationService implements
    RestValidatorInterface, InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Request service
     *
     * @var \Phalcon\Http\Request $request;
     */
    private $request;

    /**
     * Error messages
     *
     * @var array $errors ;
     */
    private $errors = [];

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
     * Initialize dispatcher
     *
     * @return RestValidationService
     */
    public function init() {

        $dispatcher = $this->getDi()->getDispatcher();

        if(isset($rules[$dispatcher->getControllerName()]) === true
            && isset($rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]) === true) {

            $this->setRules($rules[$dispatcher->getControllerName()][$dispatcher->getActionName()]);
        }

        $this->setParams($this->getDi()->getRequest(), $dispatcher);
        $this->filter($this->getParams(), 'trim');

        return $this;
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
        $this->request = $request;
        $this->params = array_merge($request->get(), $request->getHeaders(), $dispatcher->getParams());

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
     * @return object
     */
    public function getRules()
    {
        return (object)$this->rules;
    }

    /**
     * Set error message
     *
     * @param string $error
     * @return RestValidationService
     */
    public function setError($error) {

        $this->errors['errors'][] = $error;
    }

    /**
     * Get error messages key [errors]
     *
     * @return array
     */
    public function getError() {
        return $this->errors;
    }

    /**
     * Filter request params
     *
     * @param array $params
     * @param string $function
     * @example <code>
     *              <?php $this->filter($this->getParams(), 'trim'); ?>
     *          </code>
     * @return RestValidationService
     */
    public function filter(array $params, $function) {

        $filter = new Filter();

        $this->params = array_map(function($value) use ($filter, $function) {
            return $filter->sanitize($value, $function);
        }, $params);

        return $this;
    }


    public function validate() {}

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