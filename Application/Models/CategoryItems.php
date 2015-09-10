<?php
namespace Application\Models;

/**
 * Class CategoryItems `category_items`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/CategoryItems.php
*/
class CategoryItems extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\CategoryItems';

    /**
     *
     * @var integer
     */
    public $category_id;

    /**
     *
     * @var integer
     */
    public $item_id;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup(['notNullValidations' => false]);

        // keep relations with `categories` & `items`
        $this->belongsTo('category_id', Categories::TABLE, 'id');
        $this->belongsTo('item_id', Items::TABLE, 'id');
    }
}
