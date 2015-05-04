<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;
use Application\Helpers\Node;

/**
 * Class CategoryDTO. Data Transfer Object for categories relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/CategoryDTO.php
 */
class CategoryDTO extends AbstractDTO
{
    /**
     * Categories collection
     *
     * @var array
     */
    public $categories = [];

    /**
     * Setup categories
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $categories
     * @return $this
     */
    public function setCategories(\Phalcon\Mvc\Model\Resultset\Simple $categories) {

        $this->categories = Node::setNestedTree($categories->toArray());
        $this->categories['total'] = $this->total($categories);
        $this->categories['limit'] = $this->limit($categories);
        $this->categories['offset'] = $this->offset();

        return $this;
    }

    /**
     * Reverse object to real array for all public properties
     *
     * @param object $object
     * @return mixed
     */
    public function toArray() {
        return  get_object_vars($this);
    }
}
