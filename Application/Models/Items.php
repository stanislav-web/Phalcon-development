<?php
namespace Application\Models;

/**
 * Class Items `items`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Items.php
 */
class Items extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\Items';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $images;

    /**
     * @var string
     */
    public $previews;

    /**
     * @var boolean
     */
    public $is_published;

    /**
     * @var boolean
     */
    public $is_moderated;

    /**
     * @var integer
     */
    public $in_storage;

    /**
     * @var integer
     */
    public $user_id;

    /**
     * @var datetime
     */
    public $date_create;

    /**
     * @var timestamp
     */
    public $date_update;

    /**
     * @var datetime
     */
    public $date_removal;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        // its allow to keep empty data to my db
        $this->setup(['notNullValidations' => false]);
    }
}
