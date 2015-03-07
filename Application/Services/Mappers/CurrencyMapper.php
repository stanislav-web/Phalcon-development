<?php
namespace Application\Services\Mappers;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Aware\ModelCrudInterface;
use Application\Models\Currency;

/**
 * Class CurrencyMapper. Actions above application engine
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/CurrencyMapper.php
 */
class CurrencyMapper implements InjectionAwareInterface, ModelCrudInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

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
     * Create currency
     *
     * @param array $data
     * return boolean
     */
    public function create(array $data) {

        $currencyModel = new Currency();

        foreach($data as $field => $value) {

            $currencyModel->{$field}   =   $value;
        }

        if($currencyModel->save() === true) {

            return true;
        }
        else {

            $this->setErrors($currencyModel->getMessages());
            return false;
        }
    }

    /**
     * Read currency
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function read($id = null, array $data = []) {

        $result = (empty($id) === true) ? $this->getList($data) : $this->getOne($id);

        return $result;
    }

    /**
     * Edit currency
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, array $data) {

        $currencyModel = new Currency();

        $currencyModel->setId($id);

        foreach($data as $field => $value) {

            $currencyModel->{$field}   =   $value;
        }

        if($currencyModel->save() === true) {

            return true;
        }
        else {
            $this->setErrors($currencyModel->getMessages());

            return false;
        }
    }

    /**
     * Delete currency
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

        $currencyModel = new Currency();

        return $currencyModel->getReadConnection()
            ->delete($currencyModel->getSource(), "id = ".(int)$id);
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
     * Get currency by Id
     *
     * @param int $id
     * @return \Phalcon\Mvc\Model
     */
    public function getOne($id)
    {
        return Currency::findFirst($id);
    }

    /**
     * Get currencies by condition
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getList(array $params = [])
    {
        return Currency::find($params);
    }
}