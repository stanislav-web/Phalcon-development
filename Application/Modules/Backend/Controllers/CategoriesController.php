<?php
namespace Application\Modules\Backend\Controllers;

use Application\Modules\Backend\Forms;
use Phalcon\Mvc\View;

/**
 * Class CategoriesController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/CategoriesController.php
 */
class CategoriesController extends ControllerBase
{
    /**
     * @const Basic virtual dir name
     */
    const NAME = 'Categories';

    /**
     * Initialize constructor
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Get list of all categories action
     */
    public function indexAction()
    {
        $this->setBreadcrumbs()->add(self::NAME);

        if ($this->request->isPost()) {

            $categories = $this->getDI()->get('CategoriesService');

            $dataTable = $this->getDI()->get('DataService', [$categories->getInstance()])->hydrate();
            $dataTable->jsonFromObject();

            return;
        }
    }

    /**
     * Delete category action
     */
    public function deleteAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        $category = $this->getDI()->get('CategoriesService');

        if($category->delete($params['id']) === true) {
            $this->flashSession->success('The category #' . $params['id'] . ' was successfully deleted');
        }
        else {

            // the store failed, the following message were produced
            foreach($category->getErrors() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        return $this->forward();

    }

    /**
     * Enable category action
     */
    public function enableAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        $category = $this->getDI()->get('CategoriesService');

        if($category->setVisible($params['id']) === true) {
            $this->flashSession->success('The category #'.$params['id'].' became visible');
        }
        else {

            // the store failed, the following message were produced
            foreach($category->getErrors() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        return $this->forward();
    }

    /**
     * Disable category action
     */
    public function disableAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        $category = $this->getDI()->get('CategoriesService');

        if($category->setInvisible($params['id']) === true) {
            $this->flashSession->success('The category #'.$params['id'].' became invisible');
        }
        else {

            // the store failed, the following message were produced
            foreach($category->getErrors() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        return $this->forward();
    }

    /**
     * Add category action
     */
    public function addAction() {

        $category = $this->getDI()->get('CategoriesService');

        // handling POST data
        if ($this->request->isPost()) {

            if($category->create($this->request->getPost()) === true) {
                $this->flashSession->success('The category was successfully added!');
            }
            else {

                // the store failed, the following message were produced
                foreach($category->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'categories']))->add('Add');
            $engines = $this->getDI()->get('EngineService');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Add',
                'form' => new Forms\CategoryForm(null, [
                    'categories' => $category->read(null, [
                        "columns" => "id, title"
                    ]),
                    'engines'    => $engines->getListByParams([
                        "columns" => "id, name"
                    ]),
                ])
            ]);
        }
    }

    /**
     * Edit category action
     */
    public function editAction() {

        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->forward();
        }
        $category = $this->getDI()->get('CategoriesService');

        // handling POST data
        if ($this->request->isPost()) {

            if($category->update($params['id'], $this->request->getPost()) === true) {
                $this->flashSession->success('The category was successfully updated!');
            }
            else {

                // the store failed, the following message were produced
                foreach($category->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();

        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'categories']))->add('Edit');
            $engines = $this->getDI()->get('EngineService');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => new Forms\CategoryForm(null, [
                    'engines'    => $engines->getListByParams([
                        "columns" => "id, name"
                    ]),
                    'categories'    => $category->read(null, [
                        "columns" => "id, title"
                    ]),
                    'default' => $category->read($params['id'])
                ])
            ]);
        }
    }

    /**
     * Action for rebuild nested tree
     */
    public function rebuildAction()
    {
        $categories = $this->getDI()->get('CategoriesService');

        if($categories->rebuildTree() === true) {

            $this->flashSession->success('Categories rebuild success!');
        }
        else {
            // the store failed, the following message were produced
            $this->flashSession->error('Categories rebuild failed!');
        }

        return $this->forward();
    }
}