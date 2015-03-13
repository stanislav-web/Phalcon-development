<?php
// SERVICES

// Define Rest Validator
$di->set('RestValidationService', function () use ($di) {

    $restValidator = (new \Application\Services\Http\RestValidationService(
        $di->get('request'),
        $di->get('dispatcher'),
        require(__DIR__ .DIRECTORY_SEPARATOR.'rules.php')
    ));

    return $restValidator;
});

// Define Rest service
$di->set('JsonRestService', function () use ($di) {

    $restService = new \Application\Services\Http\JsonRestService($di->get('RestValidationService'));

    return $restService;
});