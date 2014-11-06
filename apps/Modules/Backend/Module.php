<?php
namespace Modules;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Backend module
 * @package Phalcon
 * @subpackage Frontend
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Modules/Module.php
 */
class Backend implements ModuleDefinitionInterface
{

    /**
     * Register the autoloader specific to the current module
     * @access public
     * @return \Phalcon\Loader\Loader()
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces([
            'Modules\Backend\Controllers'   =>  APP_PATH.'/Modules/Backend/Controllers/',
            'Modules\Backend\Plugins'       =>  APP_PATH.'/Modules/Backend/Plugins/',
        ]);

        $loader->register();
    }

    /**
     * Registration services for specific module
     * @param \Phalcon\DI $di
     * @access public
     * @return mixed
     */
    public function registerServices($di)
    {
        // Dispatch register
        $di->set('dispatcher', function() use ($di) {

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Modules\Backend\Controllers');
            $dispatcher->setDefaultController('Admin');
            $dispatcher->setDefaultAction('index');
            return $dispatcher;
        });

        // Registration of component representations (Views)

        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir(APP_PATH.'/Modules/Backend/views/');
            return $view;
        });

        return require_once APP_PATH.'/Modules/Backend/config/services.php';
    }

}