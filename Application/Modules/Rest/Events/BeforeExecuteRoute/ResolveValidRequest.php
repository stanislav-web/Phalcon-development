<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Aware\RestValidatorProvider;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use Application\Modules\Rest\Exceptions\BadRequestException;

/**
 * ResolveValidRequest. Validate request params
 *
 * @package Application\Modules\Rest\Services
 * @subpackage Events\BeforeExecuteRoute
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Events/BeforeExecuteRoute/ResolveValidRequest.php
 */
class ResolveValidRequest extends RestValidatorProvider  {

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
     * This action track input events before rest execute
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \StdClass                  $rules
     * @throws \Exception
     */
    public function run(\Phalcon\DI\FactoryDefault $di, \StdClass $rules) {

        // set request params and handle mapper
        $this->setDi($di)->setParams(func_get_arg(2))->setMapper($rules->handler);

        if(isset($this->getParams()->fields) === true) {
           $this->setFields($this->getParams()->fields)->isValidFields();
        }
    }

    /**
     * Get request params
     *
     * @return array
     */
    public function getParams()
    {
        return (object)$this->params;
    }

    /**
     * Set request params
     *
     * @param array $params
     * @return ResolveValidRequest
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Set requested `fields`
     *
     * @param string fields
     * @return ResolveValidRequest
     */
    public function setFields($fields)
    {
        $this->fields = explode(',', $fields);

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
    public function isValidFields()
    {
        if (empty($not = array_diff($this->getFields(), $this->getMapper()->getAttributes())) === false) {
            throw new BadRequestException();
        }
    }
}