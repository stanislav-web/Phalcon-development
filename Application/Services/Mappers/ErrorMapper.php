<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Errors;
use Application\Modules\Rest\DTO\ErrorDTO;

/**
 * Class ErrorMapper. Actions above application pages
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
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

        return [];
    }

    /**
     * Get error by code
     *
     * @param array $code
     * @return mixed
     */
    public function getError($code) {

        $result = $this->getInstance()->findFirst(["code = '".$code."'"]);

        if($result) {
            return $result;
        }

        return [];
    }
}