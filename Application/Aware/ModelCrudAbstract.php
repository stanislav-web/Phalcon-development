<?php
namespace Application\Aware;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Phalcon\DI\InjectionAwareInterface;

/**
 * ModelCrudAbstract. Implementing rules necessary intended for service's models
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/ModelCrudAbstract.php
 */
abstract class ModelCrudAbstract implements InjectionAwareInterface {

    /**
     * Exception info
     * @var array $exceptions
     */
    protected $exceptions = [
        'NOT_FOUND' => [
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]
    ];

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

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
     * Get model attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        $metaData = $this->getInstance()->getModelsMetaData();
        return $metaData->getAttributes($this->getInstance());
    }

    /**
     * Read pages
     *
     * @param array $credentials credentials
     * @return mixed
     */
    public function read(array $credentials = []) {

        $result = $this->getInstance()->find($credentials);

        if($result->count() > 0) {
            return $result;
        }
        else {
            throw new NotFoundException($this->getException('NOT_FOUND'));
        }
    }

    /**
     * Get exception info
     *
     * @param int $code
     * @return mixed
     * @throws InternalServerErrorException
     */
    private function getException($code) {

        if(isset($this->exceptions[$code]) === true) {
            return $this->exceptions[$code];
        }
        else {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Get instance of polymorphic Model
     *
     * @return Model
     */
    abstract public function getInstance();
}