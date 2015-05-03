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

if(APPLICATION_ENV === 'development') {

    if (!defined('XHPROF_LIB_ROOT')) {
        define('XHPROF_LIB_ROOT', '/var/www/profiler.local/xhprof_lib/');
    }
    require_once '/var/www/profiler.local/external/header.php';
}


// Require composite libraries
require_once DOCUMENT_ROOT . ' /../vendor/autoload.php';

// Require global configurations
require_once DOCUMENT_ROOT . '/../config/application.php';

// Require routes
require_once DOCUMENT_ROOT . '/../config/routes.php';

// Require global services
require_once DOCUMENT_ROOT . '/../config/services.php';

try {
    $app = new Phalcon\Mvc\Application($di);
    // Require modules
    require_once DOCUMENT_ROOT . '/../config/modules.php';

    if(APPLICATION_ENV === 'development') {
        require_once '/var/www/profiler.local/external/footer.php';
    }

    // Handle the request
    echo $app->handle()->getContent();

} catch (\Exception $e) {

    $exception = new Application\Modules\Rest\Services\RestExceptionHandler($di);
    $exception->handle($e)->send();
}