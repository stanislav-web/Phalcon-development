<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Models\Engines;
use \Phalcon\Mvc\Model\Exception;
use \Phalcon\Http\Request;

/**
 * Class EngineService. Actions above application engine
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/EngineService.php
 */
class EngineService implements InjectionAwareInterface {

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
    public function define($host) {

        $session = $this->di->getShared('session');

        // find current engine
        if($session->has('engine') === false || $session->get('engine') === null) {

            $engine   =   Engines::findFirst("host = '".$host."'");

            if($engine === null) {
                throw new Exception('Not found used host');
            }

            // collect to the session
            $session->set('engine', $engine);
        }
        else {
            // get current engine
            $engine  =   $session->get('engine');
        }

        return $engine;
    }

    /**
     * Add engine
     *
     * @param array $data
     * @throws DbException
     */
    public function addEngine(array $data) {

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
     * Edit category
     *
     * @param int      $engine_id
     * @param array $data
     */
    public function editEngine($engine_id, array $data) {

        $engineModel = new Engines();

        $engineModel->setId($engine_id);

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
     * @param int      $engine_id
     * @return boolean
     */
    public function deleteEngine($engine_id) {

        $engineModel = new Engines();

        return $engineModel->getReadConnection()
            ->delete($engineModel->getSource(), "id = ".(int)$engine_id);
    }

    /**
     * Set errors message
     *
     * @param mixed $errors
     */
    private function setErrors($errors) {
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

}