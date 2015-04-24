<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Errors;
use Application\Modules\Rest\DTO\ErrorDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class ErrorMapper. Actions above application pages
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/ErrorMapper.php
 */
class ErrorMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Errors
     */
    public function getInstance() {
        return new Errors();
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
            return (new ErrorDTO())->setErrors($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
     * Get error by code
     *
     * @param array $code
     * @throws NotFoundException
     */
    public function getError($code) {

        $result = $this->getInstance()->findFirst(["code = '".$code."'"]);
        if($result->count() > 0) {
            return $result;
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }
}