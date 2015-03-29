<?php
namespace Application\Aware;

/**
 * ModelCrudInterface. Implementing rules necessary intended for service's models
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/ModelCrudInterface.php
 */
interface ModelCrudInterface {

    /**
     * Create record
     *
     * @param array $data
     * @return boolean
     */
    public function create(array $data);

    /**
     * Read record(s)
     *
     * @param array $credentials
     * @return boolean
     */
    public function read(array $credentials);

    /**
     * Update record
     *
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function update($id, array $data);

    /**
     * Delete record
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Set errors message
     *
     * @param mixed $errors
     */
    public function setErrors($errors);

    /**
     * Get error messages
     *
     * @return mixed $errors
     */
    public function getErrors();

    /**
     * Get model attributes
     *
     * @return array
     */
    public function getAttributes();
}