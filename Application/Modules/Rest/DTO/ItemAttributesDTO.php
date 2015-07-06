<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class ItemAttributesDTO. Data Transfer Object for item's attributes relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/ItemAttributesDTO.php
 */
class ItemAttributesDTO extends AbstractDTO
{
    /**
     * Attributes collection
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Setup item's attributes
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $attributes
     * @return \Application\Modules\Rest\DTO\ItemAttributesDTO
     */
    public function setAttributes(\Phalcon\Mvc\Model\Resultset\Simple $attributes) {

        $this->attributes  = $attributes->toArray();
        $this->attributes['total'] = $this->total($attributes);
        $this->attributes['limit'] = $this->limit($attributes);
        $this->attributes['offset'] = $this->offset();

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
