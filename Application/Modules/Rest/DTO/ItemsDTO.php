<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class ItemsDTO. Data Transfer Object for items relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/ItemsDTO.php
 */
class ItemsDTO extends AbstractDTO
{
    /**
     * Items collection
     *
     * @var array
     */
    public $items = [];

    /**
     * Setup banners
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $items
     * @return \Application\Modules\Rest\DTO\ItemsDTO
     */
    public function setItems(\Phalcon\Mvc\Model\Resultset\Simple $items) {

        $this->items = $items->toArray();
        $this->items['total'] = $this->total($items);
        $this->items['limit'] = $this->limit($items);
        $this->items['offset'] = $this->offset();

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