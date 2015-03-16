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

    if (APPLICATION_ENV === 'production') { // replace by development

        // require whoops exception handler
        error_reporting(7);
        new Whoops\Provider\Phalcon\WhoopsServiceProvider($di);
    }
    else {

        error_reporting(0);
    }

    // Handle the request
    echo $application->handle()->getContent();

} catch (\Exception $e) {

    if (APPLICATION_ENV === 'production') { // replace by development
        echo $e->getMessage();
    }
    else {

        // log messages
        $di->get('LogMapper')->save($e->getMessage().' File: '.$e->getFile().' Line:'.$e->getLine(),1);
    }
}