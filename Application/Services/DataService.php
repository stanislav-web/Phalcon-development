<?php
namespace Application\Services;

use \Phalcon\Mvc\Model\Exception;
use \DataTables\DataTable as TableService;

/**
 * Class DataService. Actions above application data view
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/DataService.php
 */
class DataService {

    /**
     * Current host
     *
     * @var string $model;
     */
    protected $model;

    /**
     * Result set from model
     *
     * @var mixed $resultSet;
     */
    protected $resultSet;

    /**
     * Limit rows per page
     *
     * @var int $limit
     */
    protected $limit = 10;

    /**
     * Offset records
     *
     * @var int $offset
     */
    protected $offset = 0;

    /**
     * @return model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return int $limit
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int)$offset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     * @param mixed $resultSet
     */
    public function setResultSet($resultSet)
    {
        $this->resultSet = $resultSet;

        return $this;
    }

    /**
     * @param $model
     * @param $offset
     * @param $limit
     */
    public function __construct($model, $offset = null, $limit = null) {

        $this->setModel($model);

        if(is_numeric($offset) === true) {
            $this->setOffset($limit);
        }

        if(is_numeric($limit) === true) {

            $this->setLimit($limit);
        }
    }

    public function hydrate() {

        return $this->setResultSet(
            $this->getModel()->find([
                'limit'  => $this->getLimit(),
                'offset' => $this->getOffset()
            ])
        );
    }

    /**
     * Get result from query building params
     *
     * @return DataService|null
     */
    public function jsonFromBuild() {

        $resultSet = $this->getResultSet();

        if($resultSet instanceof \Phalcon\Mvc\Model\Query\Builder) {

            if($resultSet->count() > 0) {
                return (new TableService())->fromBuilder($resultSet)->sendResponse();
            }
        }

        return null;
    }

    /**
     * Get result from simple result set
     *
     * @return DataService|null
     */
    public function jsonFromObject() {

        $resultSet = $this->getResultSet();

        if($resultSet instanceof \Phalcon\Mvc\Model\Resultset\Simple) {

            if($resultSet->count() > 0) {

                return (new TableService())->fromResultSet($resultSet)->sendResponse();
            }
        }

        return null;
    }

    /**
     * Get result from native array
     *
     * @return DataService|null
     */
    public function jsonFromModel() {

        $resultSet = $this->getResultSet();

        if(is_array($resultSet) === true) {

            if($resultSet->count() > 0) {
                return (new TableService())->fromArray($resultSet)->sendResponse();
            }
        }

        return null;
    }
}