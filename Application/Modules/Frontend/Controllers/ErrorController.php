<?php
namespace Application\Modules\Frontend\Controllers;

use Application\Services\ErrorHttpService;
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
     * Event before route executed
     */
    public function beforeExecuteRoute() {

        $this->config = $this->di->get('config');
        $this->errorHttpService = $this->di->get('ErrorHttpService');
        $this->view->setViewsDir($this->config['application']['viewsFront']);
    }
    /**
     * Page not found Action
     */
    public function notFoundAction()
    {
        $this->tag->setTitle(ErrorHttpService::NOT_FOUND_MESSAGE);

        // The response is already populated with a 404 Not Found header.
        $this->errorHttpService->setStatus(ErrorHttpService::NOT_FOUND_CODE, ErrorHttpService::NOT_FOUND_MESSAGE);
        $this->errorHttpService->log(
            '404 Page detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress()
        );

        // return error as 404

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            return $this->errorHttpService->setJsonContent(ErrorHttpService::NOT_FOUND_MESSAGE,
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

        $this->tag->setTitle(ErrorHttpService::UNCAUGHT_EXCEPTION_MESSAGE);

        $this->errorHttpService->setStatus(ErrorHttpService::UNCAUGHT_EXCEPTION_CODE, ErrorHttpService::UNCAUGHT_EXCEPTION_MESSAGE);

        // return error as 500

        if($this->request->isAjax() === true) {

            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            return $this->errorHttpService->setJsonContent(ErrorHttpService::UNCAUGHT_EXCEPTION_MESSAGE,
                'Contact support please','application/json', 'UTF-8')->send();
        }
        else {

            // render the view
            $this->view->pick('error/uncaughtException');

        }
    }
}

