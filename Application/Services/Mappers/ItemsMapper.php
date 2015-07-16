<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Items;
use Application\Modules\Rest\DTO\ItemsDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class ItemsMapper. Actions above application items
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/ItemsMapper.php
 */
class ItemsMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Items
     */
    public function getInstance() {
        return new Items();
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
            return (new ItemsDTO())->setItems($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }
}