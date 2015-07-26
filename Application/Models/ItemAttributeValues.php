<?php
namespace Application\Models;

/**
 * Class ItemAttributeValues `item_attribute_values`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/ItemAttributeValues.php
 */
class ItemAttributeValues extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\ItemAttributeValues';

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $item_attribute_id;

    /**
     *
     * @var integer
     */
    public $item_id;

    /**
     *
     * @var integer
     */
    public $value;

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

        $this->belongsTo('item_attribute_id', ItemAttributes::TABLE, 'id', [
            'alias' => 'attributeNames'
        ]);
    }
}
