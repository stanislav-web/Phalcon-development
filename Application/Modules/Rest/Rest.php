<?php
namespace Application\Modules;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Application\Modules\Rest\Plugins\Dispatcher\NotFoundExceptionPlugin;
use Application\Modules\Rest\Plugins\Dispatcher\InternalServerExceptionPlugin;

/**
 * Rest module
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
        (new InternalServerExceptionPlugin())->shutdown();
    }

    /**
     * Register the autoloader specific to the current module
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
            $eventsManager->attach('dispatch:beforeException', new NotFoundExceptionPlugin(), 150);

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

}