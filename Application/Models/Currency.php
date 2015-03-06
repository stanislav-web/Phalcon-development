<?php
namespace Application\Models;

/**
 * Class Currency `currency`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Currency.php
 */
class Currency extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     * @const
     */
    const TABLE = '\Application\Models\Currency';

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    public $code;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $symbol;

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

        // local_filed, reference Model, referenced_field
        $this->hasMany('id', Engines::TABLE, 'currency_id');
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
     * Returns the value of field code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Method to set the value of field code
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the value of field symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Method to set the value of field symbol
     *
     * @param string $symbol
     * @return $this
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }
}
