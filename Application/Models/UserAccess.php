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
     * @const
     */
    const TABLE = '\Application\Models\UserAccess';

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $expire_date;

    public function initialize()
    {
        $this->hasOne('user_id', Users::TABLE, 'id');
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * Method to set the value of field expire_date
     *
     * @param string $expire_date
     * @return $this
     */
    public function setExpireDate($expire_date)
    {
        $datetime = new \Datetime();

        $datetime->setTimestamp($expire_date);
        $datetime->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        $this->expire_date = $datetime->format('Y-m-d H:i:s');

        return $this;
    }
}
