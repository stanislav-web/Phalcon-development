<?php

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

