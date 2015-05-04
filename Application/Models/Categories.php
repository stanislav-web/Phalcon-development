<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Phalcon\Tag;

/**
 * Class Categories `categories`
 *
 * @package    Application
 * @subpackage    Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Models/Categories.php
 */
class Categories extends \Phalcon\Mvc\Model
{
    /**
     * Absolute model name
     *
     * @const
     */
    const TABLE = '\Application\Models\Categories';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $translate;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var integer
     */
    public $parent_id;

    /**
     * @var integer
     */
    public $sort;

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
            'notNullValidations' => true,
            'exceptionOnFailedSave' => false
        ]);

        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(['date_create', 'date_update']);
    }

    /**
     * This action run after save anything to this model
     *
     * @return null
     */
    public function afterSave()
    {
        $this->rebuildTree();
    }

    /**
     * Calling rebuild categories tree function
     *
     * @throws \Phalcon\Mvc\Model\Exception
     * @return Resultset
     */
    public function rebuildTree()
    {
        $sql = "SELECT REBUILD_TREE();";
        $result = new Resultset(null, $this, $this->getReadConnection()->query($sql));

        if (!$result)
            throw new Exception("Rebuild tree failed");
        return $result;
    }

    /**
     * @return bool
     */
    public function beforeValidation()
    {
        if(empty($this->alias)) {
            $this->alias = Tag::friendlyTitle($this->title);
        }

        if(empty($this->parent_id)) {
            $this->parent_id = null;
        }

        //Do the validations
        $this->validate(new Uniqueness([
            "field"     => "alias",
            "message"   => 'This alias already exist'
        ]));

        $this->validate(new StringLength([
            'field'     => 'description',
            'max'       => 512,
            'min'       => 15,
            'messageMaximum' => 'Description must have maximum 512 characters',
            'messageMinimum' => 'Description must have minimum 15 characters'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'title',
            'message'   => 'The title is required'
        ]));

        $this->validate(new PresenceOf([
            'field'     => 'description',
            'message'   => 'The description is required'
        ]));

        return $this->validationHasFailed() != true;
    }
}
