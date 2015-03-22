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
     * Get instance of polymorphic object
     *
     * @return Users
     */
    public function getInstance() {
        return new Users();
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
     * Create simple user
     *
     * @param array $data
     * @return Users|bool
     */
    public function createUser(array $data) {

        $userModel = new Users();
        $userModel->setRole(UserRoles::USER)
            ->setIp($this->getDi()->get('request')->getClientAddress())
            ->setUa($this->getDi()->get('request')->getUserAgent());

        foreach($data as $field => $value) {

            if($field === 'password') {
                $userModel->setPassword($value);
            }
            else {
                $userModel->{$field}   =   $value;
            }
        }

        if($userModel->save() === true) {

            return $userModel;
        }
        else {

            $this->setErrors($userModel->getMessages());
            return false;
        }
    }

    /**
     * Read user
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function read($id = null, array $data = []) {

        $result = (empty($id) === true) ? $this->getList() : $this->getOne($id);

        return $result;
    }

    /**
     * Edit user
     *
     * @param int $user_id
     * @param array $data
     */
    public function update($user_id, array $data) {

        $userModel = new Users();
        $userModel->setId($user_id);
        foreach($data as $field => $value) {

            $userModel->{$field}   =   $value;
        }

        if($userModel->update() === true) {

            return true;
        }
        else {
            $this->setErrors($userModel->getMessages());

            return false;
        }
    }

    /**
     * Refresh coming user
     *
     * @param int $user_id
     * @param array $data
     */
    public function refresh($user_id, array $data) {

        $user = $this->getOne(['id' => $user_id]);
        $user->skipAttributes(['surname']);
        $refresh = $user->setUa($data['ua'])->setIp($data['ip'])->setDateLastvisit();

        if($refresh->save() === true) {
            return true;
        }
        else {
            $this->setErrors($user->getMessages());
            return false;
        }


    }

    /**
     * Update user password
     *
     * @param int $user_id
     * @param string $password
     */
    public function updatePassword($user_id, $password) {

        $userModel = new Users();

        $update =  $userModel->getReadConnection()
            ->update($userModel->getSource(), ['password'], [
                $this->getDi()->getShared('security')->hash($password)
            ], "id = ".(int)$user_id);

        if($update === true) {
            return true;
        }
        else {
            $this->setErrors($userModel->getMessages());

            return false;
        }
    }

    /**
     * Delete user
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

        $userModel = new Users();

        return $userModel->getReadConnection()
            ->delete($userModel->getSource(), "id = ".(int)$id);
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
     * Get access model
     *
     * @return UserAccess
     */
    public function getAccess() {
        return new UserAccess();
    }

    /**
     * Get roles model
     *
     * @return UserRoles
     */
    public function getRoles() {
        return new UserRoles();
    }

    /**
     * Get user by credential
     *
     * @param array key=>value $credential
     * @return \Application\Models\Users $user
     */
    public function getOne(array $credential)
    {
        if(empty($credential) === false) {
            $user = (new Users())->findFirst([
                "".key($credential)." = ?0",
                "bind" => [$credential[key($credential)]],
            ]);

            return $user;
        }

        return false;
    }

    /**
     * Get users by condition
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getList(array $params = [])
    {
        return Users::find($params);
    }

    /**
     * Set user access token
     *
     * @param int $user_id Auth user ID
     * @param string $token Generated token
     * @param int $expire_date Token date expiry
     * @return UserAccess|bool
     */
    public function setAccessToken($user_id, $token, $expire_date)
    {
        $userAccess = new UserAccess();
        $userAccess->setUserId($user_id)->setToken($token)->setExpireDate($expire_date);

        if($userAccess->save() === true) {

            return $userAccess;
        }
        else {
            $this->setErrors($userAccess->getMessages());

            return false;
        }
    }

    /**
     *
     * Get access token by credential
     *
     * @param array $credential key => value
     * @return \Phalcon\Mvc\Model
     */
    public function getAccessTokenByCredential(array $credential)
    {
        $userAccess = new UserAccess();

        return $userAccess->findFirst([
            "".key($credential)." = ?0",
            "bind" => [$credential[key($credential)]],
        ]);
    }

    /**
     *
     * Remove access token by credential
     *
     * @param array $credential key => value
     * @return \Phalcon\Mvc\Model
     */
    public function deleteAccessTokenByCredential(array $credential)
    {
        $userAccess = new UserAccess();

        return $userAccess->findFirst([
            "".key($credential)." = ?0",
            "bind" => [$credential[key($credential)]],
        ])->delete();
    }
}