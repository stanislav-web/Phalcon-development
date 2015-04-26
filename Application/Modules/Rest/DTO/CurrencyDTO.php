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
     * @return $this
     */
    public function setCurrencies(\Phalcon\Mvc\Model\Resultset\Simple $currencies) {

        $this->currencies = $currencies->toArray();
        $this->currencies['total'] = $this->total($currencies);
        $this->currencies['limit'] = $this->limit($currencies);
        $this->currencies['offset'] = $this->offset();

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
