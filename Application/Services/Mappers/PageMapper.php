<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Pages;

/**
 * Class PageMapper. Actions above application pages
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/PageMapper.php
 */
class PageMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Pages
     */
    public function getInstance() {
        return new Pages();
    }

























    /**
     * Add page
     *
     * @param array $data
     */
    public function create(array $data) {

        $pageModel = new Pages();

        foreach($data as $field => $value) {

            $pageModel->{$field}   =   $value;
        }

        if($pageModel->save() === true) {

            return true;
        }
        else {

            $this->setErrors($pageModel->getMessages());
            return false;
        }
    }



    /**
     * Edit page
     *
     * @param int      $id
     * @param array $data
     * @throws DbException
     */
    public function update($id, array $data) {

        $pageModel = new Pages();

        $pageModel->setId($id);

        foreach($data as $field => $value) {

            $pageModel->{$field}   =   $value;
        }

        if($pageModel->save() === true) {

            return true;
        }
        else {
            $this->setErrors($pageModel->getMessages());

            return false;
        }
    }

    /**
     * Delete page
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

        $pageModel = new Pages();

        return $pageModel->getReadConnection()
            ->delete($pageModel->getSource(), "id = ".(int)$id);
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
}