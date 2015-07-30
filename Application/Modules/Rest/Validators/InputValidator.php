<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;

/**
 * Class InputValidator. Check query string
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/InputValidator.php
 */
class InputValidator {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Request handler
     *
     * @var void $mapper
     */
    private $mapper;

    /**
     * Requested columns
     *
     * @var array $columns
     */
    private $columns = [];

    /**
     * Requested params
     *
     * @var array $params
     */
    private $params = [];

    /**
     * Rules by this action
     *
     * @var array $rules
     */
    private $rules = [];

    /**
     * Setup definition
     *
     * @param \Phalcon\Di\FactoryDefault $di
     */
    public function __construct(\Phalcon\Di\FactoryDefault $di) {

        $this->setDi($di);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     * @return InputValidator
     */
    public function setDi(\Phalcon\DiInterface $di)
    {
        $this->di = $di;

        return $this;
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
     * Handle mapper
     *
     * @return object
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Get Translate service
     *
     * @return \Translate\Translator|null
     */
    private function getTranslator() {

        if($this->getDi()->has('TranslateService') === true) {
            return $this->getDi()->get('TranslateService')->assign('errors');
        }

        return null;
    }

    /**
     * Set handle mapper
     *
     * @param string $mapper
     * @return InputValidator
     */
    public function setMapper($mapper)
    {
        $this->mapper = $this->getDi()->get($mapper);

        return $this;
    }

    /**
     * Get parsed requested columns
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set requested columns
     *
     * @param array $params
     * @return InputValidator
     */
    public function setColumns(array $params)
    {

        if(isset($params['columns']) === true) {
            $this->columns = explode(',', $params['columns']);
        }
        return $this;
    }

    /**
     * Get params for this action
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set params for this action
     *
     * @param array $params
     * @return InputValidator
     */
    public function setParams(array $params = [])
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get rules for this action
     *
     * @return \StdClass
     */
    public function getRules()
    {
        return (object)$this->rules;
    }

    /**
     * Set rules for this action
     *
     * @param \StdClass $rules
     * @return InputValidator
     */
    public function setRules(\StdClass $rules)
    {
        if(isset($rules->params) === true) {

            foreach($rules->params as $rule => $params) {
                $this->rules[$rule] = explode(',', $params);
            }
        }
        return $this;
    }

    /**
     * Validate query string
     *
     * @param \StdClass $rules
     * @param array $params
     * @return InputValidator
     * @throws InternalServerErrorException
     */
    public function validate(\StdClass $rules, array $params) {

        if(isset($rules->mapper) && $this->getDi()->has($rules->mapper) === true) {

            $this->setMapper($rules->mapper)
                ->setRules($rules)
                ->setParams($params)
                ->setColumns($params)->resolve();

            return $this;
        }
        else {
            $t = $this->getTranslator()->assign('errors');

            throw new InternalServerErrorException($t->translate('MAPPER_NOT_EXIST'), 500);
        }
    }

    /**
     * Check if rules required param equal by query string
     */
    public function isRequiredParam() {

        if(empty($this->rules) === false) {

            $required = array_flip($this->getRules()->required);
            $exchange = array_diff_key($required, $this->getParams());
            if(empty($exchange) === false) {

                $t = $this->getTranslator()->assign('errors');

                throw new BadRequestException([
                    'INVALID_REQUIRED_FIELDS' => sprintf($t->translate('INVALID_REQUIRED_FIELDS'), implode(',', array_flip($exchange)))
                ]);
            }
        }
    }

    /**
     * Check if mapper columns are not empty
     */
    public function isEmptyParam() {

        if(count(array_filter($this->getColumns())) !== count($this->getColumns())) {

            $t = $this->getTranslator()->assign('errors');

            throw new BadRequestException([
                'EMPTY_PARAMETER_IN_URI' => $t->translate('EMPTY_PARAMETER_IN_URI')
            ]);
        }
    }

    /**
     * Check if mapper columns are support by query
     */
    public function isColumnSupport() {

        $columns = array_diff($this->getColumns(), $this->getMapper()->getAttributes());
        if (empty($columns) === false) {

            $t = $this->getTranslator()->assign('errors');

            throw new BadRequestException([
                'INVALID_COLUMNS' => sprintf($t->translate('INVALID_COLUMNS'), implode(',', $columns))
            ]);
        }
    }

    /**
     * Resolve request
     */
    public function resolve()
    {
        // check required params
        $this->isRequiredParam();

        // check for empty params
        $this->isEmptyParam();

        // check for supported columns
        $this->isColumnSupport();
    }
}