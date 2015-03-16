<?php
namespace Application\Modules;

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Application\Modules\Rest\Exceptions\InternalServerErrorException;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Rest module. Current provide REST API access
 *
 * @package Application
 * @subpackage Modules
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /Application/Modules/Rest.php
 */
class Rest
{
    /**
     * Current module name
     * @var const
     */
    const MODULE = 'Rest';

    /**
     * Try to catch uncatchable error 500
     *
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     */
    public function __construct() {

        $this->catchShutdown();
    }

    /**
     * Register the autoload specific to the current module
     *
     * @access public
     * @return \Phalcon\Loader
     */
    public function registerAutoloaders()
    {
        return true;
    }

    /**
     * Registration services for specific module
     *
     * @param \Phalcon\DI $di
     * @access public
     * @return mixed
     */
    public function registerServices($di)
    {
        // Dispatch register
        $di->set('dispatcher', function () use ($di) {

            $eventsManager = $di->getShared('eventsManager');

            // event before exception
            $eventsManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception) {

                if ($exception instanceof DispatcherException) {

                    try {
                        throw new NotFoundException();
                    }
                    catch(RestException $e) {
                        $response = new Response();

                        $response->setContentType('application/json', 'utf-8')
                            ->setStatusCode($e->getCode(), $e->getMessage())
                            ->setJsonContent(['code' => $e->getCode(), 'message' => $e->getMessage()])->send();
                        return $event->isStopped();
                    }
                }
            }, 150);

            //event before dispatch loop
            $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {

                $keyParams = array();
                $params = $dispatcher->getParams();

                // use odd parameters as keys and even as values
                foreach ($params as $number => $value) {
                    if ($number & 1) {
                        $keyParams[$params[$number - 1]] = $value;
                    }
                }

                //Override parameters
                $dispatcher->setParams($keyParams);
            }, 100);

            $dispatcher = new \Phalcon\Mvc\Dispatcher();

            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Application\Modules\\' . self::MODULE . '\Controllers');
            $dispatcher->setDefaultAction('index');
            return $dispatcher;
        }, true);

        // Registration of component representations (Views)

        $di->set('view', function () {
            $view = new View();

            // view component disabled for this module
            $view->disable();
            return $view;
        });

        require_once APP_PATH . '/Modules/' . self::MODULE . '/config/services.php';

    }

    /**
     * Shutdown application while uncatchable error founded
     *
     * @throws \Application\Modules\Rest\Exceptions\InternalServerErrorException
     * @uses \Phalcon\DI
     * @return callable register_shutdown_function()
     */
    public function catchShutdown() {

        return register_shutdown_function(function() {
            $error = error_get_last();
            if(is_null($error) === false) {

                DI::getDefault()->get('LogMapper')->save($error['message'].' File: '.$error['file'].' Line:'.$error['line'],1);

                try {

                    throw new InternalServerErrorException();
                }
                catch(\RuntimeException $e) {

                    $response = new Response();

                    return $response->resetHeaders()->setContentType('application/json', 'utf-8')
                        ->setStatusCode($e->getCode(), $e->getMessage())

                        ->setJsonContent(['code' => $e->getCode(), 'message' => $e->getMessage()])->send();

                }
            }
        });
    }

}