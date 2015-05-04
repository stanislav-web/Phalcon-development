<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class BannersDTO. Data Transfer Object for banners relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/BannersDTO.php
 */
class BannersDTO extends AbstractDTO
{
    /**
     * Banners collection
     *
     * @var array
     */
    public $banners = [];

    /**
     * Setup banners
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $banners
     * @return \Application\Modules\Rest\DTO\BannersDTO
     */
    public function setBanners(\Phalcon\Mvc\Model\Resultset\Simple $banners) {

        $this->banners = $banners->toArray();
        $this->banners['total'] = $this->total($banners);
        $this->banners['limit'] = $this->limit($banners);
        $this->banners['offset'] = $this->offset();

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
