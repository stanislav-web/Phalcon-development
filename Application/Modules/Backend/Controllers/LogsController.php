<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Logs;
use Phalcon\Mvc\View;

/**
 * Class LogsController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/LogsController.php
 */
class LogsController extends ControllerBase
{


    /**
     * initialize() Initialize constructor
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();


        // create cache key
        //$this->cacheKey = md5($this->dispatcher->getModuleName() . $this->dispatcher->getControllerName() . $this->dispatcher->getActionName());

        $this->breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));

    }

    /**
     * Get list of all pages
     *
     * @return null
     */
    public function indexAction()
    {


        // add crumb to chain (name, link)


        //$this->breadcrumbs->add($title);
        $this->view->setVars([
            'title' => 'sdsd',
        ]);

        // get records

        //$dataTable = $this->di->get('DataService', [new Logs(), 0, 10])->hydrate();

        //$rows = $dataTable->jsonFromObject();

        if ($this->request->isPost()) {
            // what kind of content type will be represented ?
            $this->setJsonResponse();

            // get records

                $dataTable = $this->di->get('DataService', [new Logs(), 0, 10])->hydrate();

                $rows = $dataTable->jsonFromObject();

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
}

