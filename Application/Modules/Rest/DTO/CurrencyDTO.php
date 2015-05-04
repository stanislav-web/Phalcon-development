<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class CurrencyDTO. Data Transfer Object for currencies relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/CurrencyDTO.php
 */
class CurrencyDTO extends AbstractDTO
{
    /**
     * Currencies collection
     *
     * @var array
     */
    public $currencies = [];

    /**
     * Setup currencies
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $currencies
     * @return \Application\Modules\Rest\DTO\CurrencyDTO
     */
    public function setCurrencies(\Phalcon\Mvc\Model\Resultset\Simple $currencies) {

        $this->currencies = $currencies->toArray();
        $this->currencies['total'] = $this->total($currencies);
        $this->currencies['limit'] = $this->limit($currencies);
        $this->currencies['offset'] = $this->offset();

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
