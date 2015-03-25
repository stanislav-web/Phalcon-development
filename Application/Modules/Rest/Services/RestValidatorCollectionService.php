<?php
namespace Application\Modules\Rest\Services;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Filter;
use Application\Modules\Rest\Aware\RestValidatorInterface;
use Application\Modules\Rest\Validators;

/**
 * Class RestValidatorCollectionService. Rest validator's collections
 *
 * @package Application\Modules\Rest
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Services/RestValidatorCollectionService.php
 */
class RestValidatorCollectionService implements
    RestValidatorInterface, InjectionAwareInterface {

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
     * Error messages
     *
     * @var array $errors ;
     */
    private $errors = [];

    /**
     * Request validators
     *
     * @var array $validators;
     */
    private $validators  = [];

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
     * Setup validators
     *
     * @param array $validators
     */
    public function __construct(array $validators) {
        $this->setValidators($validators);
    }

    /**
     * Initialize dispatcher
     *
     * @param array $rules
     * @return RestValidationService
     */
    public function init() {

        foreach($this->getValidators() as $v) {
            $v->run($this->getDi());
        }

        $dsp = $this->getDispatcher();
        $rules = $this->getDi()->getShared('RestRules');

        if(isset($rules[$dsp->getControllerName()][$dsp->getActionName()]) === true) {

            $this->setRules($rules[$dsp->getControllerName()][$dsp->getActionName()]);
        }

        $this->setParams($this->getDi()->get('request'));
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
     * Get dispatcher instance
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher()
    {
        return $this->getDi()->getShared('dispatcher');
    }

    /**
     * Set possible request params
     *
     * @param \Phalcon\Http\Request $request
     * @return RestValidationService
     */
    public function setParams(\Phalcon\Http\Request $request)
    {
        $this->setRequest($request);
        $this->params = $request->get();

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
     * Get api config
     *
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->getDi()->get('RestConfig')->api;
    }

    /**
     * Set validators
     *
     * @param array $validators
     * @return RestValidationService
     */
    public function setValidators(array $validators)
    {
        $this->validators = $validators;

        return $this;
    }

    /**
     * Get validators
     *
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
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
     * @param array|string $errors
     * @return RestValidationService
     */
    public function setErrors($errors) {

        $this->errors['errors'][] = $errors;

        return $this;
    }

    /**
     * Get error messages key [errors]
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get request object
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set request object
     *
     * @param \Phalcon\Http\Request $request
     */
    public function setRequest(\Phalcon\Http\Request $request)
    {
        $this->request = $request;

        return $this;
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

    public function isValid() {

        (new Validators\IsRequestValid($this->getDi(), $this->getParams(), $this->getRules()))->handle();

    }
}