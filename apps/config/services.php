<?php

// Configure Component-Dependency

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Register the global configuration as config
 */
$di->set('config', $config);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir($config['application']['viewsDir']);

    return $view;
});

/**
 * Database connection.
 * Is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {

    $adapterName = 'Phalcon\Db\Adapter\Pdo\\'.$config->database->adapter;

    return new $adapterName([
        'host'      =>  $config->database->host,
        'username'  =>  $config->database->username,
        'password'  =>  $config->database->password,
        'dbname'    =>  $config->database->dbname,
        'options'   =>  [
            PDO::ATTR_PERSISTENT            =>  $config->database->persistent,
            PDO::MYSQL_ATTR_INIT_COMMAND    =>  'SET NAMES \''.$config->database->charset.'\'',
            PDO::ATTR_ERRMODE               =>  $config->database->debug,
            PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC
        ]
    ]);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
