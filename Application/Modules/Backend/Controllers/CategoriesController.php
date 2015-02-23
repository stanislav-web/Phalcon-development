<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Categories;
use Application\Models\Engines;
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
     * Get list of all categories
     */
    public function indexAction()
    {
        if ($this->request->isPost()) {
            // what kind of content type will be represented ?
            $dataTable = $this->di->get('DataService', [new Categories()])->hydrate();
            $dataTable->jsonFromObject();
            return;
        }
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {

    }

    /**
     * Shows the view to create (edit) engine
     */
    public function assignAction()
    {

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

