<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;

/**
 * Class SignController
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/SignController.php
 */
class SignController extends ControllerBase
{

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        // add java scripts minified

        $this->assets->collection('footer-js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/controllers/'.$this->router->getControllerName().'.js');

    }

    /**
     * Home action
     */
    public function indexAction()
    {
        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent([
                'title'     => $this->engine->getName(),
                'content'   => $this->view->getRender('', 'index/index', []),
            ]);

            $this->response->setStatusCode(200, "OK");
            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
    }
}

