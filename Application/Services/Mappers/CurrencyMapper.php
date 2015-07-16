<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Currency;
use Application\Modules\Rest\DTO\CurrencyDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class CurrencyMapper. Actions above application currencies
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/CurrencyMapper.php
 */
class CurrencyMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Currency
     */
    public function getInstance() {
        return new Currency();
    }

    /**
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @return mixed
     */
    public function read(array $credentials = [], array $relations = []) {

        $result = $this->getInstance()->find($credentials);

        if($result->count() > 0) {
            return (new CurrencyDTO())->setCurrencies($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }
}