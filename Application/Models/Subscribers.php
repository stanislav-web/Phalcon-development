<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Class Subscribers `subscribers`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Subscribers.php
 */
class Subscribers extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\Subscribers';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var integer
     */
    public $status;

    /**
     * Datetime create
     * @var datetime
     */
    public $date_create;

    /**
     * Timestamp add
     * @var timestamp
     */
    public $date_update;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup([
            'notNullValidations' => false,
        ]);
    }

    /**
     * Get exists primary key
     *
     * @return int
     */
    public function getPrimary() {
        return $this->id;
    }

    /**
     * Validate
     *
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        $this->validate(new PresenceOf([
            'field'     => 'email',
            'message'   => ['EMAIL_REQUIRED' => 'The email is required']
        ]));

        $this->validate(new Email([
            "field"     => "email",
            "message"   => ['EMAIL_INVALID' => 'Invalid email address']
        ]));

        $this->validate(new Uniqueness([
            "field"     => "email",
            "message"   => ['EMAIL_EXIST' => 'This email is already in subscribers list']
        ]));

        return ($this->validationHasFailed() == true) ? false : true;
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
