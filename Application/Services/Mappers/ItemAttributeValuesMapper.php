<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\ItemAttributeValues;
use Application\Modules\Rest\DTO\ItemAttributeValuesDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class ItemAttributeValuesMapper. Actions above item's attribute values
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/ItemAttributeValuesMapper.php
 */
class ItemAttributeValuesMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return \Application\Models\ItemAttributes
     */
    public function getInstance() {
        return new ItemAttributeValues();
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
            return (new ItemAttributeValuesDTO())->setValues($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }
}