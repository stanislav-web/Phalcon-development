<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Models\Pages;
use Phalcon\Db\Exception as DbException;

/**
 * Class PagesService. Actions above application pages
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/PagesService.php
 */
class PagesService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

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

    /**
     * Add category
     *
     * @param array $data
     * @throws DbException
     */
    public function create(array $data) {

    }

    /**
     * Edit category
     *
     * @param int      $id
     * @param array $data
     * @throws DbException
     */
    public function update($id, array $data) {

    }

    /**
     * Delete category
     *
     * @param int      $id
     * @return boolean
     */
    public function delete($id) {

    }
}