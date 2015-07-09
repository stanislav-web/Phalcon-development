<?php
namespace Application\Models;

/**
 * Class UserRoles `user_roles`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/UserRoles.php
 */
class UserRoles extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\UserRoles';

    /**
     * @const Role just USER
     */
    const USER  = 0;

    /**
     * @const Role have full admin
     */
    const ADMIN = 1;

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $role;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup(['notNullValidations' => false]);
    }
}
