<?php
namespace Application\Modules\Backend\Controllers;

use Models\Categories;
use Models\Engines;
use Modules\Backend\Forms;
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
     * Controller name
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Categories';

    /**
     * Cache key
     * @use for every action
     * @access public
     */
    public $cacheKey = false;


    /**
     * is Json ?
     * @var bool
     */
    private $_isJsonResponse = false;

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        // set json content here
        if ($this->request->getPost('sEcho') != null)
            $this->_isJsonResponse = true;
        else {
            $this->tag->setTitle(' - ' . DashboardController::NAME);

            // create cache key
            $this->cacheKey = md5(\Modules\Backend::MODULE . self::NAME . $this->router->getControllerName() . $this->router->getActionName());

            $this->_breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));
        }
    }

    /**
     * Action for rebuild nested tree
     */
    public function rebuildAction()
    {
        try {

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
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get list of all engines
     * @return null
     */
    public function indexAction()
    {
        if (!$this->_isJsonResponse) {
            $title = ucfirst(self::NAME);
            $this->tag->prependTitle($title);

            // add crumb to chain (name, link)

            $this->_breadcrumbs->add($title);

            $this->view->setVars([
                'title' => $title,
            ]);
        } else {
            // load data to table

            // what kind of content type will be represented ?
            $this->setJsonResponse();

            $categories = (new Categories())->get([
                'iDisplayStart' => $this->request->getPost('iDisplayStart', "int", 0),
                'iDisplayLength' => $this->request->getPost('iDisplayLength', "int", $this->_limitRecords),
                'iSortCol_0' => $this->request->getPost('iSortCol_0', "int", 0),
                'iSortCol_1' => $this->request->getPost('iSortCol_1', "int", 0),
                'iSortCol_2' => $this->request->getPost('iSortCol_2', "int", 0),
                'iSortCol_3' => $this->request->getPost('iSortCol_3', "int", 0),
                'iSortCol_4' => $this->request->getPost('iSortCol_4', "int", 0),
                'iSortingCols' => $this->request->getPost('iSortingCols', "int", 0),
                'bSortable_0' => $this->request->getPost('bSortable_0', null, 0),
                'bSortable_1' => $this->request->getPost('bSortable_1', null, 0),
                'bSortable_2' => $this->request->getPost('bSortable_2', null, 0),
                'bSortable_3' => $this->request->getPost('bSortable_3', null, 0),
                'bSortable_4' => $this->request->getPost('bSortable_4', null, 0),
                'sSortDir_0' => $this->request->getPost('sSortDir_0', null, 'asc'),
                'sSortDir_1' => $this->request->getPost('sSortDir_1', null, 'asc'),
                'sSortDir_2' => $this->request->getPost('sSortDir_2', null, 'asc'),
                'sSortDir_3' => $this->request->getPost('sSortDir_3', null, 'asc'),
                'sSortDir_4' => $this->request->getPost('sSortDir_4', null, 'asc'),
                'sSearch' => $this->request->getPost('sSearch', null, null),
                'sSearch_0' => $this->request->getPost('sSearch_0', "int", 0),
                'sSearch_1' => $this->request->getPost('sSearch_0', "int", 0),
                'sSearch_2' => $this->request->getPost('sSearch_0', "int", 0),
                'sSearch_3' => $this->request->getPost('sSearch_0', "int", 0),
                'sSearch_4' => $this->request->getPost('sSearch_0', "int", 0),
                'bSearchable_0' => $this->request->getPost('bSearchable_0', null, null),
                'bSearchable_1' => $this->request->getPost('bSearchable_1', null, null),
                'bSearchable_2' => $this->request->getPost('bSearchable_2', null, null),
                'bSearchable_3' => $this->request->getPost('bSearchable_3', null, null),
                'bSearchable_4' > $this->request->getPost('bSearchable_4', null, null),

                'sEcho' => $this->request->getPost('sEcho', "int", 1),    //	number of page
            ]);

            $this->response->setJsonContent($categories);
            return $this->response->send();
        }
    }

    /**
     * setJsonResponse() set json mode
     * @access protected
     * @return null
     */
    private function setJsonResponse()
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
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

                $engines = (new Engines())->setId($id);

                if (!$engines->delete()) {
                    // the store failed, the following message were produced
                    foreach ($engines->getMessages() as $message)
                        $this->flashSession->error((string)$message);
                } else // saved successfully
                    $this->flashSession->success('The engine was successfully deleted!');

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
     * Shows the view to create (edit) engine
     */
    public function assignAction()
    {
        $id = $this->dispatcher->getParams()[0];

        // check "edit" or "new" action in use
        $engine = ($id === null) ? new Engines() : Engines::findFirst($id);

        if (!$engine instanceof Engines)
            return $this->response->redirect([
                'for' => 'dashboard-full',
                'controller' => $this->router->getControllerName(),
                'action' => $this->router->getActionName()
            ]);

        try {
            // handling POST data
            if ($this->request->isPost()) {
                $engines =
                    $engine
                        ->setName($this->request->getPost('name'))
                        ->setDescription($this->request->getPost('description'), null, '')
                        ->setHost($this->request->getPost('host'))
                        ->setCode($this->request->getPost('code'))
                        ->setCurrencyId($this->request->getPost('currency_id', null, 1))
                        ->setStatus($this->request->getPost('status', null, 0));

                if (!$engines->save()) {
                    // the store failed, the following message were produced
                    foreach ($engines->getMessages() as $message)
                        $this->flashSession->error((string)$message);

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
                    if (!isset($id))
                        $this->flashSession->success('The engine was successfully added!');
                    else
                        $this->flashSession->success('The engine was successfully updated!');

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
            $title = (!isset($id)) ? 'Add' : 'Edit';
            $this->tag->prependTitle($title . ' - ' . self::NAME);

            // add crumb to chain (name, link)
            $this->_breadcrumbs->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))
                ->add($title);

            // set variables output to view
            $this->view->setVars([
                'title' => $title,
                'form' => (new Forms\EngineForm(null, [
                    'currency' => Currency::find(),
                    'default' => (isset($id)) ? $engine : null
                ]))
            ]);
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
        }
    }
}

