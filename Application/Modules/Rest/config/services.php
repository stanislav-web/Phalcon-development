<?php
// SERVICES

// Overload Base config
$di->set('RestConfig', function () use ($di) {

    $configBase = $di->get('config');

    $configBase->merge(
        require('config.php')
    );

    return $configBase;
});

// Define Rest Validator
$di->set('RestValidationService', function () {

    $restValidator = new \Application\Modules\Rest\Services\RestValidatorCollectionService([
        new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveMethodEvent(),
        new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveRequestLimitEvent(),
        new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAcceptEvent(),
        new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAccessEvent()
        ]
    );

    return $restValidator;
});

// Define Security Service
$di->set('RestSecurityService', function () {

    $security = new \Application\Modules\Rest\Services\SecurityService();

    return $security;
});

// Define Rest Service
$di->set('RestService', function () use ($di) {

    $restService = new \Application\Modules\Rest\Services\RestService(
        $di->get('RestValidationService')->init()
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

// Define Rest Rules
$di->set('RestRules', function () {
    return require_once(__DIR__ .DIRECTORY_SEPARATOR.'rules.php');
});

