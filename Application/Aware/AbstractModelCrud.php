<?php
namespace Application\Aware;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\ConflictException;
use Application\Modules\Rest\Exceptions\ForbiddenException;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Phalcon\DI\InjectionAwareInterface;

/**
 * AbstractModelCrud. Implementing rules necessary intended for service's models
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.6
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/AbstractModelCrud.php
 */
abstract class AbstractModelCrud implements InjectionAwareInterface {

    /**
     * Allowed additional params
     *
     * @const BASE_PARAMS
     */
    const BASE_PARAMS = ['offset', 'limit'];

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
    public function setDi(\Phalcon\DiInterface $di)
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
     * Get model primary key
     *
     * @return array
     */
    public function getPrimaryKey()
    {
        $metaData = $this->getInstance()->getModelsMetaData();
        return $metaData->getPrimaryKeyAttributes($this->getInstance())[0];
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
     * Filter request models params by allowed
     *
     * @param $params
     *
     * @return array
     */
    protected function filterParams($params) {
        return array_intersect_key($params, array_flip(self::BASE_PARAMS));
    }

    /**
     * Get Translate service
     *
     * @return \Translate\Translator|null
     */
    protected function getTranslator() {

        if($this->getDi()->has('TranslateService') === true) {
            return $this->getDi()->get('TranslateService')->assign('errors');
        }

        return null;
    }

    /**
     * Create record row
     *
     * @param array $data
     * @throws \Application\Modules\Rest\Exceptions\BadRequestException
     * @throws \Application\Modules\Rest\Exceptions\ConflictException
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
                throw new ConflictException(json_decode($message->getMessage(), true));
            }

            throw new BadRequestException(json_decode($message->getMessage(), true));
        }
    }

    /**
     * Edit record
     *
     * @param \Phalcon\Mvc\Model $model
     * @param array $credentials
     * @throws BadRequestException
     * @return boolean
     */
    protected function update(\Phalcon\Mvc\Model $model, array $credentials) {

        if($model->update($credentials, array_keys($credentials))) {
            return true;
        }

        foreach($model->getMessages() as $message) {

            if($message->getType() == 'Unique') {
                throw new ConflictException(json_decode($message->getMessage(), true));
            }

            throw new BadRequestException(json_decode($message->getMessage(), true));
        }
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
     * Get related records
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     * @throws \Application\Modules\Rest\Exceptions\NotFoundException
     */
    protected function getRelated(array $params) {

        // get relation mapper
        $mapper = $this->getDi()->get($params['mapper']);

        $conditional = implode(' AND ', array_map(function ($v, $k) {
            return (is_array($v) === false) ? $k . '=' . $v : $k.' IN ('.implode(',', $v).')';
        }, $params['rel'], array_keys($params['rel'])));

        // setup properties
        $prop = [];
        if(isset($params['order'])) $prop['order'] = $params['order'];
        if(isset($params['limit'])) $prop['limit'] = $params['limit'];
        if(isset($params['offset'])) $prop['offset'] = $params['offset'];

        $find = $mapper->getInstance()->find(array_merge([$conditional], $prop));

        if($find->count() > 0) {
            return $find;
        }

        throw new NotFoundException([
            'RELATED_RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RELATED_RECORDS_NOT_FOUND')
        ]);
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