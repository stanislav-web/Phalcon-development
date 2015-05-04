<?php
namespace Application\Models;

/**
 * Class UserAccess `user_access`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/UserAccess.php
 */
class UserAccess extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\UserAccess';

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $expire_date;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup([
            'notNullValidations' => true,
            'exceptionOnFailedSave' => false
        ]);
    }

}
