<?php

use \Application\Helpers\OriginPreflight;

// Require definitions
require_once '../config/definitions.php';

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

    // Handle OPTIONS requests
    if(OriginPreflight::isOptions() === true) {
        OriginPreflight::allowRequest();
    }

    // Handle the request
    echo $app->handle()->getContent();

} catch (\Exception $e) {

    $exception = new Application\Modules\Rest\Services\RestExceptionHandler($di);
    $exception->handle($e)->send();
}