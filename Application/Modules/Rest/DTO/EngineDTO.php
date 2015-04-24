<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

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
     * Setup engines (main)
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $engines
     * @return $this
     */
    public function setEngines(\Phalcon\Mvc\Model\Resultset\Simple $engines) {

        if($engines->count() > 1) {
            $this->engines = $engines->toArray();
        }
        else {
            $this->engines = $this->asRealArray($engines->getFirst());
        }

        $this->engines['total'] = $this->total($engines);
        $this->engines['limit'] = $this->limit($engines);
        $this->engines['offset'] = $this->offset();

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
    public function setCategories(\Application\Models\Categories $categories) {

        $this->categories[] = $categories->toArray();

        return $this;
    }

    /**
     * Reverse object to an array
     *
     * @return array
     */
    public function asRealArray($obj) {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? $this->asRealArray($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
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
