<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class UserDTO. Data Transfer Object for users relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/UserDTO.php
 */
class UserDTO extends AbstractDTO
{

    /**
     * Null array
     *
     * @var array $null
     */
    public $null = [];

    /**
     * Files collection
     *
     * @var array $files
     */
    public $files = [];

    /**
     * Users collection
     *
     * @var array $users
     */
    public $users = [];

    /**
     * User auth access collection
     *
     * @var array $access
     */
    public $access = [];


    /**
     * User roles collection
     *
     * @var array $roles
     */
    public $roles = [];

    /**
     * Setup users
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $users
     * @return \Application\Modules\Rest\DTO\UserDTO
     */
    public function setUsers(\Phalcon\Mvc\Model\Resultset\Simple $users) {

        $this->users = $users->toArray();

        foreach($this->users as &$user) {
            $user['photo'] = (empty($user['photo']) === false) ? json_decode($user['photo'], true) : "";
        }

        $this->users['total'] = $this->total($users);
        $this->users['limit'] = $this->limit($users);
        $this->users['offset'] = $this->offset();

        return $this;
    }

    /**
     * Setup user access
     *
     * @param \Phalcon\Mvc\ModelInterface $access
     * @return \Application\Modules\Rest\DTO\UserDTO
     */
    public function setAccess(\Phalcon\Mvc\ModelInterface $access) {

        $this->access = $access->toArray();
        $this->access['total'] = $this->total($access);
        $this->access['limit'] = $this->limit($access);
        $this->access['offset'] = $this->offset();

        return $this;
    }

    /**
     * Setup null
     *
     * @return \Application\Modules\Rest\DTO\UserDTO
     */
    public function setNull() {

        $this->null = [];

        return $this;
    }

    /**
     * Setup files
     *
     * @return \Application\Modules\Rest\DTO\UserDTO
     */
    public function setFiles(array $files) {

        $this->files[] = $files;

        return $this;
    }

    /**
     * Setup roles
     *
     * @param \Phalcon\Mvc\ModelInterface $roles
     * @return \Application\Modules\Rest\DTO\UserDTO
     */
    public function setRoles(\Phalcon\Mvc\ModelInterface $roles) {

        $this->roles = $roles->toArray();

        return $this;
    }

    /**
     * Reverse object to real array for all public properties
     *
     * @param object $object
     * @return mixed
     */
    public function toArray() {
        return  get_object_vars($this);
    }

}
