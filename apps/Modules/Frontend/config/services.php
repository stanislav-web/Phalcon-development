<?php

    // Tuning components for the module dependencies FrontEnd

    // Dispatch register
    $di->set('dispatcher', function() use ($di) {

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) {

            switch ($exception->getCode()) {
                case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward([
                        'module'        => 'Frontend',
                        'namespace' 	=> 'Modules\Frontend\Controllers\\',
                        'controller'    => 'error',
                        'action'        => 'notFound',
                    ]);
                    return false;

                    break;
                default:

                    $dispatcher->forward([
                        'module'        => 'Frontend',
                        'namespace' 	=> 'Modules\Frontend\Controllers\\',
                        'controller'    => 'error',
                        'action'        => 'uncaughtException',
                    ]);
                    return false;
                    break;
            }
        });
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        $dispatcher->setDefaultNamespace('Modules\Frontend\Controllers');
        return $dispatcher;
    }, true);

    // Registration of component representations (Views)

    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir(APP_PATH.'/Modules/Frontend/views/');
        return $view;
    });

    // Component URL is used to generate all kinds of addresses in the annex

    $di->set('url', function() {

        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($this->_config->application->baseUri);
        return $url;

    });

    // Компонент DB. Регистрирую коннект к MySQL

    $di->setShared('db', function() {

        return new \Phalcon\Db\Adapter\Pdo\Mysql([
            "host"          => 	$this->_config->database->host,
            "username"      => 	$this->_config->database->username,
            "password"      => 	$this->_config->database->password,
            "dbname"        => 	$this->_config->database->dbname,
            "persistent"    => 	$this->_config->database->persistent,
            "options" => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$this->_config->database->charset}'",
                PDO::ATTR_CASE 		=> PDO::CASE_LOWER,
                PDO::ATTR_ERRMODE	=> PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            )
        ]);
    });

    // Component Session. Starting a Session
    $di->setShared('session', function() {

        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;

    });


