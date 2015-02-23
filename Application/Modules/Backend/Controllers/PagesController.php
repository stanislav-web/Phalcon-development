<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Pages;
use Application\Modules\Backend\Forms;
use Phalcon\Mvc\View;

/**
 * Class PagesController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/PagesController.php
 */
class PagesController extends ControllerBase
{
    /**
     * @const Basic virtual dir name
     */
    const NAME = 'Pages';

    /**
     * Initialize constructor
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Get list of all engines
     */
    public function indexAction() {
        $this->setBreadcrumbs()->add(self::NAME);

        $pages = Pages::find();

        $this->view->setVars([
            'items' => $pages
        ]);
    }

    /**
     * Add page action
     */
    public function addAction() {

        // handling POST data
        if ($this->request->isPost()) {

            $page =
                (new Pages())
                    ->setTitle($this->request->getPost('title'))
                    ->setContent($this->request->getPost('content'), null, '')
                    ->setAlias($this->request->getPost('alias'));

            if($page->save() === true) {

                $this->flashSession->success('The page was successfully added!');
                $this->logger->save('Page `' . $page->getTitle() . '` assigned by ' . $this->request->getClientAddress(), 6);
                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                    ]);
            }
            else {

                // the store failed, the following message were produced
                foreach ($page->getMessages() as $message)
                    $this->flashSession->error((string)$message);

                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                        'action' => $this->router->getActionName()
                    ]);
            }
        }
        else {
            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'pages']))->add('Add');

            // set variables output to view

            $this->view->setVars([
                'title' => 'Add',
                'form' => (new Forms\PageForm(null, [
                    'default' => null,
                ]))
            ]);
        }
    }

    /**
     * Edit page action
     */
    public function editAction() {

        $params = $this->dispatcher->getParams();

        if (isset($params['id']) === false) {

            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);
        }

        $page = Pages::findFirst($params['id']);

        if ($this->request->isPost()) {

            $page =
                (new Pages())
                    ->setId($params['id'])
                    ->setTitle($this->request->getPost('title'))
                    ->setContent($this->request->getPost('content'), null, '')
                    ->setAlias($this->request->getPost('alias'));

            if($page->update() === true) {

                $this->flashSession->success('The page was successfully modified!');
                $this->logger->save('Page `' . $page->getTitle() . '` modified by ' . $this->request->getClientAddress(), 6);
                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                    ]);
            }
            else {

                // the store failed, the following message were produced
                foreach ($page->getMessages() as $message)
                    $this->flashSession->error((string)$message);

                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                        'action' => $this->router->getActionName()
                    ]);
            }
        }
        else {

            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'pages']))->add('Edit');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => (new Forms\PageForm(null, [
                    'default' => $page
                ]))
            ]);
        }
    }

    /**
     * Delete action
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

        $pages = (new Pages())->setId($params['id']);

        if ($pages->delete() === false) {

            // the store failed, the following message were produced
            foreach ($pages->getMessages() as $message) {
                $this->flashSession->error((string)$message);
            }
        } else {
            $this->flashSession->success('The page was successfully deleted!');
            $this->logger->save('Delete page #' . $params['id'] . ' by ' . $this->request->getClientAddress(), 6);
        }


        // forward does not working correctly with this  action type
        // by the way this handle need to remove in another action (
        return
            $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
            ]);

    }
}