<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;
use Application\Helpers\Node;

/**
 * Class ItemsDTO. Data Transfer Object for items relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.6
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
     * Items attributes collection
     *
     * @var array
     */
    public $attributes = [];

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
     * Setup item's attributes
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $attributes
     * @return \Application\Modules\Rest\DTO\ItemsDTO
     */
    public function setAttributes(\Phalcon\Mvc\Model\Resultset\Simple $attributes) {

        $attributeNames = [];

        // find attributes name
        foreach($attributes as $attr) {
            $attributeNames[] = $attr->getRelated('attributeNames')->toArray();
        }

        $attributes = $attributes->toArray();

        // parse items and join attributes to them
        if(empty($this->items) === false) {

            foreach($this->items as &$item) {
                $attributeValues = Node::searchInArray($attributes, 'item_id', $item['id']);

                if(empty($attributeValues) === false) {
                    $item['attributes'] = $this->assignAttributes($attributeNames, $attributeValues);
                }
            }
        }
        else {
            $this->attributes[] = $attributes;
        }

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

    /**
     * Assign attributes names & values to item
     *
     * @param $names
     * @param $values
     *
     * @return array
     */
    private function assignAttributes($names, $values) {

        $attr = [];
        foreach($names as $attribute) {
            $attributeValues = Node::searchInArray($values, 'item_attribute_id', $attribute['id']);

            if(empty($attributeValues) === false) {
                $attr[] = array_merge($attribute, $attributeValues[0]);
            }
        }
        return $attr;
    }

}