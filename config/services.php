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
$di->setShared('session', function () use ($di) {

    $session = new \Application\Services\Security\SessionProtector();
    return $session->init($di->get('config')->session->toArray());
});

// Set meta data
$di->setShared('modelsMetadata', function() use ($di) {

    $config = $di->get('config')->cache->toArray();

    if($config['metadata'] === true) {

        $metaData = new \Phalcon\Mvc\Model\MetaData\Apc([
            'lifetime' => $config['lifetime'], // optional (standard: 8600)
            'prefix' => $config['prefix']   // optional (standard: false)
        ]);
    }
    else {
        // Without cache strategy
        $metaData = new \Phalcon\Mvc\Model\MetaData\Memory([
            'lifetime' => 0, // optional (standard: 8600)
            'prefix' => $config['prefix']   // optional (standard: false)
        ]);
    }
    return $metaData;
});

// GLOBAL SERVICES

// Database connection is created based in the parameters defined in the configuration file
$di->setShared('db', function () use ($di) {

    $config = $di->get('config')->database;
    $connect = new \Application\Services\Database\MySQLConnectService(
        $config
    );

    if($config->profiling === true) {

        $eventManager = new Phalcon\Events\Manager();

        $dbListener = $di->getShared('DbListener');
        $eventManager->attach('db', function($event, Application\Services\Database\MySQLConnectService $connect)
        use ($dbListener) {

            if($event->getType() == 'beforeQuery') {
                $dbListener->getProfiler()->startProfile($connect->getRealSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $dbListener->getProfiler()->stopProfile();
                $dbListener->setProfileData([
                    $connect->getRealSQLStatement()   => $dbListener->getProfiler()->getTotalElapsedSeconds(),
                ]);
            }
        });
        $connect->setEventsManager($eventManager);
    }

    return $connect;
});

// Define database listener
$di->setShared('DbListener', function () {
    return new \Application\Services\Develop\MySQLDbListener();
});

// Define Profiler
$di->setShared('ProfilerService', '\Application\Services\Develop\ProfilerService');

// Define mailer service
$di->setShared('MailService', function () use ($di) {

    $config = $di->get('config')->mail->toArray();

    $mailer = new Application\Services\Mail\MailSMTPService($config);
    $mailer->registerPlugin(new Application\Services\Mail\MailSMTPExceptions());
    $mailer->registerPlugin(new \Swift_Plugins_ThrottlerPlugin(100, \Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE));

    return $mailer;
});

// Define SMS sender service
$di->set('SmsService', function () use ($di) {
    return new SMSFactory\Sender($di);
});

// Define mailer service
$di->setShared('eventsManager', function () {

    $eventsManager = new \Phalcon\Events\Manager();
    $eventsManager->attach('dispatch:beforeException',      new \Application\Modules\Rest\Events\BeforeException\NotFoundEvent(), 150);
    $eventsManager->attach("dispatch:beforeDispatchLoop",   new \Application\Modules\Rest\Events\BeforeDispatchLoop\ResolveParams(), 140);

    return $eventsManager;
});

// Define helper's service
$di->setShared('tag', '\Application\Services\Advanced\HelpersService');

// Define Opcode Cache Service
$di->setShared('OpcodeCache', function () use ($di) {
    return new \Application\Services\Cache\OpCodeService($di->get('config'));
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

// Define file mapper
$di->setShared('FileMapper', new \Application\Services\Mappers\FileMapper($di));

// Define banners mapper
$di->setShared('BannersMapper','Application\Services\Mappers\BannersMapper');

// Define items mapper
$di->setShared('ItemsMapper','Application\Services\Mappers\ItemsMapper');

// Define item attributes mapper
$di->setShared('ItemAttributesMapper','Application\Services\Mappers\ItemAttributesMapper');

// Define item attribute values mapper
$di->setShared('ItemAttributeValuesMapper','Application\Services\Mappers\ItemAttributeValuesMapper');

// Define log mapper
$di->setShared('LogMapper', function() use ($di) {

    $config = $di->get('config')->database->toArray();

    return new Application\Services\Mappers\LogMapper(
        new \Phalcon\Db\Adapter\Pdo\Mysql($config), $di->get('dispatcher')
    );

});