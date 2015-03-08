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

        $page = $this->getDI()->get('PageMapper');

        $this->view->setVars([
            'items' => $page->read()
        ]);
    }

    /**
     * Add page action
     */
    public function addAction() {

        // handling POST data
        if ($this->request->isPost()) {

            $page = $this->getDI()->get('PageMapper');

            if($page->create($this->request->getPost()) === true) {
                $this->flashSession->success('The page was successfully added!');
            }
            else {

                // the store failed, the following message were produced
                foreach($page->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
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
        $page = $this->getDI()->get('PageMapper');

        if (isset($params['id']) === false) {

            return $this->forward();
        }

        if ($this->request->isPost()) {

            if($page->update($params['id'], $this->request->getPost()) === true) {
                $this->flashSession->success('The page was successfully modified!');
            }
            else {

                // the store failed, the following message were produced
                foreach($page->getErrors() as $message) {
                    $this->flashSession->error((string)$message);
                }
            }

            return $this->forward();
        }
        else {

            // add crumb to chain (name, link)
            $this->setBreadcrumbs()->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'pages']))->add('Edit');

            // set variables output to view
            $this->view->setVars([
                'title' => 'Edit',
                'form' => (new Forms\PageForm(null, [
                    'default' => $page->read($params['id']),
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

            return $this->forward();
        }

        $page = $this->getDI()->get('PageMapper');

        if($page->delete($params['id']) === true) {
            $this->flashSession->success('The page #'.$params['id'].' was successfully deleted');
        }
        else {

            // the store failed, the following message were produced
            foreach($page->getErrors() as $message) {
                $this->flashSession->error((string)$message);
            }
        }

        return $this->forward();

    }
}