<?php

// Navigation menus

$di->set('navigation', function () {

    $navigation =   [];
    require_once APP_PATH . '/Modules/'.self::MODULE.'/config/navigation.php';
    return $navigation;

});

// Component URL is used to generate all kinds of addresses in the annex

$di->set('url', function () {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($this->_config->application->baseUri)
        ->setBasePath(DOCUMENT_ROOT);

    return $url;

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

// Component Session. Starting a Session

$di->setShared('session', function () {
    $session = new \Phalcon\Session\Adapter\Files([
        'host' => $this->_config->cache->memcached->host,        // mandatory
        'port' => $this->_config->cache->memcached->port,        // optional (standard: 11211)
        'lifetime' => $this->_config->cache->lifetime,           // optional (standard: 8600)
        'prefix' => $this->_config->cache->prefix,               // optional (standard: [empty_string]), means memcache key is my-app_31231jkfsdfdsfds3
        'persistent' => false                                    // optional (standard: false)
    ]);
    $session->start();
    return $session;
});

$di->set('cookies', function () {

    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;

});

// Default component to crypt cookies values

$di->set('crypt', function () {

    $crypt = new \Phalcon\Crypt();
    $crypt->setKey($this->_config->cookieCryptKey);
    $crypt->setPadding(\Phalcon\Crypt::PADDING_PKCS7);

    return $crypt;

});