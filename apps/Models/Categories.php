<?php
namespace Models;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 * Class Categories `categories`
 * @package 	Backend
 * @subpackage 	Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Models/Categories.php
 */
class Categories extends \Phalcon\Mvc\Model
{
	/**
	 * Absolute model name
	 * @const
	 */
	const TABLE	=	'\Models\Categories';

    protected

		/**
		 *
		 * @var integer
		 */
		$id,

    	/**
     	 * @var string
     	 */
   	 	$title,

		/**
		 * @var string
		 */
		$description,

		/**
		 * @var string
		 */
		$alias,

    	/**
     	 * @var integer
     	 */
     	$parent_id,

		/**
		 * @var integer
		 */
		$engine_id,

		/**
		 * @var integer
		 */
		$sort,

		/**
		 * Datetime create
		 * @var datetime
		 */
		 $date_create,

		/**
	 	 * Timestamp add
		 * @var timestamp
	 	 */
		 $date_update;

	/**
	 * Initialize Model
	 */
	public function initialize()
	{
		// its allow to keep empty data to my db
		$this->setup([
			'notNullValidations'	=>	false,
			'exceptionOnFailedSave'	=>	true
		]);

		// skip attributes before every IN >
		$this->skipAttributesOnCreate(['date_update']);
		$this->skipAttributesOnUpdate(['date_update']);

		// before insert event
		$this->addBehavior(new Timestampable([
				'beforeCreate' => [
					'field' => 'date_create',
					'format' => 'Y-m-d:H:i:s'
				]
			]
		));
	}

	/**
	 * Before create fields default values
	 */
	public function beforeCreate()
	{
		// init fields by default
		$this->setDateCreate(new \DateTime());
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
     * Method to set the value of field title
     *
     * @param string $host
     * @return $this
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
	 * @return $this
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
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Method to set the value of field parent_id
     *
     * @param string $description
     * @return $this
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

	/**
	 * Method to set the value of field engine_id
	 *
	 * @param string $description
	 * @return $this
	 */
	public function setEngineId($engine_id)
	{
		$this->engine_id = $engine_id;

		return $this;
	}

	/**
	 * Method to set the value of field sort
	 *
	 * @param string $description
	 * @return $this
	 */
	public function setSort($sort)
	{
		$this->sort = $sort;

		return $this;
	}

	/**
	 * Method to set the value of field date_create
	 *
	 * @param integer $status
	 * @return $this
	 */
	public function setDateCreate($date_create)
	{
		$this->date_create = $date_create;

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
	 * Returns the value of field engine_id
	 *
	 * @return string
	 */
	public function getEngineId()
	{
		return $this->engine_id;
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
}
