<?php
/**
 * BE CAREFUL!
 * This section contains the settings to be used for this module.
 */

// Create factory container
$di = new Phalcon\DI\FactoryDefault();

// BASE SERVICES

// Set global configuration (merge of environment)
$di->setShared('config', function () use ($config) {

    $configBase = new \Phalcon\Config($config);

    (APPLICATION_ENV === 'development') ? $configBase->merge(
        require(APPLICATION_ENV . '.php')
    ) : '';

    return $configBase;
});

// Set routes
$di->setShared('router', $router);

// Component Session. Starting a Session
$di->setShared('session', function () use ($config) {
    $session = new \Phalcon\Session\Adapter\Memcache([
        'host'          => $config['cache']['memcached']['host'],       // mandatory
        'port'          => $config['cache']['memcached']['port'],       // optional (standard: 11211)
        'lifetime'      => $config['cache']['lifetime'],                // optional (standard: 8600)
        'persistent'    => $config['cache']['memcached']['persistent']  // optional (standard: false)
    ]);

    session_set_cookie_params($config['cache']['lifetime'], "/");
    $session->start();
    return $session;
});

$di->setShared('modelsMetadata', function() use ($config) {

    $metaData = new \Phalcon\Mvc\Model\MetaData\Memory([
        'lifetime'      => $config['cache']['lifetime'], // optional (standard: 8600)
        'prefix'        => $config['cache']['prefix']   // optional (standard: false)
    ]);

    return $metaData;
});

// Default component to crypt cookies values
$di->set('crypt', function () use ($config) {

    $crypt = new \Phalcon\Crypt();
    $crypt->setKey($config['application']['cryptSalt']);
    $crypt->setPadding(\Phalcon\Crypt::PADDING_PKCS7);

    return $crypt;

});

// GLOBAL SERVICES

// Database connection is created based in the parameters defined in the configuration file
$di->setShared('db', function () use ($config) {
    return new \Application\Services\Database\MySQLConnectService($config['database']);
});

// Define mailer service
$di->setShared('MailService', function () use ($di, $config) {
    $mailer = new Application\Services\Mail\MailSMTPService($config['mail']);
    $mailer->registerPlugin(new Application\Services\Mail\MailSMTPExceptions($di));
    $mailer->registerPlugin(new \Swift_Plugins_ThrottlerPlugin(100, \Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE));

    return $mailer;
});

// Define mailer service
$di->setShared('eventsManager', function () use ($di) {

    $eventsManager = new \Phalcon\Events\Manager();
    $eventsManager->attach('dispatch:beforeException',      new \Application\Modules\Rest\Events\BeforeException\NotFoundEvent(), 150);
    $eventsManager->attach("dispatch:beforeDispatchLoop",   new \Application\Modules\Rest\Events\BeforeDispatchLoop\ResolveParams(), 140);

    return $eventsManager;
});

// MAPPERS

// Define category mapper
$di->setShared('CategoryMapper','Application\Services\Mappers\CategoryMapper');

// Define currency mapper
$di->setShared('CurrencyMapper','Application\Services\Mappers\CurrencyMapper');

// Define page mapper
$di->setShared('PageMapper','Application\Services\Mappers\PageMapper');

// Define error mapper
$di->setShared('ErrorMapper','Application\Services\Mappers\ErrorMapper');

// Define engine mapper
$di->setShared('EngineMapper','Application\Services\Mappers\EngineMapper');

// Define user mapper
$di->setShared('UserMapper','Application\Services\Mappers\UserMapper');

// Define log mapper
$di->setShared('LogMapper', function() use ($config, $di) {

    return new Application\Services\Mappers\LogMapper(
        new \Phalcon\Db\Adapter\Pdo\Mysql($config['database']), $di
    );

});