<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class SubscribersDTO. Data Transfer Object for subscribers relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/SubscribersDTO.php
 */
class SubscribersDTO extends AbstractDTO
{
    /**
     * Subscribers collection
     *
     * @var array
     */
    public $subscribers = [];

    /**
     * Setup subscribers
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $subscribers
     * @return \Application\Modules\Rest\DTO\SubscribersDTO
     */
    public function setAccess(\Phalcon\Mvc\Model\Resultset\Simple $subscribers) {

        $this->subscribers = $subscribers->toArray();
        $this->subscribers['total'] = $this->total($subscribers);
        $this->subscribers['limit'] = $this->limit($subscribers);
        $this->subscribers['offset'] = $this->offset();

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
