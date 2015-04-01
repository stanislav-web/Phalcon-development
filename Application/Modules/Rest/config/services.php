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

    return new \Application\Modules\Rest\Services\RestSecurityService();
});

// Define Rest Validator
$di->setShared('RestValidationService', function () use ($di) {
    return new \Application\Modules\Rest\Services\RestValidatorCollectionService($di);
});

// Define Rest Cache Service
$di->set('RestCache', function () use ($di) {
    return new \Application\Modules\Rest\Services\RestCacheService($di->get('RestConfig'));
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




