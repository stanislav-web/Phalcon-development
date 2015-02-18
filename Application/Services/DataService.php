<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
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
class DataService extends TableService {
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
        $this->limit = $limit;

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
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param $model
     * @param $offset
     * @param $limit
     */
    public function __construct($model, $limit = null, $offset = null) {

        parent::__construct();
        $this->setModel($model);

        if(is_null($limit) === false) {
            $this->setLimit($limit);
        }

        if(is_null($offset) === false) {
            $this->setOffset($offset);
        }
    }

    public function hydrate() {

        return $this->setResultSet(
            $this->getModel()->find([
            'limit' => [
                'number' => $this->getLimit(),
                'offset' => $this->getOffset()
            ]
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

            if($resultSet->getLast() > 0) {
                return parent::fromBuilder($resultSet)->sendResponse();
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

            if($resultSet->getLast() > 0) {
                return parent::fromResultSet($resultSet)->sendResponse();
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

            if($resultSet->getLast() > 0) {
                return parent::fromArray($resultSet)->sendResponse();
            }
        }

        return null;
    }
}