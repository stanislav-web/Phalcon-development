<?php
namespace Application\Aware;

use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * AbstractDTO. Data Transfer Object for Results Set
 *
 * @package Application
 * @subpackage Aware
 * @since      PHP >=5.6
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

        if($result instanceof \Phalcon\Mvc\ModelInterface) {
            // always return 1 if there using only model data

            return 1;
        }
        return $result->count();
    }

    /**
     * Setup offset records
     *
     * @return int
     */
    public function offset() {
        $request = new \Phalcon\Http\Request();
        return (int)$request->get('offset', null, 0);
    }

    /**
     * Setup limit records
     *
     * @param mixed $result
     * @return int
     */
    public function limit($result) {

        $request = new \Phalcon\Http\Request();

        $limit = (int)$request->get('limit', null, 0);

        if($limit === 0) {

            // always return all records if limit is not pulled
            return $result->count();
        }

        return $limit;
    }

    /**
     * Serialize object
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $result
     * @return string
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