<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Categories;
use Application\Models\Engines;
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

            $dataTable = $this->di->get('DataService', [new Categories()])->hydrate();
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

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $category = (new Categories())->setId($params['id']);

        if ($category->delete() === false) {

            // the store failed, the following message were produced
            foreach ($category->getMessages() as $message) {
                $this->flashSession->error((string)$message);
            }
        } else {
            $this->flashSession->success('The category was successfully deleted!');
            $this->logger->save('Delete category #' . $params['id'] . ' by ' . $this->request->getClientAddress(), 6);
        }

        // forward does not working correctly with this  action type
        // by the way this handle need to remove in another action (
        return
            $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);

    }

    /**
     * Enable category action
     */
    public function enableAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $category = (new Categories())->setId($params['id'])->setVisibility(1);

        if ($category->update() === true) {

            $this->flashSession->success('The category #'.$params['id'].' became visible');

        } else {

            // the store failed, the following message were produced
            foreach ($category->getMessages() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        // forward does not working correctly with this  action type
        // by the way this handle need to remove in another action (
        return
            $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);

    }

    /**
     * Disable category action
     */
    public function disableAction()
    {
        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $category = (new Categories())->setId($params['id'])->setVisibility(0);

        if ($category->update() === true) {

            $this->flashSession->success('The category #'.$params['id'].' became invisible');

        } else {

            // the store failed, the following message were produced
            foreach ($category->getMessages() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        // forward does not working correctly with this  action type
        // by the way this handle need to remove in another action (
        return
            $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
    }

    /**
     * Add category action
     */
    public function addAction() {

        // handling POST data
        if ($this->request->isPost()) {

            $categoriesService = $this->getDI()->get('CategoriesService');

            if($categoriesService->addCategory($this->request->getPost()) === true) {
                $this->flashSession->success('The category was successfully added!');
            }
            else {

                // the store failed, the following message were produced
                foreach($categoriesService->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            // forward does not working correctly with this  action type
            // by the way this handle need to remove in another action (
            return
                $this->response->redirect([
                    'for' => 'dashboard-full',
                    'controller' => $this->router->getControllerName(),
                ]);
        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'categories']))->add('Add');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Add',
                'form' => (new Forms\CategoryForm(null, [
                    'categories' => Categories::find([
                        "columns" => "id, title"
                    ]),
                    'engines'    => Engines::find([
                        "columns" => "id, name"
                    ]),
                ]))
            ]);
        }
    }

    /**
     * Edit category action
     */
    public function editAction() {

        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $category = Categories::findFirst($params['id']);

        // handling POST data
        if ($this->request->isPost()) {

            $category = new Categories();

            if($category->edit($params['id'], $this->request->getPost()) === true) {
                $this->flashSession->success('The category was successfully updated!');
            }
            else {
                // the store failed, the following message were produced
                foreach ($category->getMessages() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            // forward does not working correctly with this  action type
            // by the way this handle need to remove in another action (
            return
                $this->response->redirect([
                    'for' => 'dashboard-full',
                    'controller' => $this->router->getControllerName(),
                ]);

        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'categories']))->add('Edit');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => (new Forms\CategoryForm(null, [
                    'engines'    => Engines::find([
                        "columns" => "id, name"
                    ]),
                    'categories'    => Categories::find([
                        "columns" => "id, title"
                    ]),
                    'default' => $category
                ]))
            ]);
        }
    }

    /**
     * Action for rebuild nested tree
     */
    public function rebuildAction()
    {
        // call rebuild mysql function
        $categories = (new Categories())->rebuildTree();

        if (!$categories instanceof \Phalcon\Mvc\Model\Resultset\Simple) {
            // the store failed, the following message were produced
            foreach ($categories->getMessages() as $message)
                $this->flashSession->error((string)$message);
        } else
            $this->flashSession->success('Categories rebuild success!');

        // forward does not working correctly with this  action type
        // by the way this handle need to remove in another action (
        return
            $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
    }
}