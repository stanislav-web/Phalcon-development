<?php
namespace Application\Aware;

use Application\Modules\Rest\Exceptions\BadRequestException;
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

            if(isset($resultSet->getFirst()->$rel) === false) {

                $conditions = $this->prepareRelatedConditions($resultSet, $credentials);
                $find = $this->getDi()->get(key($credentials['rule']))->getInstance()->find($conditions);

                if($find->count() > 0) {
                    $resultSet->getFirst()->$rel = $find->toArray();
                }
                else {
                    throw new NotFoundException([
                        'RECORDS_NOT_FOUND'  =>  'The records not found'
                    ]);
                }
            }
            else {
                throw new NotFoundException([
                    'RECORDS_NOT_FOUND'  =>  'The records not found'
                ]);
            }
        }
        return $resultSet;
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
     * Prepare related query conditions
     *
     * @param Resultset $resultSet
     * @param array $credentials
     * @return array
     */
    private function prepareRelatedConditions(Resultset $resultSet, array $credentials) {

        $rules  = $credentials['rule'];
        $mapper = key($rules);
        $modelKey = array_keys($rules[$mapper])[0];
        $relKey = current($rules[$mapper]);
        unset($credentials['rule']);

        if(empty($credentials) === true) {

            $conditions = [
                $relKey .' = '.(int)$resultSet->getFirst()->$modelKey
            ];
        }
        else {
            $conditions = [
                $relKey .' = '.(int)$resultSet->getFirst()->$modelKey. ' AND '
                .$modelKey. ' = '.(int)current($credentials)
            ];
        }

        return $conditions;
    }

    /**
     * Get instance of polymorphic Model
     *
     * @return \Phalcon\Mvc\Model
     */
    abstract public function getInstance();

    /**
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @return mixed
     */
    abstract public function read();
}