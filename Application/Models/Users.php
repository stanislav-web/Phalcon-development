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
    protected $login;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $surname;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var string
     */
    protected $salt;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @var int
     */
    protected $role;

    /**
     *
     * @var string
     */
    protected $state;

    /**
     *
     * @var double
     */
    protected $rating;

    /**
     *
     * @var string
     */
    protected $date_registration;

    /**
     *
     * @var string
     */
    protected $date_lastvisit;

    /**
     *
     * @var integer
     */
    protected $ip;

    /**
     *
     * @var string
     */
    protected $ua;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup([
            'notNullValidations' => false,
            'exceptionOnFailedSave' => false
        ]);

        // skip attributes before every IN >
        $this->skipAttributesOnCreate(['date_registration', 'date_lastvisit', 'state', 'rating', 'surname']);
        $this->skipAttributesOnUpdate(['date_lastvisit']);
    }


    /**
     * Validate that login are unique across users
     *
     * @return bool
     */
    public function validation()
    {

        // get translate service
        $t  =   $this->getDI()->getShared('TranslateService')->assign('sign');

        $this->validate(new Uniqueness([
            "field"     => "login",
            "message"   => $t->translate('USER_EXIST')
        ]));
        $this->validate(new Uniqueness([
            "field"     => "token",
            "message"   => $t->translate('INVALID_TOKEN')
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'login',
            'message'   => $t->translate('LOGIN_REQUIRED')
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'password',
            'message'   => $t->translate('PASSWORD_REQUIRED')
        ]));

        $this->validate(new StringLengthValidator([
            'field'     => 'login',
            'max'       => 30,
            'min'       => 3,
            'messageMaximum' => $t->translate('LOGIN_MAX_INVALID'),
            'messageMinimum' => $t->translate('LOGIN_MIN_INVALID')
        ]));

        $this->validate(new StringLengthValidator([
            'field'     => 'name',
            'max'       => 30,
            'min'       => 2,
            'messageMaximum' => $t->translate('NAME_MAX_INVALID'),
            'messageMinimum' => $t->translate('NAME_MIN_INVALID')
        ]));

        $this->validate(new RegexValidator([
            'field'     => 'login',
            'pattern'   => "/^((\+)|(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4,5}|([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+)$/",
            'message'   => $t->translate('LOGIN_FORMAT_INVALID')
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
        $this->password = $password;

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
     * Returns the value of field token
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
     * Returns the value of field role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Method to set the value of field token
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
    public function setDateLastvisit($date_lastvisit)
    {
        $this->date_lastvisit = $date_lastvisit;

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
}
