<?php
namespace Modules\Frontend\Controllers;

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
     * Page not found Action
     */
    public function notFoundAction()
    {
        // The response is already populated with a 404 Not Found header.
        $this->response->setStatusCode(404, "Not Found");

        $config = $this->di->get('config');

        if ($config->logger->enable === true) {
            $this->di->get('logger')->error('404 Page detected: ' .$this->request->getServer('REQUEST_URI').' from IP: '.$this->request->getClientAddress());
        }
    }

    /**
     * Undefined error action
     */
    public function uncaughtExceptionAction()
    {
        // You need to specify the response header, as it's not automatically set here.
        $this->response->setStatusCode(500, 'Internal Server Error');
    }

}

