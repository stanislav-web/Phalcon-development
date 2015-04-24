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
     * @var array
     */
    public $users = [];

    /**
     * Currencies collection
     *
     * @var array
     */
    public $access = [];

    /**
     * Setup users
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $users
     * @return $this
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
     * Reverse object to an array
     *
     * @return array
     */
    public function asRealArray($obj) {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? $this->asRealArray($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
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
