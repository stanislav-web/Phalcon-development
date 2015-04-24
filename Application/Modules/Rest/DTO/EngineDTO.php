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
     * Currencies collection
     *
     * @var array
     */
    public $currencies = [];

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

        $this->engines = $engines->toArray();
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

        $this->currencies[] = $currencies->toArray();
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
    public function toArray() {
        return get_object_vars($this);
    }

}
