<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Banners;
use Application\Modules\Rest\DTO\BannersDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class BannersMapper. Actions above application banners
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/BannersMapper.php
 */
class BannersMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Banners
     */
    public function getInstance() {
        return new Banners();
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
            return (new BannersDTO())->setBanners($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }
}