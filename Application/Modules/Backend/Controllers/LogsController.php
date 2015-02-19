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
    }

    /**
     * Get list of all pages
     *
     * @return null
     */
    public function indexAction()
    {
        // get records
        //$dataTable = $this->di->get('DataService', [new Logs(), 0, 10])->hydrate();
        //$rows = $dataTable->jsonFromObject();

        //$rows = $dataTable->jsonFromObject();

        if ($this->request->isPost()) {
            // what kind of content type will be represented ?
        }
    }
}

