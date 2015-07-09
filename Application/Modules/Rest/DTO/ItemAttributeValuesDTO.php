<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class ItemAttributeValuesDTO. Data Transfer Object for item's attribute values relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/ItemAttributeValuesDTO.php
 */
class ItemAttributeValuesDTO extends AbstractDTO
{
    /**
     * Values collection
     *
     * @var array
     */
    public $values = [];

    /**
     * Setup item's attribute values
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $values
     * @return \Application\Modules\Rest\DTO\ItemAttributeValuesDTO
     */
    public function setValues(\Phalcon\Mvc\Model\Resultset\Simple $values) {

        $this->values  = $values->toArray();
        $this->values['total'] = $this->total($values);
        $this->values['limit'] = $this->limit($values);
        $this->values['offset'] = $this->offset();

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
