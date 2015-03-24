<?php
namespace Application\Services\Mappers;

use \Phalcon\DI\InjectionAwareInterface;
use Phalcon\Db\Exception as DbException;
use Application\Aware\ModelCrudInterface;
use Application\Models\Pages;

/**
 * Class PageMapper. Actions above application pages
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/PageMapper.php
 */
class PageMapper implements InjectionAwareInterface, ModelCrudInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Errors array
     *
     * @var array $errors;
     */
    private $errors = [];

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
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get instance of polymorphic object
     *
     * @return Pages
     */
    public function getInstance() {
        return new Pages();
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
     * Add page
     *
     * @param array $data
     */
    public function create(array $data) {

        $pageModel = new Pages();

        foreach($data as $field => $value) {

            $pageModel->{$field}   =   $value;
        }

        if($pageModel->save() === true) {

            return true;
        }
        else {

            $this->setErrors($pageModel->getMessages());
            return false;
        }
    }

    /**
     * Read pages
     *
     * @param int $id get by id
     * @param array $data conditions
     * @param int $limit conditions
     * @return mixed
     */
    public function read($id = null, array $data = [], $limit = null) {

        $result = (empty($id) === true)
            ? (is_null($limit) === true ? $this->getList($data)
                : $this->getOne(null, $data))
        :  $this->getOne($id);

        return $result;
    }

    /**
     * Edit page
     *
     * @param int      $id
     * @param array $data
     * @throws DbException
     */
    public function update($id, array $data) {

        $pageModel = new Pages();

        $pageModel->setId($id);

        foreach($data as $field => $value) {

            $pageModel->{$field}   =   $value;
        }

        if($pageModel->save() === true) {

            return true;
        }
        else {
            $this->setErrors($pageModel->getMessages());

            return false;
        }
    }

    /**
     * Delete page
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

        $pageModel = new Pages();

        return $pageModel->getReadConnection()
            ->delete($pageModel->getSource(), "id = ".(int)$id);
    }

    /**
     * Set errors message
     *
     * @param mixed $errors
     */
    public function setErrors($errors) {
        $this->errors = $errors;
    }

    /**
     * Get error messages
     *
     * @return mixed $errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get page by Id
     *
     * @param int $id
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getOne($id = null, array $params = [])
    {
        return (is_null($id) === false)
            ? Pages::findFirst($id)
            : Pages::findFirst($params);
    }

    /**
     * Get pages by condition
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getList(array $params = [])
    {
        return Pages::find($params);
    }
}