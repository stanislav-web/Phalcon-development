<?php
namespace Modules\Frontend\Controllers;

class ErrorController extends \Phalcon\Mvc\Controller
{

    public function notFoundAction()
    {
        // The response is already populated with a 404 Not Found header.
    }

    public function uncaughtExceptionAction()
    {
        // You need to specify the response header, as it's not automatically set here.
        $this->response->setStatusCode(500, 'Internal Server Error');
    }

}

