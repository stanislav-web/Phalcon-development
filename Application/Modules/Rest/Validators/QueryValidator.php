<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;

/**
 * Class QueryValidator. Check query string
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/QueryValidator.php
 */
class QueryValidator {

    const EMPTY_PARAMETER_IN_URI = 'Empty parameter in URI';
    const INVALID_COLUMNS = 'The columns: `%s` does not provide by this filter';

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
     * Requested columns
     *
     * @var array $columns
     */
    private $columns = [];

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
     * @return QueryValidator
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
     * @return QueryValidator
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
     * @return QueryValidator
     */
    public function setColumns(array $params)
    {
        if(isset($params['columns']) === true) {
            $this->columns = explode(',', $params['columns']);
        }
        return $this;
    }

    /**
     * Set error message
     *
     * @param array|string $errors
     * @return QueryValidator
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

            $this->setMapper($rules->mapper)
                ->setColumns($params)->resolve();

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

        if(count(array_filter($this->getColumns())) !== count($this->getColumns())) {
            $this->setErrors([
                'EMPTY_PARAMETER_IN_URI' => sprintf(self::EMPTY_PARAMETER_IN_URI)
            ]);
            return;
        }

        if (empty($columns = array_diff($this->getColumns(), $this->getMapper()->getAttributes())) === false) {
            $this->setErrors(['INVALID_COLUMNS' => sprintf(self::INVALID_COLUMNS, implode(',', $columns))]);
            return;
        }
    }
}