<?php
namespace Application\Modules\Frontend\Controllers;

/**
 * Class CatalogueController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/CatalogueController.php
 */
class CatalogueController extends ControllerBase
{
    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Home action
     */
    public function indexAction()
    {
        $this->view->disable();

        if($this->request->isGet() === true) {

            // get data from Model by action

            $this->response->setJsonContent([
                'data' => 'test'
            ]);
            $this->response->setStatusCode(200, "OK");
            $this->response->send();
        }
        else {
            $this->response->setStatusCode(404, "Not Found");
        }
    }
}

