<?php
namespace Application\Services\Views;

use \Phalcon\DI\InjectionAwareInterface;
use \DataTables\DataTable as TableService;

/**
 * Class DataService. Actions above application data view
 *
 * @package Application\Services
 * @subpackage Views
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Views/DataService.php
 */
class DataService implements InjectionAwareInterface {

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
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }
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
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $offset
     */
    public function setPage($page)
    {
        $this->page = (int)$page;

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
     */
    public function __construct($model) {

        $this->setModel($model);
    }

    public function hydrate() {

        return $this->setResultSet(
            $this->getModel()->find()
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
            else {
                exit(json_encode(['data' => [], 'recordsTotal' => 0, 'draw' => "1", 'recordsFiltered' => 0]));
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
            else {
                exit(json_encode(['data' => [], 'recordsTotal' => 0, 'draw' => "1", 'recordsFiltered' => 0]));
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
            else {
                exit(json_encode(['data' => [], 'recordsTotal' => 0, 'draw' => "1", 'recordsFiltered' => 0]));
            }
        }

        return null;
    }
}