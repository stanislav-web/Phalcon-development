<?php
namespace Application\Aware;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Mvc\Model\Resultset\Simple as ResultSet;

/**
 * AbstractModelCrud. Implementing rules necessary intended for service's models
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/AbstractModelCrud.php
 */
abstract class AbstractModelCrud implements InjectionAwareInterface {

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
     * Read related records
     *
     * @param ResultSet $resultSet
     * @param array $relations related models
     * @return \Phalcon\Mvc\ModelInterface
     */
    public function readRelatedRecords(Resultset $resultSet, array $relations = [])
    {
        foreach($relations as $rel => $credentials) {

            if(is_null($resultSet->getFirst()->$rel) === true) {

                $key = key(current($credentials['rule']));

                $find = $this->getDi()->get(key($credentials['rule']))
                    ->getInstance()->find([
                        current($credentials['rule'])[$key]." = ?0",
                        "bind" => [$resultSet->getFirst()->$key],
                    ]);
                $resultSet->getFirst()->$rel = $find->toArray();
            }
        }

        return $resultSet;
    }

    /**
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @return mixed
     */
    public function read(array $credentials = [], array $relations = []) {

        $result = $this->getInstance()->find($credentials);

        if(empty($relations) === false) {
            $result = $this->readRelatedRecords($result, $relations);
        }

        if($result->count() > 0) {
            return $result;
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
    /**
     * Edit record
     *
     * @param \Phalcon\Mvc\Model $model
     * @param array $credentials
     * @return boolean
     * @throws BadRequestException
     */
    public function update(\Phalcon\Mvc\Model $model, array $credentials, array $skip = []) {

        if(empty($skip) === false) {
            $model->skipAttributes($skip);
        }

        $result = $model->update($credentials);

        if($result === false) {

            foreach($model->getMessages() as $message) {
                if($message->getType() == 'PresenceOf') {
                    throw new BadRequestException([
                        'FIELD_IS_REQUIRED' => $message->getMessage()
                    ]);
                }
            }
        }

        return true;
    }

    /**
     * Get instance of polymorphic Model
     *
     * @return \Phalcon\Mvc\Model
     */
    abstract public function getInstance();
}