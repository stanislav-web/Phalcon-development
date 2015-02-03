<?php

/**
 * @define Document root
 * @define Application path
 * @define Staging development
 */
defined('DOCUMENT_ROOT') || define('DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"]);
defined('APP_PATH') || define('APP_PATH', DOCUMENT_ROOT . '/../apps');

defined('APPLICATION_ENV') ||
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Require configurations
require_once APP_PATH . '/config/application.php';

// Require composite libraries
require_once DOCUMENT_ROOT . ' /../vendor/autoload.php';

// Require routes
require APP_PATH . '/config/routes.php';

// Create factory container
$di = new Phalcon\DI\FactoryDefault();

// Set routes
$di->set('router', $router);

// Set global configuration
$di->set('config', function () use ($config) {
    return (new \Phalcon\Config($config));
});

try {

    $application = new Phalcon\Mvc\Application($di);

    // Require modules
    require APP_PATH . '/config/modules.php';

    if (APPLICATION_ENV === 'development') {
        // require whoops
        new Whoops\Provider\Phalcon\WhoopsServiceProvider($di);
    }

    // Handle the request
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
