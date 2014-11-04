<?php

/**
 * Define stage of application
 */
defined('APPLICATION_ENV') ||
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
defined('PUBLIC_PATH') || define('PUBLIC_PATH', dirname(__FILE__));
defined('APP_PATH') || define('APP_PATH', realpath(dirname(__FILE__) . '/../apps'));

try {

    /**
     * Read the configuration
     */
    $config = require_once APP_PATH."/config/application.php";

    /**
     * Read auto-loader
     */
    require_once APP_PATH."/config/loader.php";

    /**
     * Read services
     */
    require_once APP_PATH."/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
