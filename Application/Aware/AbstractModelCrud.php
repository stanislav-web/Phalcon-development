<?php
namespace Application\Aware;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\ConflictException;
use Phalcon\DI\InjectionAwareInterface;

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
     * Create record row
     *
     * @param array $data
     * @throws BadRequestException
     * @throws ConflictException
     *
     * @return \Phalcon\Mvc\Model
     */
    public function create(array $data) {

        $model = $this->getInstance();

        foreach($data as $field => $value) {
            $model->{$field}   =   $value;
        }
        if($model->save() === true) {
            return $model;
        }

        foreach($model->getMessages() as $message) {
            if($message->getType() == 'Unique') {
                throw new ConflictException($message->getMessage());
            }

            throw new BadRequestException($message->getMessage());
        }
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
     * Method to set the value of field datetime
     *
     * @param string $expire_date
     * @return string
     */
    public function setSqlDatetime($expire_date)
    {
        $datetime = new \Datetime();

        $datetime->setTimestamp($expire_date);
        $datetime->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $datetime->format('Y-m-d H:i:s');
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