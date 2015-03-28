<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;

/**
 * Class QueryStringValidator. Check query string
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/QueryStringValidator.php
 */
class QueryStringValidator {

    const INVALID_FIELDS = 'The fields: %s does not provide by this filter';

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
     * Error messages
     *
     * @var array $errors
     */
    private $errors = [];

    /**
     * Requested fields
     *
     * @var array $fields
     */
    private $fields = [];

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
     * @return QueryStringValidator
     */
    public function setDi($di)
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
     * Set handle mapper
     *
     * @param string $mapper
     * @return QueryStringValidator
     */
    public function setMapper($mapper)
    {
        $this->mapper = $this->getDi()->get($mapper);
        return $this;
    }

    /**
     * Get parsed requested fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set requested fields
     *
     * @param array $params
     * @return QueryStringValidator
     */
    public function setFields(array $params)
    {
        if(isset($params['fields']) === true) {
            $this->fields = explode(',', $params['fields']);
        }
        return $this;
    }

    /**
     * Set error message
     *
     * @param array|string $errors
     * @return QueryStringValidator
     */
    public function setErrors($errors) {

        if(empty($this->errors['info']) === true) {
            $this->errors['code']       = BadRequestException::CODE;
            $this->errors['message']    = BadRequestException::MESSAGE;
        }
        $this->errors['info'][]  = $errors;

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
     * Check if errors exist
     *
     * @return boolean
     */
    public function hasErrors() {

        return (!empty($this->errors));
    }

    /**
     * Validate query string
     *
     * @param \StdClass $rules
     * @param array $params
     * @return $this
     * @throws InternalServerErrorException
     */
    public function validate(\StdClass $rules, array $params) {

        if($this->getDi()->has($rules->mapper) === true) {

            $this->setMapper($rules->mapper)->setFields($params)->resolve();

            return $this;
        }
        else {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Resolve request
     *
     */
    public function resolve()
    {
        if (empty($fields = array_diff($this->getFields(), $this->getMapper()->getAttributes())) === false) {

            $this->setErrors(sprintf(self::INVALID_FIELDS, implode(',', $fields)));
        }
    }
}