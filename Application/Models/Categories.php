<?php
namespace Application\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Phalcon\Mvc\Model\Transaction\Failed as TnxFailed;
use Phalcon\Db\RawValue;
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
     * @const
     */
    const TABLE = '\Application\Models\Categories';

    /**
     * @var integer
     */
    protected $id;

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
    public $alias;

    /**
     * @var integer
     */
    public $parent_id;

    /**
     * @var integer
     */
    protected $sort;

    /**
     * @var integer
     */
    protected $visibility;

    /**
     * Datetime create
     * @var datetime
     */
    protected $date_create;

    /**
     * Timestamp add
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

        //Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(['date_create', 'date_update']);

        // create relations between Categories => EnginesCategoriesRel

        $this->hasManyToMany("id", EnginesCategoriesRel::TABLE, "category_id", "engine_id", Engines::TABLE, "id",
            ['alias' => 'engines']
        );
    }

    /**
     * Get transaction manager
     *
     * @return \Phalcon\Mvc\Model\Transaction\Manager
     */
    protected function tnx() {
        return $this->getDI()->get('transactions');
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
     * Method to set the value of field date_create
     *
     * @param integer $date_create
     * @return Categories
     */
    public function setDateCreate($date_create = null)
    {
        if($date_create === null) {

            $datetime = new Datetime(new DateTimeZone(date_default_timezone_get()));

            $this->date_create = $datetime->format('Y-m-d H:i:s');

        }
        else {
            $this->date_create  =   $date_create;
        }

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $host
     * @return Categories
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $host
     * @return Categories
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field alias
     *
     * @param string $name
     * @return Categories
     */
    public function setAlias($alias = '')
    {
        $this->alias = (empty($alias))
            ? Tag::friendlyTitle($this->getTitle(), '-', true)
            : strtolower(trim($alias));

        return $this;
    }

    /**
     * Method to set the value of field parent_id
     *
     * @param string $description
     * @return Categories
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = (isset($parent_id) === false)
            ? (int)$parent_id : new RawValue('null');

        return $this;
    }

    /**
     * Method to set the value of field visibility
     *
     * @param int $visibility
     * @return Categories
     */
    public function setVisibility($visibility)
    {
        $this->skipAttributesOnUpdate(['title', 'description','parent_id', 'alias', 'sort']);

        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Method to set the value of field sort
     *
     * @param int $sort
     * @return Categories
     */
    public function setSort($sort)
    {
        $this->sort = (isset($sort) === false)
            ? (int)$sort : new RawValue('default');

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
     * @return Categories
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Returns the value of field alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Returns the value of field parent_id
     *
     * @return string
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Returns the value of field sort
     *
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Returns the value of field visibility
     *
     * @return integer
     */
    public function getVisibility()
    {
        return $this->visibility;
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
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        if(empty($this->alias)) {
            $this->setAlias();
        }

        if(empty($this->visibility)) {
            $this->setVisibility(0);
        }

        //Do the validations
        $this->validate(new Uniqueness([
            "field"     => "alias",
            "message"   => 'This alias already exist'
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

    /**
     * Add category
     * @param array $data
     * @return bool
     * @throws \Phalcon\Db\Exception
     */
    public function add(array $data) {

        try {

            // begin transaction
            $transaction = $this->tnx()->get();

            foreach($data as $field => $value) {

                    $this->{$field}   =   $value;
            }
            $this->setTransaction($transaction);

            if($this->save() === true) {

                foreach($data['engine_id'] as $i => $engine_id) {

                    $rel = (new EnginesCategoriesRel())->setCategoryId($this->getId())->setEngineId($engine_id);

                    if($rel->save() === false) {

                        foreach ($rel->getMessages() as $message) {

                            $transaction->rollback($message->getMessage());
                        }
                    }
                }
                $transaction->commit();

                return true;
            }
            else {
                foreach ($this->getMessages() as $message) {

                    $transaction->rollback($message->getMessage());
                }
            }

            $transaction->commit();
        }
        catch(TnxFailed $e) {
            throw new \Phalcon\Db\Exception($e->getMessage());
        }
    }
}
