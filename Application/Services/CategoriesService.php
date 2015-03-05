<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
use Application\Models\Categories;
use Application\Models\EnginesCategoriesRel;
use Phalcon\Db\Exception as DbException;
use Phalcon\Mvc\Model\Transaction\Failed as TransactionException;

/**
 * Class CategoriesService. Actions above application categories
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/CategoriesService.php
 */
class CategoriesService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    private $di;

    /**
     * Errors array
     *
     * @var array $errors;
     */
    private $errors = [];

    /**
     * Category model instance
     *
     * @var \Application\Models\Categories $categoryModel;
     */
    private $categoryModel;

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Add category
     *
     * @param array $data
     * @throws DbException
     */
    public function addCategory(array $data) {

        // Request a transaction
        $transaction = $this->transactionManager()->get();
        $this->categoryModel = new Categories();
        $this->categoryModel->setTransaction($transaction);

        try {

            foreach($data as $field => $value) {

                $this->categoryModel->{$field}   =   $value;
            }

            if($this->categoryModel->save() === true) {

                foreach($data['engine_id'] as $i => $engine_id) {

                    $isSet = (new EnginesCategoriesRel())
                        ->setCategoryId($this->categoryModel->getId())
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
                $this->setErrors($this->categoryModel->getMessages());
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
     * Edit category
     *
     * @param int      $category_id
     * @param array $data
     * @throws DbException
     */
    public function editCategory($category_id, array $data) {

        // Request a transaction
        $transaction = $this->transactionManager()->get();
        $this->categoryModel = new Categories();
        $this->categoryModel->setTransaction($transaction);

        try {

            $this->categoryModel->setId($category_id);

            foreach($data as $field => $value) {

                $this->categoryModel->{$field}   =   $value;
            }

            if($this->categoryModel->save() === true) {

                // remove all relative records
                $isDeleted = $this->categoryModel->deleteRelationCategories(new EnginesCategoriesRel(), $category_id);

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
                    $this->setErrors($this->categoryModel->getMessages());
                    $transaction->rollback();

                    return false;
                }
            }
            else {
                $this->setErrors($this->categoryModel->getMessages());
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
     * Set errors message
     *
     * @param mixed $errors
     */
    private function setErrors($errors) {
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
     * Get transaction manager
     *
     * @return \Phalcon\Mvc\Model\Transaction\Manager
     */
    protected function transactionManager() {

        return $this->getDI()->get('transactions');
    }
}