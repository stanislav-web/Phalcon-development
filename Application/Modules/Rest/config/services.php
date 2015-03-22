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

// Define Rest Json Service
$di->set('JsonRestService', function () use ($di) {

    $restService = new \Application\Modules\Rest\Services\JsonRestService(
        $di->get('RestValidationService')->init(
            require(__DIR__ .DIRECTORY_SEPARATOR.'rules.php')
        )
    );

    // Define Translate Service (inside the rest)
    $di->set('TranslateService',function() use ($di, $restService) {

        $config = $di->get('config');

        return (new \Application\Modules\Rest\Services\TranslateService($restService->getLocale(),
            $config->locale->language
        ))->path($config->locale->translates);

    });

    return $restService;
});

