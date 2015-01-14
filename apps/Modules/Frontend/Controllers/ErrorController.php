<?php
namespace Modules\Frontend\Controllers;
use Phalcon\Mvc\View;

/**
 * Class ErrorController
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/ErrorController.php
 */
class ErrorController extends \Phalcon\Mvc\Controller
{

    /**
     * @var \Phalcon\Di > Config
     */
    public $config;

    /**
     * initialize() Initial all global objects
     * @access public
     * @return null
     */
    public function initialize() {

        $this->config = $this->di->get('config');

        $this->view->setViewsDir($this->config['application']['viewsFront']);

    }
    /**
     * Page not found Action
     */
    public function notFoundAction()
    {

        // The response is already populated with a 404 Not Found header.
        $this->response->setStatusCode(404, "Not Found");

        $this->tag->setTitle("Not Found");

        if ($this->config->logger->enable === true) {
            $this->di->get('logger')->error('404 Page detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress());
        }

        // return error as 404

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent([
                'content'   => $this->view->getRender('', 'error/notFound', []),
            ]);
            $this->response->setStatusCode(200, "OK");

            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
        else {

            // render the view
            $this->view->pick('error/notFound');

        }
    }

    /**
     * Undefined error action
     */
    public function uncaughtExceptionAction()
    {
        // You need to specify the response header, as it's not automatically set here.
        $this->response->setStatusCode(500, 'Internal Server Error');
        $this->tag->setTitle("Internal Server Error");

        if ($this->config->logger->enable === true) {
            $this->di->get('logger')->error('500 Internal Server Error detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress());
        }

        // return error as 500

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->response->setJsonContent([
                'content'   => $this->view->getRender('', 'error/uncaughtException', []),
            ]);
            $this->response->setStatusCode(200, "OK");

            $this->response->setContentType('application/json', 'UTF-8');

            return $this->response->send();
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }
}

