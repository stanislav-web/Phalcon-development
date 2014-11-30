<?php
namespace Modules;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;
use Plugins\Dispatcher\NotFoundPlugin;

/**
 * Backend module
 * @package Phalcon
 * @subpackage Backend
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Modules/Module.php
 */
class Backend implements ModuleDefinitionInterface
{

	/**
	 * Current module name
	 * @var const
	 */
	const MODULE	=	'Backend';

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
			'Modules\Backend\Forms'   		=>  $this->_config['application']['formsBack'],
			'Models'       					=> 	$this->_config['application']['modelsDir'],
			'Helpers'       				=> 	$this->_config['application']['helpersDir'],
			'Libraries'       				=>  $this->_config['application']['libraryDir'],
			'Plugins'       				=>  $this->_config['application']['pluginsDir'],
		]);

        $loader->register();

		if(APPLICATION_ENV == 'development')
		{
			$namespaces = array_merge(
				$loader->getNamespaces(), [
					'Phalcon\Utils' 		=> 	APP_PATH.'/Libraries/PrettyExceptions/Library/Phalcon/Utils',
					'Fabfuel\Prophiler' 	=> 	DOCUMENT_ROOT.'/../vendor/fabfuel/prophiler/src/Fabfuel/Prophiler/',
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
			$eventsManager = $di->getShared('eventsManager');
			$eventsManager->attach('dispatch:beforeException', new \Plugins\Dispatcher\NotFoundPlugin());
			$dispatcher = new \Phalcon\Mvc\Dispatcher();
			$dispatcher->setEventsManager($eventsManager);
			$dispatcher->setDefaultNamespace('Modules\\'.self::MODULE.'\Controllers');
			return $dispatcher;
		}, true);

        // Registration of component representations (Views)

		$di->set('view', function() {
			$view = new View();
			$view->setViewsDir($this->_config['application']['viewsBack'])
				->setMainView('auth-layout')
				->setPartialsDir('partials');
			return $view;
		});

        require_once APP_PATH.'/Modules/'.self::MODULE.'/config/services.php';

		// call profiler
		if($this->_config->database->profiler === true) // share develop sidebar
			(new \Plugins\Debugger\Develop($di));

		if(APPLICATION_ENV == 'development')
		{
			// share Fabfuel topbar
			$profiler = new \Fabfuel\Prophiler\Profiler();
			$di->setShared('profiler', $profiler);

			$pluginManager = new \Fabfuel\Prophiler\Plugin\Manager\Phalcon($profiler);
			$pluginManager->register();

			// add toolbar in your basic BaseController
		}
		return;
    }
}
