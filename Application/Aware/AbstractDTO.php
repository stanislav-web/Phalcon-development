<?php
namespace Application\Aware;

/**
 * AbstractDTO. Data Transfer Object for Results Set
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Aware/AbstractDTO.php
 */
abstract class AbstractDTO {

    /**
     * Setup total records
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
     * @return int
     */
    public function total(\Phalcon\Mvc\Model\Resultset\Simple $result) {

        if($result->getFirst() !== false) {
            return (int)$result->getFirst()->count();
        }
        else {
            return (int)$result->getLast()->count();
        }
    }

    /**
     * Setup offset records
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
     * @return int
     */
    public function offset() {
        $request = new \Phalcon\Http\Request();
        return (int)$request->get('offset');
    }

    /**
     * Setup limit records
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
     * @return int
     */
    public function limit(\Phalcon\Mvc\Model\Resultset\Simple $result) {
        return $result->count();
    }

    /**
     * Serialize object
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
     * @return int
     */
    public function serialize(\Phalcon\Mvc\Model\Resultset\Simple $result) {
        return $result->serialize();
    }

    /**
     * Reverse object to an array
     *
     * @return array
     */
    abstract public function toArray();
}