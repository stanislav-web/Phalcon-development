<?php
namespace Application\Modules;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

/**
 * Backend module
 *
 * @package Application
 * @subpackage Modules
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Frontend.php
 */
class Backend
{
    /**
     * Current module name
     * @var const
     */
    const MODULE = 'Backend';

    /**
     * Global config
     *
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * Configuration init
     */
    public function __construct()
    {
        $this->config = \Phalcon\DI::getDefault()->get('config');
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

            // call event manager
            $eventsManager = $di->getShared('eventsManager');

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
            });

            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Application\Modules\\' . self::MODULE . '\Controllers');
            return $dispatcher;

        }, true);

        // Registration of component representations (Views)

        $di->setShared('view', function () {
            $view = new View();
            $view->setViewsDir($this->config['application']['viewsBack'])
                ->setMainView('auth-layout')
                ->setPartialsDir('partials');
            return $view;
        });

        require_once APP_PATH . '/Modules/' . self::MODULE . '/config/services.php';

        if (APPLICATION_ENV === 'development') {

            // share develop sidebar
            (new \Application\Plugins\Debugger\Develop($di));

            // share Fabfuel topbar
            $profiler = new \Fabfuel\Prophiler\Profiler();
            $di->setShared('profiler', $profiler);

            $pluginManager = new \Fabfuel\Prophiler\Plugin\Manager\Phalcon($profiler);
            $pluginManager->register();

        }
    }
}
