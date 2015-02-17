<?php

// Navigation menus

$di->set('navigation', function () {

    $navigation =   [];
    require_once APP_PATH . '/Modules/'.self::MODULE.'/config/navigation.php';
    return $navigation;

});

// Component URL is used to generate all kinds of addresses in the annex

$di->set('url', function () use ($di) {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($di->get('config')['application']['baseUri'])
        ->setBasePath(DOCUMENT_ROOT);

    return $url;

});

// SMS sender service

$di->set('SMS', function () use ($di) {

    return new SMSFactory\Sender($di);
});

// Define engine service
$di->setShared('EngineService','Application\Services\EngineService');