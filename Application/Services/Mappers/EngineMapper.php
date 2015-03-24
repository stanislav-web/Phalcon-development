<?php
namespace Application\Services\Mappers;

use \Phalcon\DI\InjectionAwareInterface;
use \Phalcon\Mvc\Model\Exception;
use \Phalcon\Http\Request;
use Application\Aware\ModelCrudInterface;
use Application\Models\Engines;
use Application\Models\Currency;

/**
 * Class EngineMapper. Actions above application engine
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/EngineMapper.php
 */
class EngineMapper implements InjectionAwareInterface, ModelCrudInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Upload logo directory
     *
     * @var string $logoDirectory;
     */
    private $logoDirectory = 'files/logo';

    /**
     * Errors array
     *
     * @var array $errors;
     */
    private $errors = [];

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
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Define used engine
     *
     * @return \Application\Models\Engines $engine
     */
    public function define() {

        $session = $this->getDi()->getShared('session');

        // find current engine
        if($session->has('engine') === true) {
            $engine = $session->get('engine');
        }
        else {
            $request = $this->getDi()->get('request');
            $engine   =   Engines::findFirst("host = '".$request->getHttpHost()."'");

            if($engine === null) {
                throw new Exception('Not found used host');
            }
            // collect to the session
            $session->set('engine', $engine);

        }

        return $engine;
    }

    /**
     * Create engine
     *
     * @param array $data
     * return boolean
     */
    public function create(array $data) {

        $engineModel = new Engines();

        foreach($data as $field => $value) {

            $engineModel->{$field}   =   $value;
        }

        // check uploaded logo (if exist)

        if((new Request())->hasFiles() !== false) {

            $uploader = $this->getDi()->get('uploader');

            $uploader->setRules(['directory' =>  DOCUMENT_ROOT.DIRECTORY_SEPARATOR.$this->logoDirectory]);

            if($uploader->isValid() === true) {

                $uploader->move();
                $engineModel->setLogo(basename($uploader->getInfo()[0]['path']));
            }
            else {
                // the store failed, the following message were produced
                $uploader->truncate();
                $this->setErrors($uploader->getErrors());

                return false;
            }
        }

        if($engineModel->save() === true) {

            return true;
        }
        else {

            $this->setErrors($engineModel->getMessages());
            return false;
        }
    }

    /**
     * Get instance of polymorphic object
     *
     * @return Categories
     */
    public function getInstance() {
        return new Engines();
    }

    /**
     * Get model attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        $metaData = $this->getInstance()->getModelsMetaData();
        return $metaData->getAttributes($this->getInstance());
    }

    /**
     * Read engines
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function read($id = null, array $data = []) {

        $result = (empty($id) === true) ? $this->getList() : $this->getOne($id);

        return $result;
    }

    /**
     * Edit category
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, array $data) {

        $engineModel = new Engines();

        $engineModel->setId($id);

        foreach($data as $field => $value) {

            $engineModel->{$field}   =   $value;
        }
        // check uploaded logo (if exist)

        if((new Request())->hasFiles() !== false) {

            $uploader = $this->getDi()->get('uploader');

            $uploader->setRules(['directory' =>  DOCUMENT_ROOT.DIRECTORY_SEPARATOR.$this->logoDirectory]);

            if($uploader->isValid() === true) {

                $uploader->move();
                $engineModel->setLogo(basename($uploader->getInfo()[0]['path']));
            }
            else {
                // the store failed, the following message were produced
                $uploader->truncate();
                $this->setErrors($uploader->getErrors());

                return false;
            }
        }
        if($engineModel->save() === true) {

            return true;
        }
        else {
            $this->setErrors($engineModel->getMessages());

            return false;
        }
    }

    /**
     * Delete engine
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

        $engineModel = new Engines();

        return $engineModel->getReadConnection()
            ->delete($engineModel->getSource(), "id = ".(int)$id);
    }

    /**
     * Set errors message
     *
     * @param mixed $errors
     */
    public function setErrors($errors) {
        $this->errors = $errors;
    }

    /**
     * Get error messages
     *
     * @return mixed $errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get all related records from Engines joined to Currency
     *
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    public function getList()
    {
        $engineModel = new Engines();

        $builder = $engineModel->getModelsManager()->createBuilder();
        $builder
            ->addFrom(Engines::TABLE, 'e')
            ->leftJoin(Currency::TABLE, 'c.id = e.currency_id', 'c');

        $result = $builder->getQuery()->execute();

        return $result;
    }

    /**
     * Get engines by condition
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getListByParams(array $params = [])
    {
        return Engines::find($params);
    }

    /**
     * Get engine by Id
     *
     * @param int $id
     * @return \Phalcon\Mvc\Model
     */
    public function getOne($id)
    {
        return Engines::findFirst($id);
    }

    /**
     * Get engine(s) status
     *
     * @param int $status_id
     * @return array
     */
    public function getStatuses($status_id = null)
    {
        return ($status_id === null) ?
            Engines::$statuses : Engines::$statuses[(int)$status_id];
    }
}