<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;
use Application\Helpers\Node;

/**
 * Class EngineDTO. Data Transfer Object for engines relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/EngineDTO.php
 */
class EngineDTO extends AbstractDTO
{
    /**
     * Engines collection
     *
     * @var array
     */
    public $engines = [];

    /**
     * Currency collection
     *
     * @var array
     */
    public $currency = [];

    /**
     * Categories collection
     *
     * @var array
     */
    public $categories = [];

    /**
     * Banners collection
     *
     * @var array
     */
    public $banners = [];

    /**
     * Setup engines (main)
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $engines
     * @return \Application\Modules\Rest\DTO\EngineDTO
     */
    public function setEngines(\Phalcon\Mvc\Model\Resultset\Simple $engines) {

        if($engines->count() > 1) {
            $this->engines = $engines->toArray();
        }
        else {
            $this->engines = Node::asRealArray($engines->getFirst());
        }

        $this->engines['total'] = $this->total($engines);
        $this->engines['limit'] = $this->limit($engines);
        $this->engines['offset'] = $this->offset();

        return $this;
    }

    /**
     * Setup banners
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $banners
     * @return $this
     */
    public function setBanners(\Phalcon\Mvc\Model\Resultset\Simple $banners) {

        $this->banners[] = $banners->toArray();
        return $this;
    }

    /**
     * Setup currencies
     *
     * @param \Application\Models\Currency  $currencies
     * @return $this
     */
    public function setCurrencies(\Application\Models\Currency $currencies) {

        $this->currency[] = $currencies->toArray();
        return $this;
    }

    /**
     * Setup categories
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $categories
     * @return $this
     */
    public function setCategories(\Phalcon\Mvc\Model\Resultset\Simple $categories) {

        $this->categories[] = Node::setNestedTree($categories->toArray());

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
