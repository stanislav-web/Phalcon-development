<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class PageDTO. Data Transfer Object for pages relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/PageDTO.php
 */
class PageDTO extends AbstractDTO
{
    /**
     * Pages collection
     *
     * @var array
     */
    public $pages = [];

    /**
     * Setup pages
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $pages
     * @return $this
     */
    public function setPages(\Phalcon\Mvc\Model\Resultset\Simple $pages) {

        $this->pages = $pages->toArray();
        $this->pages['total'] = $this->total($pages);
        $this->pages['limit'] = $this->limit($pages);
        $this->pages['offset'] = $this->offset();

        return $this;
    }

    /**
     * Reverse object to an array
     *
     * @return array
     */
    public function toArray() {
        return get_object_vars($this);
    }

}
