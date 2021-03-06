<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Pages;
use Application\Modules\Rest\DTO\PageDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class PageMapper. Actions above application pages
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/PageMapper.php
 */
class PageMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Pages
     */
    public function getInstance() {

        return new Pages();
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

            return (new PageDTO())->setPages($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }
}