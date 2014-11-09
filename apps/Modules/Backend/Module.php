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
            'Modules\Backend\Controllers'   =>  $this->_config['application']['controllersBack'],
			'Models'       					=> 	$this->_config['application']['modelsDir'],
			'Libraries'       				=>  $this->_config['application']['libraryDir'],
		]);

        $loader->register();

		if(isset($this->_config->database->profiler))
		{
			$namespaces = array_merge(
				$loader->getNamespaces(), [
					'Phalcon\Debugger'	=>	APP_PATH.'/Libraries/Debugger',
					'Phalcon\Utils' 	=> 	APP_PATH.'/Libraries/PrettyExceptions/Library/Phalcon/Utils'

				]
			);
			$loader->registerNamespaces($namespaces);

			// call pretty loader
			set_error_handler(function($errorCode, $errorMessage, $errorFile, $errorLine) {
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
        $di->set('dispatcher', function() use ($di) {

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Modules\Backend\Controllers');
            return $dispatcher;
        });

        // Registration of component representations (Views)

		$di->set('view', function() {
			$view = new View();
			$view->setViewsDir($this->_config['application']['viewsBack'])
				->setMainView('auth-layout')
				->setPartialsDir('partials');
			return $view;
		});

        return require_once APP_PATH.'/Modules/Backend/config/services.php';
    }

}