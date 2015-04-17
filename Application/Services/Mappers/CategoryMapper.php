<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Categories;

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
     * Create category
     *
     * @param array $data
     * @throws DbException
     */
    public function create(array $data) {

        // Request a transaction
        $transaction = $this->transactionManager()->get();
        $categoryModel = new Categories();
        $categoryModel->setTransaction($transaction);

        try {

            foreach($data as $field => $value) {

                $categoryModel->{$field}   =   $value;
            }

            if($categoryModel->save() === true) {

                foreach($data['engine_id'] as $i => $engine_id) {

                    $isSet = (new EnginesCategoriesRel())
                        ->setCategoryId($categoryModel->getId())
                        ->setEngineId($engine_id);

                    $isSet->setTransaction($transaction);

                    if($isSet->save() === false) {

                        $this->setErrors($isSet->getMessages());
                        $transaction->rollback();

                        return false;
                    }
                }

                $transaction->commit();

                return true;
            }
            else {
                $this->setErrors($categoryModel->getMessages());
                $transaction->rollback();
                return false;
            }
        }
        catch(TransactionException $e) {

            $this->setErrors($e->getMessage());
            throw new DbException($e->getMessage());
        }
    }



    /**
     * Update category
     *
     * @param int      $category_id
     * @param array $data
     * @throws DbException
     */
    public function update($category_id, array $data) {

        // Request a transaction
        $transaction = $this->transactionManager()->get();
        $categoryModel = new Categories();
        $categoryModel->setTransaction($transaction);

        try {

            $categoryModel->setId($category_id);

            foreach($data as $field => $value) {

                $categoryModel->{$field}   =   $value;
            }

            if($categoryModel->save() === true) {

                // remove all relative records
                $isDeleted = $this->deleteRelationCategories(new EnginesCategoriesRel(), $category_id);

                if($isDeleted === true) {

                    foreach($data['engine_id'] as $i => $engine_id) {

                        $isSet = (new EnginesCategoriesRel())->setCategoryId($category_id)->setEngineId($engine_id);

                        if($isSet->save() === false) {

                            $this->setErrors($isSet->getMessages());
                            $transaction->rollback();

                            return false;
                        }
                    }
                    $transaction->commit();

                    return true;
                }
                else {
                    $this->setErrors($categoryModel->getMessages());
                    $transaction->rollback();

                    return false;
                }
            }
            else {
                $this->setErrors($categoryModel->getMessages());
                $transaction->rollback();

                return false;
            }
        }
        catch(TransactionException $e) {

            $this->setErrors($e->getMessage());
            throw new DbException($e->getMessage());
        }
    }

    /**
     * Delete category
     *
     * @param int      $category_id
     * @return boolean
     */
    public function delete($category_id) {

        $categoryModel = new Categories();

        return $categoryModel->getReadConnection()
            ->delete($categoryModel->getSource(), "id = ".(int)$category_id);
    }

    /**
     * Set errors message
     *
     * @param mixed $errors
     */
    public function setErrors($errors) {
        $this->errors = $errors;
    }

    /**
     * Get error messages
     *
     * @return mixed $errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Set category visible
     *
     * @param int      $category_id
     * @return boolean
     */
    public function setVisible($category_id) {

        $categoryModel = new Categories();

        return $categoryModel->getReadConnection()
            ->update($categoryModel->getSource(), ['visibility'], [1], "id = ".(int)$category_id);
    }

    /**
     * Set category invisible
     *
     * @param int      $category_id
     * @return boolean
     */
    public function setInvisible($category_id) {

        $categoryModel = new Categories();

        return $categoryModel->getReadConnection()
            ->update($categoryModel->getSource(), ['visibility'], [0], "id = ".(int)$category_id);
    }

    /**
     * Get category by Id
     *
     * @param int $id
     * @return \Phalcon\Mvc\Model
     */
    public function getOne($id)
    {
        return Categories::findFirst($id);
    }

    /**
     * Get categories by condition
     *
     * @param array $params
     * @return \Phalcon\Mvc\Model
     */
    public function getList(array $params = [])
    {
        return Categories::find($params);
    }

    /**
     * Get transaction manager
     *
     * @return \Phalcon\Mvc\Model\Transaction\Manager
     */
    private function transactionManager() {

        return $this->getDI()->get('transactions');
    }

    /**
     * Delete relation categories
     *
     * @param EnginesCategoriesRel $model
     * @param                      $category_id
     * @return boolean
     * @throws DbException
     */
    private function deleteRelationCategories(\Application\Models\EnginesCategoriesRel $model, $category_id) {

        return $model->getReadConnection()
            ->delete($model->getSource(), "category_id = ".(int)$category_id);
    }

    /**
     * Rebuild tree after success update or insert
     *
     * @return bool
     * @throws \Phalcon\Mvc\Model\Exception
     */
    public function rebuildTree() {

        // call rebuild mysql function
        $categoryModel = new Categories();
        $rebuild = $categoryModel->rebuildTree();

        if ($rebuild instanceof \Phalcon\Mvc\Model\Resultset\Simple) {

            return true;
        }
        return false;
    }
}