<?php
namespace Application\Models;




/**
 * Class ItemAttributes `item_attributes`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/ItemAttributes.php
 */
class ItemAttributes extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\ItemAttributes';

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $translate;

    /**
     *
     * @var integer
     */
    public $integer;

    /**
     *
     * @var string
     */
    public $decimal;

    /**
     *
     * @var integer
     */
    public $varchar;

    /**
     *
     * @var string
     */
    public $date;

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
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup(['notNullValidations' => false]);

        // local_filed, reference Model, referenced_field
        $this->hasMany('id', ItemAttributeValues::TABLE, 'item_attribute_id');
    }
}
