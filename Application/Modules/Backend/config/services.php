<?php

// Component URL is used to generate all kinds of addresses in the annex
$di->set('url', function () {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($this->config->application->baseUri)
        ->setBasePath(DOCUMENT_ROOT);
    return $url;

});

// Setup upload files service
$di->set('uploader', '\Uploader\Uploader');

// Meta Service Helper
$di->set('MetaService','Application\Services\MetaService');

// Data Service Helper
$di->set('DataService','Application\Services\DataService');

// Setup Searcher component
$di->set('searcher', 'Searcher\Searcher');

// Component Navigation. Manage site navigation
$di->setShared('navigation', function () {

    require_once APP_PATH . '/../config/navigation.php';

    if (isset($navigation[self::MODULE]))
        return new Application\Libraries\Navigation\Navigation(new \Phalcon\Config($navigation[self::MODULE]));

});

// If the configuration specify the use of metadata adapter use it or use memory otherwise
if ($this->config->cache->metadata == true) {
    $di->setShared('modelsMetadata', function () {
        return new Phalcon\Mvc\Model\Metadata\Apc([
            'prefix' => $this->config->cache->prefix,
            'lifetime' => $this->config->cache->lifetime
        ]);
    });
}

//Set the views cache service
$di->setShared('viewCache', function () {

    $frontCache = new \Phalcon\Cache\Frontend\Output([
        "lifetime" => $this->config->cache->lifetime
    ]);
    //Memcached connection settings

    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, [
        "host" => $this->config->cache->memcached->host,
        "port" => $this->config->cache->memcached->port,
        "persistent" => $this->config->cache->memcached->persistent
    ]);
    return $cache;

});

// Set the backend data cache service
if ($this->config->cache->enable == true) {

    $di->set('dbCache', function () {

        // Data caching (queries data, json data etc)

        $dbCache =  new Phalcon\Cache\Frontend\Data([
            "lifetime" => $this->config->cache->lifetime
        ]);

        $cache = new Phalcon\Cache\Backend\Memcache($dbCache, [
            "prefix" => $this->config->cache->prefix,
            "host" => $this->config->cache->memcached->host,
            "port" => $this->config->cache->memcached->port,
            "persistent" => $this->config->cache->memcached->persistent,
        ]);
        return $cache;
    });
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