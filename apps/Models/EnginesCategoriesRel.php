<?php
namespace Models;

/**
 * Class EnginesCategoriesRel `engines_categories_rel`
 * @package 	Application
 * @subpackage 	Models
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Models/EnginesCategoriesRel.php
 */
class EnginesCategoriesRel extends \Phalcon\Mvc\Model
{
	/**
	 * Absolute model name
	 * @const
	 */
	const TABLE	=	'\Models\EnginesCategoriesRel';

    /**
     *
     * @var integer
     */
    protected $engine_id;

    /**
     *
     * @var string
     */
    protected $category_id;

	/**
	 * Initialize Model
	 */
	public function initialize()
	{
		$this->belongsTo('engine_id', Engines::TABLE, 'id',
			array('alias' => 'engineRel')
		);
		$this->belongsTo('category_id', Categories::TABLE, 'id',
			array('alias' => 'categoryRel')
		);
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
     * Returns the value of field category_id
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }
}
