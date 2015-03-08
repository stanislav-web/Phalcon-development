<?php

/**
 * @define Document root
 * @define Application path
 * @define Staging development environment
 */
defined('DOCUMENT_ROOT') || define('DOCUMENT_ROOT', $_SERVER["DOCUMENT_ROOT"]);
defined('APP_PATH') || define('APP_PATH', DOCUMENT_ROOT . '/../Application');
defined('APPLICATION_ENV') ||
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Require composite libraries

require_once DOCUMENT_ROOT . ' /../vendor/autoload.php';

// Require global configurations
require_once DOCUMENT_ROOT . '/../config/application.php';

// Require routes
require_once DOCUMENT_ROOT . '/../config/routes.php';

// Require global services
require_once DOCUMENT_ROOT . '/../config/services.php';

try {

    $application = new Phalcon\Mvc\Application($di);

    // Require modules
    require_once DOCUMENT_ROOT . '/../config/modules.php';

    if (APPLICATION_ENV === 'development') {
        // require whoops exception handler
        new Whoops\Provider\Phalcon\WhoopsServiceProvider($di);
    }

    // Handle the request
    echo $application->handle()->getContent();

} catch (\Exception $e) {

    if (APPLICATION_ENV === 'development') {
        echo $e->getMessage();
        echo $e->getFile();
        echo $e->getLine();
    }
    else {

        // define logger
        if($di->has('LogDbService')) {
            $logger = $di->get('LogDbService');
            $logger->save($e->getMessage()
                .' File: '.$e->getFile()
                .' Line:'.$e->getLine(),
                \Phalcon\Logger::CRITICAL);
        }
    }
}