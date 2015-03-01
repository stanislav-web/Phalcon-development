<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Validator\PresenceOf;

/**
 * Class EnginesCategoriesRel `engines_categories_rel`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/EnginesCategoriesRel.php
 */
class EnginesCategoriesRel extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     * @const
     */
    const TABLE = '\Application\Models\EnginesCategoriesRel';

    /**
     * @var integer
     */
    public $engine_id;

    /**
     * @var string
     */
    public $category_id;

    /**
     * Initialize Model
     */
    public function initialize()
    {
        $this->belongsTo('engine_id', Engines::TABLE, 'id',
            array('alias' => 'engine')
        );
        $this->belongsTo('category_id', Categories::TABLE, 'id',
            array('alias' => 'category')
        );
    }

    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        //Do the validations

        $this->validate(new PresenceOf([
            'field'     => 'category_id',
            'message'   => 'The CategoryId is required'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'engine_id',
            'message'   => 'The CategoryId is required'
        ]));

        return $this->validationHasFailed() != true;
    }

    /**
     * Returns the value of field engine_id
     *
     * @return integer
     */
    public function getEngineId()
    {
        return $this->engine_id;
    }

    /**
     * Method to set the value of field engine_id
     *
     * @param integer $id
     * @return $this
     */
    public function setEngineId($engine_id)
    {
        $this->engine_id = $engine_id;

        return $this;
    }

    /**
     * Returns the value of field category_id
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Method to set the value of field category_id
     *
     * @param integer $id
     * @return $this
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
}
