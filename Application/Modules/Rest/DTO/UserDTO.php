<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class UserDTO. Data Transfer Object for users relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/UserDTO.php
 */
class UserDTO extends AbstractDTO
{

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
        $this->users['total'] = $this->total($users);
        $this->users['limit'] = $this->limit($users);
        $this->users['offset'] = $this->offset();

        return $this;
    }

    /**
     * Setup access
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $access
     * @return $this
     */
    public function setAccess(\Phalcon\Mvc\Model\Resultset\Simple $access) {

        $this->access = $access->toArray();
        $this->access['total'] = $this->total($access);
        $this->access['limit'] = $this->limit($access);
        $this->access['offset'] = $this->offset();

        return $this;
    }

    /**
     * Setup roles
     *
     * @param \Application\Models\UserRoles $roles
     * @return $this
     */
    public function setRoles(\Application\Models\UserRoles $roles) {

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
