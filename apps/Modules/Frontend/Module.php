<?php
namespace Modules;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

;

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
     * Current module name
     * @var const
     */
    const MODULE = 'Frontend';

    /**
     * Global config
     * @var bool | array
     */
    protected $_config = false;

    /**
     * Configuration init
     */
    public function __construct()
    {

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
            'Modules\Frontend\Controllers' => $this->_config['application']['controllersFront'],
            'Models' => $this->_config['application']['modelsDir'],
            'Libraries' => $this->_config['application']['libraryDir'],
            'Modules\Frontend\Plugins' => APP_PATH . '/Modules/' . self::MODULE . '/Plugins/',
        ]);

        $loader->register();

        if (isset($this->_config->database->profiler)) {
            $namespaces = array_merge(
                $loader->getNamespaces(), [
                    'Phalcon\Debugger' => APP_PATH . '/Libraries/Debugger',
                    'Phalcon\Utils' => APP_PATH . '/Libraries/PrettyExceptions/Library/Phalcon/Utils'

                ]
            );
            $loader->registerNamespaces($namespaces);

            // call pretty loader
            set_error_handler(function ($errorCode, $errorMessage, $errorFile, $errorLine) {
                $p = new \Phalcon\Utils\PrettyExceptions();
                $p->handleError($errorCode, $errorMessage, $errorFile, $errorLine);
            });
        }
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
        $di->set('dispatcher', function () use ($di) {
            $eventsManager = $di->getShared('eventsManager');
            $eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward([
                            'module' => self::MODULE,
                            'namespace' => 'Modules\\' . self::MODULE . '\Controllers\\',
                            'controller' => 'error',
                            'action' => 'notFound',
                        ]);
                        return false;
                        break;
                    default:
                        $dispatcher->forward([
                            'module' => self::MODULE,
                            'namespace' => 'Modules\\' . self::MODULE . '\Controllers\\',
                            'controller' => 'error',
                            'action' => 'uncaughtException',
                        ]);
                        return false;
                        break;
                }
            });
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Modules\\' . self::MODULE . '\Controllers');

            return $dispatcher;
        }, true);

        // Registration of component representations (Views)

        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir($this->_config['application']['viewsFront'])->setMainView('layout');
            return $view;
        });

        return require_once APP_PATH . '/Modules/' . self::MODULE . '/config/services.php';
    }

}