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
     * @param mixed $result
     * @return int
     */
    public function total($result) {

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
     * @return int
     */
    public function offset() {
        $request = new \Phalcon\Http\Request();
        return (int)$request->get('offset');
    }

    /**
     * Setup limit records
     *
     * @param mixed $result
     * @return int
     */
    public function limit($result) {
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
     * Get primary identifier
     *
     * @return int
     */
    public function getPrimary() {

        $result = $this->toArray();
        $first = array_shift($result);
        if(is_array($first) === true) {
            $sub = array_shift($first);
            if(is_array($sub) === true) {
                return (int)array_shift($sub);
            }
            return (int)$sub;
        }
        return (int)$first;
    }

    /**
     * Reverse object to an array
     *
     * @return array
     */
    abstract public function toArray();
}