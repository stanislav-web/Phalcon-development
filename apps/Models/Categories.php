<?php
namespace Models;
	use Helpers\Format,
		Phalcon\Mvc\Model\Behavior\Timestampable,
		Phalcon\Mvc\Model\Resultset\Simple as Resultset,
		Phalcon\Mvc\Model\Exception;

	/**
 * Class Categories `categories`
 * @package 	Application
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

		// create relations between Categories => EnginesCategoriesRel

		$this->hasManyToMany("id",
			EnginesCategoriesRel::TABLE,
			"category_id",
			"engine_id",
			Engines::TABLE,
			"id",
			['alias' => 'categoriesRel']
		);
	}

	/**
	 * This action run before save anything to this model
	 * @return null
	 */
	public function beforeSave()
	{
		$this->rebuildTree();
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

	/**
	 * Get all related records from Categories joined to Engines
	 * @param array $params
	 * @return \Phalcon\Paginator\Adapter\QueryBuilder
	 */
	public function get(array $params = [])
	{
		/**
		 * Array of database columns which should be read and sent back to DataTables. Use a space where
 		 * you want to insert a non-database field (for example a counter or static image)
 		 */

		$params['iTotal']	=	self::find()->count();
		$builder 			= 	$this->_modelsManager->createBuilder();

		// setup selected columns
		$params['aColumns'] 	= 	['c.lft', 'c.title', 'c.description', 'c.alias', 'c.sort'];
		$builder->addFrom(self::TABLE, 'c')->columns($params['aColumns']);

		// setup paging

		if(isset($params['iDisplayStart']) && $params['iDisplayLength'] != '-1')
			$builder->offset($params['iDisplayStart'])->limit($params['iDisplayLength']);


		// setup ordering

		if(isset($params['iSortingCols']) && $params['iSortingCols'] > 0)
		{
			// ordering as default
			$order = [];
			for($i=0; $i<intval($params['iSortingCols']); $i++)
			{
				$iSortCol 	= 	$params['iSortCol_'.$i];
				$bSortable 	= 	$params['bSortable_'.$i];
				$sSortDir 	= 	$params['sSortDir_'.$i];

				if($bSortable == 'true')
				{
					$order[] = $params['aColumns'][intval($iSortCol)]." ".$sSortDir;
				}
			}
			$builder->orderBy(implode(',', $order));
		}

		/**
	 	 * Filtering
	 	 * NOTE this does not match the built-in DataTables filtering which does it
	 	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 	 * on very large tables, and MySQL's regex functionality is very limited
	 	 */
		if(isset($params['sSearch']) && !empty($params['sSearch']))
		{
			for($i=0; $i<count($params['aColumns']); $i++)
			{
				$bSearchable = $params['bSearchable_'.$i];

				// individual column filtering
				if(isset($bSearchable) && $bSearchable == 'true')
				{
					if($i > 0)
						$builder->orWhere($params['aColumns'][$i]." LIKE :".$i.":",
							[$i => "%".$params['sSearch']."%"]);
					else
						$builder->where($params['aColumns'][$i]." LIKE :".$i.":",
							[$i => "%".$params['sSearch']."%"]);
				}
			}
		}

		// execute query
		$query	=	$builder->getQuery()->execute();

		// format output
		$result = Format::toDataTable($query, $params);

		// return result
		return $result;
	}

	/**
	 * Calling rebuild categories tree function
	 * @throws \Phalcon\Mvc\Model\Exception
	 * @return Resultset
	 */
	public function rebuildTree()
	{
		$sql = "SELECT REBUILD_TREE();";
		$result =  new Resultset(null, $this, $this->getReadConnection()->query($sql));

		if(!$result)
			throw new Exception("Rebuild tree failed");
		return $result;
	}
}
