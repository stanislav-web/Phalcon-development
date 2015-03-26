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

// Define Rest Rules
$di->set('RestRules', function () {
    return require_once(__DIR__ .DIRECTORY_SEPARATOR.'rules.php');
});

// Define Security Service
$di->set('RestSecurityService', function () {

    $security = new \Application\Modules\Rest\Services\SecurityService();

    return $security;
});

// Define Rest Validator
$di->setShared('RestValidationService', function () use ($di) {

    $restValidator = new \Application\Modules\Rest\Services\RestValidatorCollectionService([
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveMethod',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveRequestLimit',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAccept',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveAccess',
            '\Application\Modules\Rest\Events\BeforeExecuteRoute\ResolveRequestLength',
        ], $di
    );

    return $restValidator;
});


// Define Rest Service
$di->set('RestService', function () use ($di) {

    $restService = new \Application\Modules\Rest\Services\RestService(
        $di->get('RestValidationService')
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

// Define Rest Cache Service
$di->set('RestCache', function () use ($di) {

    return new \Application\Modules\Rest\Services\RestCacheService($di->get('RestConfig'));
});


