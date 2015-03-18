<?php
// SERVICES

// Define Rest Validator
$di->set('RestValidationService', function () use ($di) {

    $restValidator = new \Application\Modules\Rest\Services\RestValidationService();

    return $restValidator;
});

// Define Security Service
$di->set('RestSecurityService', function () use ($di) {

    $security = new \Application\Modules\Rest\Services\SecurityService();

    return $security;
});

// Define Rest service
$di->setShared('JsonRestService', function () use ($di) {

    $restService = new \Application\Modules\Rest\Services\JsonRestService(
        $di->get('RestValidationService')->init(
            require(__DIR__ .DIRECTORY_SEPARATOR.'rules.php')
        )
    );

    return $restService;
});