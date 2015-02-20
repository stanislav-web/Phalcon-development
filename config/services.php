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


// Database connection is created based in the parameters defined in the configuration file

$di->setShared('db', function () use ($config, $di) {

    try {
        $connect = new \Phalcon\Db\Adapter\Pdo\Mysql([
            "host"          => $config['database']['host'],
            "username"     => $config['database']['username'],
            "password"      => $config['database']['password'],
            "dbname"        => $config['database']['dbname'],
            "persistent"    => $config['database']['persistent'],
            "options" => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$config['database']['charset']}'",
                \PDO::ATTR_CASE => \PDO::CASE_LOWER,
                \PDO::ATTR_ERRMODE => $config['database']['debug'],
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        ]);
        return $connect;
    }
    catch (\PDOException $e) {
        $di->get('LogDbService')->save($e->getMessage(), 1);
    }
});


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

// Define mailer service
$di->setShared('MailService', function () use ($di, $config) {
    $mailer = new Application\Services\MailSMTPService($config['mail']);
    $mailer->registerExceptionsHandler(new Application\Services\MailSMTPExceptions($di));

    return $mailer;
});

// Define translate service
$di->setShared('TranslateService',function() use ($di, $config) {

    return (new Application\Services\TranslateService(
        (new Application\Services\LanguageService())->define($di), $config['language']
    ))->path($config['translates']);
});

// Set logger service
if ($config['logger'] == true) {

    $di->setShared('LogDbService', function() use ($config) {

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config['database']);
        return new Application\Services\LogDbService($connection);
    });
}
// Define helper's service
$di->setShared('tag', '\Application\Services\HelpersService');

// Define language service
$di->setShared('ErrorHttpService', 'Application\Services\ErrorHttpService');

// Define auth service
$di->setShared('AuthService','Application\Services\AuthService');