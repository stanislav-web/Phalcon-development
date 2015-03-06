<?php
namespace Application\Aware;

/**
 * ModelServiceInterface. Implementing rules necessary intended for service models
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/ModelServiceInterface.php
 */
interface ModelServiceInterface {

    /**
     * Create record
     *
     * @param array $data
     * @return boolean
     */
    public function create(array $data);

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
     * @param array $data
     * @return boolean
     */
    public function delete($id, array $data);

}