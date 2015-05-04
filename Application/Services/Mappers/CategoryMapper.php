<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Categories;
use Application\Modules\Rest\DTO\CategoryDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class CategoryMapper. Actions above application categories
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
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

        $result = $this->getInstance()->find($credentials);

        if($result->count() > 0) {
            //@TODO Set nested tree output
//            if($result->count() > 1) {
//                $this->setNestedTree($result->toArray(), 'parent_id');
//            }
            return (new CategoryDTO())->setCategories($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
     * Nested Tree builder
     *
     * @param array $array
     * @param int   $key
     * @return array
     */
    public function setNestedTree(array $elements, $key)
    {
        $branch = [];

        foreach($elements as $element) {

            if (is_null($element[$key]) === true) {
                $branch[$element['id']] = $element;
                $id = $element['id'];
                continue;
            }
            else if($element['parent_id'] !== $id) {
                $branch[$id]['childs'][0]['childs'][] = $element;
            }
            else {
                $branch[$id]['childs'][] = $element;
            }
        }
        return array_values($branch);
    }
}