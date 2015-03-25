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
$di->set('RestValidationService', function () use ($di) {

    (new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveMethodEvent($di))->run();
    (new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveRequestLimitEvent($di))->run();
    (new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAcceptEvent($di))->run();
    (new \Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAccessEvent($di))->run();

    $restValidator = new \Application\Modules\Rest\Services\RestValidationService();

    return $restValidator;
});

// Define Security Service
$di->set('RestSecurityService', function () use ($di) {

    $security = new \Application\Modules\Rest\Services\SecurityService();

    return $security;
});

// Define Rest Service
$di->set('RestService', function () use ($di) {

    $restService = new \Application\Modules\Rest\Services\RestService(
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

// Define Rest Rules
$di->set('RestRules', function () use ($di) {
    return require_once(__DIR__ .DIRECTORY_SEPARATOR.'rules.php');
});

