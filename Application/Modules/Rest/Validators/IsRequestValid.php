<?php
namespace Application\Modules\Rest\Validators;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;

/**
 * Class IsRequestValid. Check if request params is valid
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsRequestValid.php
 */
class IsRequestValid {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Filtered params
     *
     * @var array $params
     */
    private $params = [];

    /**
     * Requested fields
     *
     * @var array $fields
     */
    private $fields = [];

    /**
     * Requested fields
     *
     * @var array $fields
     */
    private $mapper = null;

    /**
     * Check if request params is valid
     *
     * @param array $params
     * @param \StdClass $rules
     * @throws BadRequestException
     */
    public function __construct(\Phalcon\Di\FactoryDefault $di, array $params, \StdClass $rules) {

        $this->setDi($di)->setParams($params)->setFields()->setMapper($rules->handler);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     * @return IsRequestValid
     */
    public function setDi($di)
    {
        $this->di = $di;

        return $this;
    }

    /**
     * Get dependency container
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get requested params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set requested params
     *
     * @param array $params
     * @return IsRequestValid
     */
    public function setParams(array $params)
    {
        $this->params = $params;
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
     * @return IsRequestValid
     */
    public function setFields()
    {
        if(isset($this->params['fields'])) {
            $this->fields = explode(',', $this->params['fields']);
        }
        return $this;
    }

    /**
     * Handle mapper
     *
     * @return \Application\Services\Mappers\PageMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Set handle mapper
     *
     * @param string $mapper
     * @return IsRequestValid
     */
    public function setMapper($mapper)
    {
        if($this->getDi()->has($mapper)) {
            $this->mapper = $this->getDi()->get($mapper);
        }
        else {
            throw new InternalServerErrorException();
        }
        return $this;
    }

    /**
     * Handle request
     *
     * @param string $mapper
     */
    public function handle()
    {
        if (empty($not = array_diff($this->getFields(), $this->getMapper()->getAttributes())) === false) {
            throw new BadRequestException();
        }
    }
}