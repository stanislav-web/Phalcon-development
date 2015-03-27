<?php
namespace Application\Modules\Rest\Events\BeforeExecuteRoute;

use Phalcon\Logger;
use Application\Modules\Rest\Aware\RestValidatorProvider;

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
     * @return bool|void
     * @throws \Exception
     */
    public function run(\Phalcon\DI\FactoryDefault $di, \StdClass $rules) {

        $this->setDi($di);

        if($this->isValidFields(func_get_args()) === false) {
            $this->throwError();
        }
    }

    public function isValidFields($a) {

        var_dump($a); exit;
        return true;
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