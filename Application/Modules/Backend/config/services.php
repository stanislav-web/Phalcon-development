<?php

// Component URL is used to generate all kinds of addresses in the annex
$di->set('url', function () {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($this->_config->application->baseUri)
        ->setBasePath(DOCUMENT_ROOT);
    return $url;

});

// Component flashSession (Session keep flash messages).
$di->setShared('flash', function () {

    $flash = new Phalcon\Flash\Session([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
    ]);
    return $flash;

});

// Setup upload files service
$di->set('uploader', '\Uploader\Uploader');

// Setup Hansel & Gretel breadcrumbs ))
$di->set('breadcrumbs', '\Application\Plugins\Breadcrumbs\Breadcrumbs');

// Setup Searcher component
$di->set('searcher', 'Searcher\Searcher');

// Component Navigation. Manage site navigation
$di->setShared('navigation', function () {

    require_once APP_PATH . '/../config/navigation.php';

    if (isset($navigation[self::MODULE]))
        return new Application\Libraries\Navigation\Navigation(new \Phalcon\Config($navigation[self::MODULE]));

});

// If the configuration specify the use of metadata adapter use it or use memory otherwise
if ($this->_config->cache->metadata == true) {
    $di->setShared('modelsMetadata', function () {
        return new Phalcon\Mvc\Model\Metadata\Apc([
            'prefix' => $this->_config->cache->prefix,
            'lifetime' => $this->_config->cache->lifetime
        ]);
    });
}

//Set the views cache service
$di->setShared('viewCache', function () {

    $frontCache = new \Phalcon\Cache\Frontend\Output([
        "lifetime" => $this->_config->cache->lifetime
    ]);
    //Memcached connection settings

    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, [
        "host" => $this->_config->cache->memcached->host,
        "port" => $this->_config->cache->memcached->port,
        "persistent" => $this->_config->cache->memcached->persistent
    ]);
    return $cache;

});


// Set the backend data cache service
if ($this->_config->cache->enable == true) {

    $di->set('dbCache', function () {

        // Data caching (queries data, json data etc)

        $dbCache = new Phalcon\Cache\Frontend\Data([
            "lifetime" => $this->_config->cache->lifetime
        ]);

        // Choose data storage
        switch ($this->_config->cache->adapter) {
            case 'memcache':

                $cache = new Phalcon\Cache\Backend\Memcache($dbCache, [
                    "prefix" => $this->_config->cache->prefix,
                    "host" => $this->_config->cache->memcached->host,
                    "port" => $this->_config->cache->memcached->port,
                    "persistent" => $this->_config->cache->memcached->persistent,
                ]);

                break;

            case 'apc':

                $cache = new Phalcon\Cache\Backend\Apc($dbCache, [
                    "prefix" => $this->_config->cache->prefix
                ]);

                break;

            case 'xcache':
                $cache = new Phalcon\Cache\Backend\Xcache($dbCache, [
                    "prefix" => $this->_config->cache->prefix,
                ]);
                break;
        }
        return $cache;

    });
}
