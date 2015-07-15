<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Categories;
use Application\Modules\Rest\DTO\CategoryDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Phalcon\Mvc\ModelInterface;

/**
 * Class CategoryMapper. Actions above application categories
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/CategoryMapper.php
 */
class CategoryMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Categories
     */
    public function getInstance() {
        return new Categories();
    }

    /**
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @return mixed
     */
    public function read(array $credentials = [], array $relations = []) {

        // find records by credentials
        $result = (isset($credentials['bind']) === true)
            ? $this->getInstance()->findFirst($credentials['bind'][0])
            : $this->getInstance()->find($credentials);

        // get count data
        $count = (
            ($result != false) ? $result->count() :
            ($result instanceof ModelInterface) ? 1 : null
        );

        // resolve model response
        $result = (
            ($count == 1) ? (new CategoryDTO())->setCategoryItems($result->getItems($this->filterParams($credentials))) :
            (($count > 0) ? (new CategoryDTO())->setCategories($result) : null)
        );

        if(null != $result) {
            return $result;
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }
}