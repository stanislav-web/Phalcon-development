<?php
/**
 * BE CAREFUL!
 * This section contains the settings to be used for this module.
 */

use Phalcon\DI\FactoryDefault as Di;

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

// Set routes
$di->setShared('router', $router);

// Set logger service
if ($config['logger'] == true) {

    $di->setShared('logger', function() use ($config) {

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config['database']);

        $logger = new Phalcon\Logger\Adapter\Database('errors', array(
            'db' => $connection,
            'table' => 'logs'
        ));
        return $logger;
    });
}

// Component Session. Starting a Session
$di->setShared('session', function () use ($config) {
    $session = new \Phalcon\Session\Adapter\Files([
        'host'          => $config['cache']['memcached']['host'],       // mandatory
        'port'          => $config['cache']['memcached']['port'],       // optional (standard: 11211)
        'lifetime'      => $config['cache']['lifetime'],                // optional (standard: 8600)
        'persistent'    => $config['cache']['memcached']['persistent']  // optional (standard: false)
    ]);
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
    $crypt->setKey($config['cookieCryptKey']);
    $crypt->setPadding(\Phalcon\Crypt::PADDING_PKCS7);

    return $crypt;

});

// Define language service
$di->setShared('ErrorHttpService', 'Application\Services\ErrorHttpService');

// Define mailer service
$di->setShared('MailService', function () use ($di, $config) {
    $mailer = new Application\Services\MailSMTPService($config['mail']);
    $mailer->registerExceptionsHandler(new Application\Services\MailSMTPExceptions($di));

    return $mailer;
});

// Define language service
$di->setShared('LanguageService', function () {
    return new Application\Services\LanguageService();
});

// Define translate service
$di->setShared('TranslateService','Application\Services\TranslateService');