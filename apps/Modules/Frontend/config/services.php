<?php

// Component URL is used to generate all kinds of addresses in the annex

$di->set('url', function () {

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($this->_config->application->baseUri)
        ->setBasePath(DOCUMENT_ROOT);

    return $url;

});

