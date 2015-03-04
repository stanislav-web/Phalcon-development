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
     * EnginesCategoriesRel relation model to category
     *
     * @var \Application\Models\EnginesCategoriesRel $relModel;
     */
    protected $relModel;

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
     */
    public function addCategory(array $data) {

        $this->categoryModel = new Categories();
        $this->relModel = new EnginesCategoriesRel();

        try {

            // begin transaction
            $transaction = $this->transactionManager()->get(true);

            foreach($data as $field => $value) {

                $this->categoryModel->{$field}   =   $value;
            }
            // setup transaction
            $this->categoryModel->setTransaction($transaction);

            if($this->categoryModel->save() === true) {

                foreach($data['engine_id'] as $i => $engine_id) {

                    $this->relModel
                        ->setCategoryId($this->categoryModel->getId())
                        ->setEngineId($engine_id);

                    if($this->relModel->update() === false) {
                        $this->setErrors($this->relModel->getMessages());
                        $transaction->rollback();
                    }
                }
                $transaction->commit();

                return true;
            }
            else {
                $this->setErrors($this->categoryModel->getMessages());
                $transaction->rollback();
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