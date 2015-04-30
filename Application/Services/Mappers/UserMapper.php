<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Users;
use Application\Models\UserRoles;
use Application\Models\UserAccess;
use Application\Modules\Rest\DTO\UserDTO;
use Application\Modules\Rest\Exceptions\BadRequestException;

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
class UserMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Users
     */
    public function getInstance() {
        return new Users();
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
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @return mixed
     */
    public function read(array $credentials = [], array $relations = []) {

        $result = $this->getInstance()->find($credentials);

        if($result->count() > 0) {
            return (new UserDTO())->setUsers($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
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
        $userAccess->user_id        = $user_id;
        $userAccess->token          = $token;
        $userAccess->expire_date    = $this->setSqlDatetime($expire_date);
        $userAccess->save();

        if($userAccess->save() === true) {

            return $userAccess;
        }
        foreach($userAccess->getMessages() as $message) {
            throw new BadRequestException($message->getMessage());
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

        $user->ua = $data['ua'];
        $user->ip = ip2long($data['ip']);
        $user->date_lastvisit = $this->setSqlDatetime(time());

        if($user->save() === true) {

            return true;
        }

        throw new BadRequestException($user->getMessages());
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
     * Delete access token by credential
     *
     * @param array $credential key => value
     * @return \Phalcon\Mvc\Model
     */
    public function deleteToken(array $credential)
    {
        $userAccess = new UserAccess();

        return $userAccess->findFirst($credential)->delete();
    }
}