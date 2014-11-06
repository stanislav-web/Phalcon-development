<?php
namespace Modules;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;;

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
class Frontend implements ModuleDefinitionInterface
{
    /**
     * Global config
     * @var bool | array
     */
    protected $_config = false;

    /**
     * Configuration init
     */
    public function __construct() {

        $this->_config = \Phalcon\DI::getDefault()->get('config');
    }

    /**
     * Register the autoloader specific to the current module
     * @access public
     * @return \Phalcon\Loader\Loader()
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces([
            'Modules\Frontend\Controllers'  => APP_PATH.'/Modules/Frontend/Controllers/',
            'Modules\Frontend\Plugins'      => APP_PATH.'/Modules/Frontend/Plugins/',
        ])
        ->registerDirs([
            $this->_config->application->libraryDir,
            $this->_config->application->modelsDir
        ]);

        $loader->register();

        // Stand up profiler
        //if(isset($this->_config->database->profiler))
        //    (new \DebugWidget(\Phalcon\Di::getDefault()));
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
            $eventsManager = $di->getShared('eventsManager');
            $eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward([
                            'module'        => 'Frontend',
                            'namespace' 	=> 'Modules\Frontend\Controllers\\',
                            'controller'    => 'error',
                            'action'        => 'notFound',
                        ]);
                        return false;
                        break;
                    default:
                        $dispatcher->forward([
                            'module'        => 'Frontend',
                            'namespace' 	=> 'Modules\Frontend\Controllers\\',
                            'controller'    => 'error',
                            'action'        => 'uncaughtException',
                        ]);
                        return false;
                        break;
                }
            });
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Modules\Frontend\Controllers');
            $dispatcher->setDefaultController('Index');
            $dispatcher->setDefaultAction('index');

            return $dispatcher;
        }, true);

        // Registration of component representations (Views)

        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir(APP_PATH.'/Modules/Frontend/views/');
            return $view;
        });

        return require_once APP_PATH.'/Modules/Frontend/config/services.php';
    }

}