<?php
namespace Application\Modules\Frontend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class ErrorController
 *
 * @package    Application\Modules\Frontend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Frontend/Controllers/ErrorController.php
 */
class ErrorController extends \Phalcon\Mvc\Controller
{
    /**
     * @var \Phalcon\Di > Config
     */
    private $config;

    /**
     * @var \Phalcon\Di > ErrorHttpService
     */
    private $errorHttpService;

    /**
     * initialize() Initial all global objects
     * @access public
     * @return null
     */
    public function initialize() {

        $this->config = $this->di->get('config');
        $this->errorHttpService = $this->di->get('ErrorHttpService');

        $this->view->setViewsDir($this->config['application']['viewsFront']);

    }
    /**
     * Page not found Action
     */
    public function notFoundAction()
    {
        $this->tag->setTitle("Not Found");


        // The response is already populated with a 404 Not Found header.
        $this->errorHttpService->setStatus(404, "Not Found");
        $this->errorHttpService->log(
            '404 Page detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress()
        );

        // return error as 404

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);
            $this->errorHttpService->setJsonContent([
                'content'   => $this->view->getRender('', 'error/notFound', []),
            ]);

            $this->errorHttpService->setStatusCode(200, "OK");
            $this->errorHttpService->setContentType('application/json', 'UTF-8');

            return $this->errorHttpService->send();
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

        $this->errorHttpService->setStatus(500, 'Internal Server Error');
        $this->errorHttpService->log('500 Internal Server Error detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress());

        $this->tag->setTitle("Internal Server Error");

        // return error as 500

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            $this->errorHttpService->setJsonContent([
                'content'   => $this->view->getRender('', 'error/uncaughtException', []),
            ]);
            $this->errorHttpService->setStatusCode(200, "OK");
            $this->errorHttpService->setContentType('application/json', 'UTF-8');

            return $this->errorHttpService->send();
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }
}

