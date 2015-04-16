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
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
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

    // Handle the request
    echo $app->handle()->getContent();

    if(APPLICATION_ENV === 'development') {
        $xhprof_data = xhprof_disable();
        $xhprof_runs = new XHProfRuns_Default();
        $run_id = $xhprof_runs->save_run($xhprof_data, "test");
    }

} catch (\Exception $e) {

    $exception = new Application\Modules\Rest\Services\RestExceptionHandler($di);
    $exception->handle($e)->send();
}