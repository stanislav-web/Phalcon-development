<?php

// Component URL is used to generate all kinds of addresses in the annex

$di->set('url', function () {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($this->_config->application->baseUri)
        ->setBasePath(DOCUMENT_ROOT);
    return $url;

});

// Component Session. Starting a Session

$di->setShared('session', function () {
    $session = new \Phalcon\Session\Adapter\Files([
        'host' => $this->_config->cache->memcached->host,        // mandatory
        'port' => $this->_config->cache->memcached->port,        // optional (standard: 11211)
        'lifetime' => $this->_config->cache->lifetime,                // optional (standard: 8600)
        'prefix' => $this->_config->cache->prefix,                // optional (standard: [empty_string]), means memcache key is my-app_31231jkfsdfdsfds3
        'persistent' => false                                        // optional (standard: false)
    ]);
    $session->start();
    return $session;
});

// Component Logger. $this->di->get('logger')->log('.....',Logger::ERROR);

$di->setShared('logger', function () {

    if ($this->_config->logger->enable == true) {
        $formatter = new \Phalcon\Logger\Formatter\Line($this->_config->logger->format);
        $logger = new \Phalcon\Logger\Adapter\File($this->_config->logger->file);
        $logger->setFormatter($formatter);
        return $logger;
    }
    return false;
});

/**
 * Component flashSession (Session keep flash messages).
 */
$di->setShared('flash', function () {

    $flash = new Phalcon\Flash\Session([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
    ]);
    return $flash;

});

$di->setShared('cookies', function () {

    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;

});

// Default component to crypt cookies values

$di->set('crypt', function () {

    $crypt = new \Phalcon\Crypt();
    $crypt->setKey($this->_config->cookieCryptKey);
    return $crypt;

});

// Setup Hansel & Gretel breadcrumbs ))

$di->set('breadcrumbs', '\Plugins\Breadcrumbs\Breadcrumbs');

// Setup Searcher component

$di->set('searcher', 'Searcher\Searcher');

// Component Navigation. Manage site navigation

$di->setShared('navigation', function () {

    require_once APP_PATH . '/config/navigation.php';

    if (isset($navigation[self::MODULE]))
        return new \Libraries\Navigation\Navigation(new \Phalcon\Config($navigation[self::MODULE]));

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
