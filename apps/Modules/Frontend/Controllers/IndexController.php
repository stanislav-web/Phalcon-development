<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;

/**
 * Class IndexController
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/IndexController.php
 */
class IndexController extends ControllerBase
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

    /**
     * Contacts,About,Agreement,Help action
     * Static pages
     */
    public function staticAction()
    {

        // get page to display - param
        $param = $this->dispatcher->getParam('page');

        $this->tag->prependTitle(ucfirst($param).' - ');
        $this->view->setVars(['page', strtolower($param)]);

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent([

                'title'     => ucfirst($param).' - '.$this->engine->getName(),
                'content'   => $this->view->getRender('', 'index/static', ['page' => strtolower($param)]),
            ]);

            $this->response->setStatusCode(200, "OK");
            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
    }
}

