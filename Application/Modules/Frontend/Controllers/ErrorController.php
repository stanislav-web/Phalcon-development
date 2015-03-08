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
     * @var \Phalcon\Di > ErrorService
     */
    private $http;

    /**
     * @var \Phalcon\Di > LogMapper
     */
    private $logger;

    /**
     * Event before route executed
     */
    public function beforeExecuteRoute() {

        $this->config = $this->getDI()->get('config');
        $this->logger = $this->getDi()->get('LogMapper');
        $this->http = $this->getDI()->get('ErrorService');
        $this->view->setViewsDir($this->config['application']['viewsFront']);
    }
    /**
     * Page not found Action
     */
    public function notFoundAction()
    {
        $this->tag->setTitle($this->http->notFoundErrorMessage());

        // The response is already populated with a 404 Not Found header.
        $this->http->setStatus(200, $this->http->notFoundErrorMessage());
        $this->logger->save('404 Page detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress(), \Phalcon\Logger::ERROR);

        // return error as 404

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            return $this->http->setJsonContent($this->http->notFoundErrorMessage(),
                'Contact support please','application/json', 'UTF-8')->send();
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

        $this->tag->setTitle($this->http->internalServerErrorMessage());

        $this->http->setStatus(200, $this->http->internalServerErrorMessage());

        // return error as 500

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            return $this->http->setJsonContent($this->http->internalServerErrorMessage(),
                'Contact support please','application/json', 'UTF-8')->send();
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }
}

