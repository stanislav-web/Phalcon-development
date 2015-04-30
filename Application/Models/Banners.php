<?php
namespace Application\Models;

/**
 * Class Banners `banners`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Banners.php
 */
class Banners extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     * @const
     */
    const TABLE = '\Application\Models\Banners';

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $engine_id;

    /**
     *
     * @var string
     */
    public $image;

    /**
     *
     * @var string
     */
    public $link;

    /**
     *
     * @var string
     */
    public $delay;

    /**
     *
     * @var string
     */
    public $description;


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

        $this->belongsTo('engine_id', Engines::TABLE, 'id');
    }
}
