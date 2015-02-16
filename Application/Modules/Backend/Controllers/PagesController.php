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
     * Controller name
     *
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Pages';

    /**
     * Cache key
     *
     * @use for every action
     * @access public
     */
    public $cacheKey = false;

    /**
     * initialize() Initialize constructor
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle(' - ' . DashboardController::NAME);

        // create cache key
        $this->cacheKey = md5(\Application\Modules\Backend::MODULE . self::NAME . $this->router->getControllerName() . $this->router->getActionName());

        $this->breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));
    }

    /**
     * Get list of all pages
     *
     * @return null
     */
    public function indexAction()
    {
        $title = ucfirst(self::NAME);
        $this->tag->prependTitle($title);

        // add crumb to chain (name, link)

        $this->breadcrumbs->add($title);

        // get all records

        $pages = Pages::find();

        $this->view->setVars([
            'items' => $pages,
            'title' => $title,
        ]);
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        try {

            // handling POST data
            if ($this->request->isGet()) {

                $id = $this->dispatcher->getParams()[0];

                $page = (new Pages())->setId($id);

                if (!$page->delete()) {

                    // the store failed, the following message were produced
                    foreach ($page->getMessages() as $message) {
                        $this->flashSession->error((string)$message);
                    }

                } else {
                    // saved successfully
                    $this->flashSession->success('The page was successfully deleted!');
                }

                if ($this->_logger) {
                    $this->_logger->log('Delete page #' . $id . ' by ' . $this->request->getClientAddress());
                }

                // forward does not working correctly with this  action type
                // by the way this handle need to remove in another action (
                return
                    $this->response->redirect([
                        'for' => 'dashboard-full',
                        'controller' => $this->router->getControllerName(),
                    ]);
            }
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Shows the view to create (edit) page
     */
    public function assignAction()
    {
        $id = $this->dispatcher->getParams();

        // check "edit" or "new" action in use
        $page = (empty($id) === true) ? new Pages() : Pages::findFirst($id[0]);

        if (!$page instanceof Pages)
            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
                'action' => $this->router->getActionName()
            ]);


        try {

            // handling POST data
            if ($this->request->isPost()) {

                $pages =
                    $page
                        ->setTitle($this->request->getPost('title'))
                        ->setContent($this->request->getPost('content'), null, '')
                        ->setAlias($this->request->getPost('alias'));

                if ($pages->save() === false) {

                    // the store failed, the following message were produced
                    foreach ($pages->getMessages() as $message) {
                        $this->flashSession->error((string)$message);
                    }

                    // forward does not working correctly with this  action type
                    // by the way this handle need to remove in another action (
                    return
                        $this->response->redirect([
                            'for' => 'dashboard-full',
                            'controller' => $this->router->getControllerName(),
                            'action' => $this->router->getActionName()
                        ]);
                } else {

                    // saved successfully
                    if (empty($id) === true) {
                        $this->flashSession->success('The page was successfully added!');
                    }
                    else {
                        $this->flashSession->success('The page was successfully updated!');
                    }

                    if ($this->_logger) {
                        $this->_logger->log('Page assigned by ' . $this->request->getClientAddress());
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

            // build meta data
            $title = (empty($id) === true) ? 'Add' : 'Edit';
            $this->tag->prependTitle($title . ' - ' . self::NAME);

            // add crumb to chain (name, link)
            $this->breadcrumbs->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'pages']))
                ->add($title);

            // set variables output to view
            $this->view->setVars([
                'title' => $title,
                'form' => (new Forms\PageForm(null, [
                    'default' => (empty($id) === true) ? null : $page
                ]))
            ]);
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }
}

