<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;

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
     * Engine statuses
     *
     * @var array $statuses
     */
    public static $statuses = [
        0 => 'Off',
        1 => 'On',
        2 => 'Pending'
    ];

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $logo;

    /**
     * @var integer
     */
    protected $currency_id;

    /**
     * @var integer
     */
    protected $status;

    /**
     * Datetime create
     *
     * @var datetime
     */
    protected $date_create;

    /**
     * Timestamp add
     *
     * @var timestamp
     */
    protected $date_update;

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

        $this->belongsTo('currency_id', Currency::TABLE, 'id', [
            'alias' => 'currencyRel',
        ]);

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'date_create',
                'format' => 'Y-m-d H:i:s'
            )
        )));

        // create relations between Engines => EnginesCategoriesRel

        $this->hasManyToMany("id", EnginesCategoriesRel::TABLE, "engine_id", "category_id", Categories::TABLE, "id",
            ['alias' => 'categories']
        );
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

        return $this->validationHasFailed() != true;
    }

    /**
     * Method to set the value of field date_create
     *
     * @param integer $status
     * @return Engines
     */
    public function setDateCreate($date_create = null)
    {
        if($date_create === null) {

            $datetime = new \Datetime(new \DateTimeZone(date_default_timezone_get()));

            $this->date_create = $datetime->format('Y-m-d H:i:s');

        }
        else {
            $this->date_create  =   $date_create;
        }

        return $this;
    }

    /**
     * Method to set the value of field host
     *
     * @param string $host
     * @return Engines
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return Engines
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return Engines
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field code
     *
     * @param string $code
     * @return Engines
     */
    public function setCode($code)
    {
        $this->code = strtoupper($code);

        return $this;
    }

    /**
     * Method to set the value of field logo
     *
     * @param string $logo
     * @return Engines
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Method to set the value of field currency_id
     *
     * @param integer $currency_id
     * @return Engines
     */
    public function setCurrencyId($currency_id)
    {
        $this->currency_id = (int)$currency_id;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return Engines
     */
    public function setStatus($status)
    {
        $this->status = (int)$status;

        return $this;
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
     * @return Engines
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * Returns the value of field host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
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
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the value of field logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Returns the value of field currency_id
     *
     * @return integer
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field date_create
     *
     * @return integer
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * Returns the value of field date_create
     *
     * @return integer
     */
    public function getDateUpdate()
    {
        return $this->date_update;
    }

    /**
     * Get all related records from Engines joined to Currency
     * @param array $params
     * @return
     */
    public function get(array $params = [])
    {
        $builder = $this->_modelsManager->createBuilder();
        $builder
            ->addFrom(self::TABLE, 'e')
            ->leftJoin(Currency::TABLE, 'c.id = e.currency_id', 'c');

        $result = $builder->getQuery()->execute();

        return $result;
    }
}
