<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Regex as RegexValidator;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;

/**
 * Class Users `users`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Users.php
 */
class Users extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     * @const
     */
    const TABLE = '\Application\Models\Users';

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    public $login;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $surname;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $salt;

    /**
     *
     * @var int
     */
    public $role;

    /**
     *
     * @var string
     */
    public $state;

    /**
     *
     * @var double
     */
    public $rating;

    /**
     *
     * @var string
     */
    public $date_registration;

    /**
     *
     * @var string
     */
    public $date_lastvisit;

    /**
     *
     * @var integer
     */
    public $ip;

    /**
     *
     * @var string
     */
    public $ua;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        $this->belongsTo("id", UserAccess::TABLE, "user_id");

        // its allow to keep empty data to my db
        $this->setup([
            'notNullValidations' => true,
            'exceptionOnFailedSave' => false
        ]);

        // skip attributes before every IN >
        $this->skipAttributesOnCreate(['date_registration', 'date_lastvisit', 'state', 'rating', 'surname']);
        $this->skipAttributesOnUpdate(['date_registration']);
    }

    /**
     * Validate
     *
     * @return bool
     */
    public function beforeValidationOnCreate()
    {

        $this->validate(new Uniqueness([
            "field"     => "login",
            "message"   => 'USER_EXIST'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'login',
            'message'   => 'LOGIN_REQUIRED'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'password',
            'message'   => 'PASSWORD_REQUIRED'
        ]));

        $this->validate(new StringLengthValidator([
            'field'     => 'login',
            'max'       => 30,
            'min'       => 3,
            'messageMaximum' => 'LOGIN_MAX_INVALID',
            'messageMinimum' => 'LOGIN_MIN_INVALID'
        ]));

        $this->validate(new StringLengthValidator([
            'field'     => 'name',
            'max'       => 30,
            'min'       => 2,
            'messageMaximum' => 'NAME_MAX_INVALID',
            'messageMinimum' => 'NAME_MIN_INVALID'
        ]));

        $this->validate(new RegexValidator([
            'field'     => 'login',
            'pattern'   => "/^((\+)|(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4,5}|([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+)$/",
            'message'   => 'LOGIN_FORMAT_INVALID'
        ]));

        return $this->validationHasFailed() != true;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the value of field login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Method to set the value of field login
     *
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $login
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Method to set the value of field surname
     *
     * @param string $login
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $this->getDI()->getShared('security')->hash($password);

        return $this;
    }

    /**
     * Returns the value of field salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Method to set the value of field salt
     *
     * @param string $password
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Returns the value of field role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Method to set the value of field role
     *
     * @param string $role
     * @return Users
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Returns the value of field state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Method to set the value of field state
     *
     * @param string $state
     * @return Users
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Returns the value of field rating
     *
     * @return double
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Method to set the value of field rating
     *
     * @param double $rating
     * @return Users
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Returns the value of field date_registration
     *
     * @return string
     */
    public function getDateRegistration()
    {
        return $this->date_registration;
    }

    /**
     * Method to set the value of field date_registration
     *
     * @param string $date_registration
     * @return Users
     */
    public function setDateRegistration($date_registration)
    {
        $this->date_registration = $date_registration;

        return $this;
    }

    /**
     * Returns the value of field date_lastvisit
     *
     * @return string
     */
    public function getDateLastvisit()
    {
        return $this->date_lastvisit;
    }

    /**
     * Method to set the value of field date_lastvisit
     *
     * @param string $date_lastvisit
     * @return Users
     */
    public function setDateLastvisit($date_lastvisit = null)
    {
        if($date_lastvisit === null) {

            $datetime = new \Datetime('now', new \DateTimeZone(date_default_timezone_get()));

            $this->date_lastvisit = $datetime->format('Y-m-d H:i:s');

        }
        else {
            $this->date_lastvisit  =   $date_lastvisit;
        }

        return $this;
    }

    /**
     * Returns the value of field ip
     *
     * @return integer
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Method to set the value of field ip
     *
     * @param int $ip
     * @return Users
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);

        return $this;
    }

    /**
     * Returns the value of field ua
     *
     * @return string
     */
    public function getUa()
    {
        return $this->ua;
    }

    /**
     * Method to set the value of field ua
     *
     * @param string $ua
     * @return Users
     */
    public function setUa($ua)
    {
        $this->ua = $ua;

        return $this;
    }

    /**
     * Skip attributes before update
     *
     * @param array $attributes
     * @param null  $replace
     */
    public function skipAttributes($attributes, $replace = null) {
        parent::skipAttributes($attributes, $replace);
    }
}
