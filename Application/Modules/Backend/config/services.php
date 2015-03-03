<?php

// Component URL is used to generate all kinds of addresses in the annex
$di->set('url', function () use ($di) {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($di->get('config')->application->baseUri)
        ->setBasePath(DOCUMENT_ROOT);
    return $url;

});

// Setup upload files service
$di->set('uploader', '\Uploader\Uploader');

// Meta Service Helper
$di->set('MetaService','Application\Services\MetaService');

// Data Service Helper
$di->set('DataService','Application\Services\DataService');

// Transaction manager
$di->setShared('transactions', '\Phalcon\Mvc\Model\Transaction\Manager');

// Setup Searcher component
$di->set('searcher', 'Searcher\Searcher');

// Component Navigation. Manage site navigation
$di->setShared('navigation', function () {

    require_once APP_PATH . '/../config/navigation.php';

    if (isset($navigation[self::MODULE]))
        return new Application\Libraries\Navigation\Navigation(new \Phalcon\Config($navigation[self::MODULE]));

});

// Set the backend data cache service
if ($di->get('config')->cache->enable == true) {


    $di->set('dbCache', function () use ($di) {

        // Data caching (queries data, json data etc)

        $dbCache =  new Phalcon\Cache\Frontend\Data([
            "lifetime" => $di->get('config')->cache->lifetime
        ]);

        $cache = new Phalcon\Cache\Backend\Memcache($dbCache, [
            "prefix"    => $di->get('config')->cache->prefix,
            "host"      => $di->get('config')->cache->memcached->host,
            "port"      => $di->get('config')->cache->memcached->port,
            "persistent" => $di->get('config')->cache->memcached->persistent,
        ]);
        return $cache;
    });

    //Set the views cache service
    $di->setShared('viewCache', function () use ($di) {

        $frontCache = new \Phalcon\Cache\Frontend\Output([
            "lifetime" => $di->get('config')->cache->lifetime
        ]);

        $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, [
            "host" => $di->get('config')->cache->memcached->host,
            "port" => $di->get('config')->cache->memcached->port,
            "persistent" => $di->get('config')->cache->memcached->persistent
        ]);
        return $cache;

    });

    // If the configuration specify the use of metadata adapter use it or use memory otherwise
    if ($di->get('config')->cache->metadata == true) {
        $di->setShared('modelsMetadata', function () use ($di) {
            return new Phalcon\Mvc\Model\Metadata\Apc([
                'prefix' => $di->get('config')->cache->prefix,
                'lifetime' => $di->get('config')->cache->lifetime
            ]);
        });
    }
}

// Component flashSession (Session keep flash messages).
$di->setShared('flash', function () {

    $flash = new Phalcon\Flash\Session([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
    ]);
    return $flash;

});