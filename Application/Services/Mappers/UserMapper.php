<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Users;
use Application\Models\UserRoles;
use Application\Models\UserAccess;
use Application\Modules\Rest\DTO\UserDTO;
use Application\Modules\Rest\Exceptions\BadRequestException;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class UserMapper. Actions above users
 *
 * @TODO Need to be refactored
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
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
     * Get File mapper
     *
     * @return \Application\Services\Mappers\FileMapper
     */
    protected function getFileMapper() {

        if($this->getDi()->has('FileMapper') === true) {
            return $this->getDi()->get('FileMapper');
        }

        return null;
    }

    /**
     * Get ImageService
     *
     * @param string imagepath
     * @return \Application\Services\Advanced\ImageService
     */
    public function getImageService($imagepath) {
        return $this->getDI()->get('ImageService', [$imagepath]);
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
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }

    /**
     * Update user by credentials
     *
     * @param \Phalcon\Mvc\Model $model
     * @param array              $credentials
     *
     * @throws \Application\Modules\Rest\Exceptions\BadRequestException
     * @throws \Application\Modules\Rest\Exceptions\ConflictException
     *
     * @return boolean
     */
    public function update(\Phalcon\Mvc\Model $model = null, array $credentials) {

        if($model === null) {
            $model = $this->getOne(['id' => (int)$credentials['id']]);
        }
        return parent::update($model, $credentials);
    }

    /**
     * Set user access token
     *
     * @param int $user_id Auth user ID
     * @param string $token Generated token
     * @param string $expire_date Token date expiry
     *
     * @throws \Application\Modules\Rest\Exceptions\BadRequestException
     *
     * @return \Application\Models\UserAccess $userAccess
     */
    public function setAccessToken($user_id, $token, $expire_date) {
        $userAccess = new UserAccess();
        $userAccess->user_id        = $user_id;
        $userAccess->token          = $token;
        $userAccess->expire_date    = $this->setSqlDatetime($expire_date);

        if($userAccess->save() === false) {
            foreach($userAccess->getMessages() as $message) {
                throw new BadRequestException($message->getMessage());
            }
        }

        return $userAccess;
    }

    /**
     * Refresh coming user
     *
     * @param int $user_id
     * @param array $data
     */
    public function refresh($user_id, array $data) {

        $user = $this->getOne(['id' => $user_id]);

        parent::update($user, [
            'ua' => $data['ua'],
            'ip' => ip2long($data['ip']),
            'date_lastvisit' => $this->setSqlDatetime(time())
        ]);
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

    /**
     * Upload user photos
     *
     * @param array $params
     * @return array
     */
    public function upload(array $params) {

        // get user id
        $userId = (isset($params[$this->getPrimaryKey()])) ? $params[$this->getPrimaryKey()] : null;

        if(isset($userId) === false) {
            throw new BadRequestException([
                'USER_KEY_IS_NOT_EXIST'  =>  $this->getTranslator()->translate('USER_KEY_IS_NOT_EXIST')
            ]);
        }

        // configure uploaded file params & upload file
        $uploader = $this->getFileMapper()->configure('profile', $userId)->upload();

        var_dump($uploader->getInfo()); exit;

//        if($uploader->isValid() === true) {
//
//            // move uploaded image
//            $uploader->move();
//            $filePath = $directory.DIRECTORY_SEPARATOR.$uploader->getInfo()[0]['filename'];
//            // resize uploaded image
//            $this->getImageService($filePath)->resizeSmall();
//
//            $model = $this->getInstance();
//            $isUpdated = $model->getReadConnection()->update($model->getSource(), ['photo'], [
//                $filePath
//            ], $this->getPrimaryKey()." = ".(int)$primary);
//
//            if($isUpdated === true) {
//
//                return (new UserDTO())->setNull();
//            }
//            else {
//                $uploader->truncate();
//                throw new InternalServerErrorException([
//                    'UPDATE_PROFILE_PHOTO_FAILED' => 'Can not update profile photo'
//                ]);
//            }
//        }

    }
}