<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class LogDTO. Data Transfer Object for logs relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/LogDTO.php
 */
class LogDTO extends AbstractDTO
{
    /**
     * Logs collection
     *
     * @var array
     */
    public $logs = [];

    /**
     * Setup logs
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $logs
     * @return \Application\Modules\Rest\DTO\LogDTO
     */
    public function setLogs(\Phalcon\Mvc\Model\Resultset\Simple $logs) {

        $this->logs = $logs->toArray();
        $this->logs['total'] = $this->total($logs);
        $this->logs['limit'] = $this->limit($logs);
        $this->logs['offset'] = $this->offset();

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
