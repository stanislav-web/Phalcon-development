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
     *
     * @const
     */
    const TABLE = '\Application\Models\Users';

    /**
     *
     * @var integer
     */
    public $id;

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
        // its allow to keep empty data to my db
        $this->setup([
            'notNullValidations' => false,
            'exceptionOnFailedSave' => false
        ]);

        // skip attributes before every IN >
        $this->skipAttributesOnCreate(['date_registration', 'date_lastvisit', 'state', 'rating', 'surname']);
        $this->skipAttributesOnUpdate(['date_registration']);
    }

    /**
     * Method to set the value of field datetime
     *
     * @param string $expire_date
     * @return string
     */
    public function setSqlDatetime($expire_date)
    {
        $datetime = new \Datetime();

        $datetime->setTimestamp($expire_date);
        $datetime->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * Before every update of model
     * @
     */
    public function beforeValidationOnUpdate() {

        $this->ip = (isset($this->ip) === true) ? $this->ip
            : ip2long($this->getDI()->getRequest()->getClientAddress());
        $this->ua = (isset($this->ua) === true) ? $this->ua
            : $this->getDI()->getRequest()->getUserAgent();

        $this->date_lastvisit = (isset($this->date_lastvisit) === true) ? $this->date_lastvisit
            : $this->setSqlDatetime(time());

        foreach(get_object_vars($this) as $prop => $value) {
            if(is_null($value) === true) {
                $this->skipAttributes([$prop]);
            }
        }
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
            "message"   => ['USER_EXIST' => 'This user is already registered']
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'login',
            'message'   => ['LOGIN_REQUIRED' => 'The login is required']
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'password',
            'message'   => ['PASSWORD_REQUIRED' => 'The password is required']
        ]));

        $this->validate(new StringLengthValidator([
            'field'     => 'login',
            'max'       => 30,
            'min'       => 3,
            'messageMaximum' => ['LOGIN_MAX_INVALID' => 'The login is too long'],
            'messageMinimum' => ['LOGIN_MIX_INVALID' => 'The login is too short']
        ]));

        $this->validate(new StringLengthValidator([
            'field'     => 'name',
            'max'       => 30,
            'min'       => 2,
            'messageMaximum' => ['NAME_MAX_INVALID' => 'The name is too long'],
            'messageMinimum' => ['NAME_MIN_INVALID' => 'The name is too short']
        ]));

        $this->validate(new RegexValidator([
            'field'     => 'login',
            'pattern'   => "/^((\+)|(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4,5}|([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+)$/",
            'message'   => ['LOGIN_FORMAT_INVALID' => 'The login should be your email or phone number']
        ]));

        return $this->validationHasFailed() != true;
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
