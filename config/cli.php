<?php
/**
 * BE CAREFUL!
 * This section contains the settings to be used for this module.
 */

// Create factory container
$di = new  \Phalcon\DI\FactoryDefault\CLI();

// BASE SERVICES

// Set global configuration (merge of environment)
$di->setShared('config', function () use ($config) {

    $configBase = new \Phalcon\Config($config);

    (APPLICATION_ENV === 'development') ? $configBase->merge(
        new \Phalcon\Config(require(APPLICATION_ENV . '.php'))
    ) : '';

    return $configBase;
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
        $metaData->reset();
    }
    return $metaData;
});

// GLOBAL SERVICES

// Database connection is created based in the parameters defined in the configuration file
$di->setShared('db', function () use ($di) {

    $config = $di->get('config')->database;

    $connect = new \Application\Services\Database\MySQLConnectService(
        $config->toArray()
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


// Define mailer service
$di->setShared('MailService', function () use ($di) {

    $config = $di->get('config')->mail->toArray();

    $mailer = new Application\Services\Mail\MailSMTPService($config);
    $mailer->registerPlugin(new Application\Services\Mail\MailSMTPExceptions());
    $mailer->registerPlugin(new \Swift_Plugins_ThrottlerPlugin(100, \Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE));

    return $mailer;
});

// Define helper's service
$di->setShared('tag', '\Application\Services\Advanced\HelpersService');

// Define console tasks loader
$di->setShared('ConsoleTasks', function() {

    $loader = new \Phalcon\Loader();
    $loader->registerDirs([
        APP_PATH.DIRECTORY_SEPARATOR.'Tasks',
        DOCUMENT_ROOT.'vendor/stanislav-web/sonar/src/Sonar/System/Tasks'
    ]);

    return $loader;
});

// Define console color manager
$di->setShared('color', '\Phalcon\Script\Color');

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

// Define subscribers mapper
$di->setShared('SubscribeMapper','Application\Services\Mappers\SubscribeMapper');

// Define items mapper
$di->setShared('ItemsMapper','Application\Services\Mappers\ItemsMapper');

// Define item attributes mapper
$di->setShared('ItemAttributesMapper','Application\Services\Mappers\ItemAttributesMapper');

// Define item attribute values mapper
$di->setShared('ItemAttributeValuesMapper','Application\Services\Mappers\ItemAttributeValuesMapper');

// Define log mapper
$di->setShared('LogMapper', function() use ($di) {

    $config = $di->get('config')->database->toArray();

    try {
        return new Application\Services\Mappers\LogMapper(
            new \Phalcon\Db\Adapter\Pdo\Mysql($config), $di->get('dispatcher')
        );
    }
    catch(\PDOException $e) {
        die(json_encode(['error' => 'Could not connect to server: '.$e->getMessage()]));
    }

});
