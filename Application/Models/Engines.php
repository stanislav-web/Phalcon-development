<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class Engines `engines`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Engines.php
 */
class Engines extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     * @const
     */
    const TABLE = '\Application\Models\Engines';

    /**
     *
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $host;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $logo;

    /**
     * @var integer
     */
    public $currency_id;

    /**
     * Datetime create
     *
     * @var datetime
     */
    public $date_create;

    /**
     * Timestamp add
     *
     * @var timestamp
     */
    public $date_update;

    /**
     * @var Categories
     */
    public $categories;

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

        // skip attributes before every IN >
        $this->skipAttributesOnCreate(['date_update']);
        $this->skipAttributesOnUpdate(['date_create', 'date_update']);

        $this->belongsTo('currency_id', Currency::TABLE, 'id');

        // local_filed, reference Model, referenced_field
        $this->hasMany('id', Banners::TABLE, 'engine_id');

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'date_create',
                'format' => 'Y-m-d H:i:s'
            )
        )));
    }

    /**
     * Get currency related records
     *
     * @return \Application\Models\Currency
     */
    public function getCurrency($parameters=null)
    {
        return $this->getRelated(Currency::TABLE, $parameters);
    }

    /**
     * Get banners related records
     *
     * @return \Application\Models\Banners
     */
    public function getBanners($parameters=null)
    {
        return $this->getRelated(Banners::TABLE, $parameters);
    }

    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        //Do the validations
        $this->validate(new Uniqueness([
            "field"     => "host",
            "message"   => 'This host already exist in list'
        ]));

        $this->validate(new Uniqueness([
            "field"     => "code",
            "message"   => 'This code already exist in list'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'name',
            'message'   => 'The engine name is required'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'host',
            'message'   => 'The engine host is required'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'code',
            'message'   => 'The engine code is required'
        ]));

        $this->validate(new StringLength([
            'field'     => 'description',
            'max'       => 512,
            'min'       => 15,
            'messageMaximum' => 'Description must have maximum 512 characters',
            'messageMinimum' => 'Description must have minimum 15 characters'
        ]));

        return $this->validationHasFailed() != true;
    }

    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        //Do the validations

        $this->validate(new PresenceOf([
            'field'     => 'name',
            'message'   => 'The engine name is required'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'host',
            'message'   => 'The engine host is required'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'code',
            'message'   => 'The engine code is required'
        ]));

        $this->validate(new StringLength([
            'field'     => 'description',
            'max'       => 512,
            'min'       => 15,
            'messageMaximum' => 'Description must have maximum 512 characters',
            'messageMinimum' => 'Description must have minimum 15 characters'
        ]));

        return $this->validationHasFailed() != true;
    }
}
