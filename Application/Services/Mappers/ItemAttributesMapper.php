<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\ItemAttributes;
use Application\Modules\Rest\DTO\ItemAttributesDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class ItemAttributesMapper. Actions above item's attributes
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/ItemAttributesMapper.php
 */
class ItemAttributesMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return \Application\Models\ItemAttributes
     */
    public function getInstance() {
        return new ItemAttributes();
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
            return (new ItemAttributesDTO())->setAttributes($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }
}