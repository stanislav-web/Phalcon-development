<?php
namespace Modules;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Frontend module
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
            'Modules\Backend\Controllers' => APP_PATH.'/Modules/Backend/Controllers/',
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
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Modules\Backend\Controllers');
            return $dispatcher;
        });

        // Registration of component representations
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir(APP_PATH.'/Modules/Backend/views/');
            return $view;
        });
    }

}