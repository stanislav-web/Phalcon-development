<?php
/**
 * BE CAREFUL!
 * This section contains the settings to be used for this module.
 */

// Create factory container
$di = new Phalcon\DI\FactoryDefault();

// Set global configuration (merge of environment)
$di->setShared('config', function () use ($config) {

    $configBase = new \Phalcon\Config($config);

   (APPLICATION_ENV === 'development') ? $configBase->merge(
        require(APPLICATION_ENV . '.php')
    ) : '';

    return $configBase;
});

// Database connection is created based in the parameters defined in the configuration file
$di->setShared('db', function () use ($config) {
    return new \Application\Services\MySQLConnectService($config['database']);
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

// Component cookies
$di->setShared('cookies', function () {

    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;

});

// Default component to crypt cookies values
$di->set('crypt', function () use ($config) {

    $crypt = new \Phalcon\Crypt();
    $crypt->setKey($config['application']['cryptSalt']);
    $crypt->setPadding(\Phalcon\Crypt::PADDING_PKCS7);

    return $crypt;

});

// Define mailer service
$di->setShared('MailService', function () use ($di, $config) {
    $mailer = new Application\Services\MailSMTPService($config['mail']);
    $mailer->registerExceptionsHandler(new Application\Services\MailSMTPExceptions($di));

    return $mailer;
});

// Define translate service
$di->setShared('TranslateService',function() use ($di, $config) {

    return (new Application\Services\TranslateService(
        (new Application\Services\LanguageService())->define($di), $config['locale']['language']
    ))->path($config['locale']['translates']);

});

// Define logger service
$di->setShared('LogDbService', function() use ($config) {

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config['database']);
    return new Application\Services\LogDbService($connection);

});

// Define engine service
$di->setShared('EngineService','Application\Services\EngineService');

// Define helper's service
$di->setShared('tag', '\Application\Services\HelpersService');

// Define language service
$di->setShared('ErrorHttpService', 'Application\Services\ErrorHttpService');

// Define auth service
$di->setShared('AuthService','Application\Services\AuthService');

// Define categories service
$di->setShared('CategoriesService','Application\Services\CategoriesService');