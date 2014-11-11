<?php

	// Tuning up components for the module dependencies BackEnd

	// Component URL is used to generate all kinds of addresses in the annex

	$di->set('url', function() {

    	$url = new \Phalcon\Mvc\Url();
    	$url->setBaseUri($this->_config->application->baseUri);
    	return $url;

	});

	// Database connection is created based in the parameters defined in the configuration file

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
		$session = new Phalcon\Session\Adapter\Memcache([
			'host'          => $this->_config->cache->memcached->host,     	// mandatory
			'port'          => $this->_config->cache->memcached->port,		// optional (standard: 11211)
			'lifetime'      => $this->_config->cache->lifetime,            	// optional (standard: 8600)
			'prefix'        => $this->_config->cache->prefix,         		// optional (standard: [empty_string]), means memcache key is my-app_31231jkfsdfdsfds3
			'persistent'    => false            							// optional (standard: false)
		]);
		$session->start();
		return $session;
	});

	// Component Logger. $this->di->get('logger;)->log('.....',Logger::ERROR);

	$di->set('logger', function() {

		if($this->_config->logger->enable == true)
		{
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
	$di->setShared('flash', function() {

		$flash = new Phalcon\Flash\Session([
			'error'     => 'alert alert-danger',
			'success'   => 'alert alert-success',
			'notice'    => 'alert alert-info',
		]);
		return $flash;

	});

	$di->set('cookies', function() {

		$cookies = new \Phalcon\Http\Response\Cookies();
		$cookies->useEncryption(true);
		return $cookies;

	});

	$di->set('crypt', function() {

		$crypt = new \Phalcon\Crypt();
		$crypt->setKey($this->_config->cookieCryptKey);
		return $crypt;

	});

	/**
 	 * Setup Hanzel & Grettel breadcrumbs ))
 	 */
	$di->set('breadcrumbs', function() {
		return new \Libraries\Breadcrumbs\Breadcrumbs();
	});
