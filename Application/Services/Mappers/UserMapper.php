<?php
namespace Application\Services\Mappers;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Aware\ModelCrudInterface;
use Application\Models\Users;
use Application\Models\UserRoles;
use Application\Models\UserAccess;

/**
 * Class UserMapper. Actions above users
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/UserMapper.php
 */
class UserMapper implements InjectionAwareInterface, ModelCrudInterface {

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
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Create user
     *
     * @param array $data
     * return boolean
     */
    public function create(array $data) {

    }

    /**
     * Read user
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function read($id = null, array $data = []) {

    }

    /**
     * Edit user
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, array $data) {

    }

    /**
     * Delete user
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

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
     * Get user by Id
     *
     * @param int $id
     * @return \Phalcon\Mvc\Model
     */
    public function getOne($id)
    {
    }

    /**
     * Get users by condition
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getList(array $params = [])
    {
    }
}