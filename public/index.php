<?php
/**
 * Define stage of application
 */
defined('APPLICATION_ENV') ||
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
defined('APP_PATH') || define('APP_PATH', realpath(dirname(__FILE__) . '/../apps'));

// Require configurations
require_once APP_PATH.'/config/application.php';

// Create factory container
$di = new Phalcon\DI\FactoryDefault();

// Set default routes
$di->set('router', function() {

    $router = new \Phalcon\Mvc\Router();
    require APP_PATH . '/config/routes.php';
    return $router;

});

// Set global configuration
$di->set('config', function() use ($config) {
    return (new \Phalcon\Config($config));
});

try {

    $application = new Phalcon\Mvc\Application($di);

    // Register modules
    $application->registerModules([
        'Frontend'	=>	[
            'className' => 'Modules\Frontend',
            'path'      => APP_PATH.'/Modules/Frontend/Module.php',
        ],
        'Backend'	=>	[
            'className' => 'Modules\Backend',
            'path'      => APP_PATH.'/Modules/Backend/Module.php',
        ],
    ])->setDefaultModule('Frontend');

    // Handle the request
    echo $application->handle()->getContent();

}
catch (\Exception $e)
{
    echo $e->getMessage();
    var_dump($e->getTrace());
}
