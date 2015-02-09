<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\CLI\Console as ConsoleApp;

/**
 * @define Document root
 * @define Application path
 * @define Staging development
 */
defined('DOCUMENT_ROOT') || define('DOCUMENT_ROOT', substr(str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__), 0, -1));
defined('APP_PATH') || define('APP_PATH', DOCUMENT_ROOT . '/../apps');

defined('APPLICATION_ENV') ||
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Require configurations
require_once APP_PATH . '/config/application.php';

// Require composite libraries
require_once DOCUMENT_ROOT . ' /../vendor/autoload.php';


define('VERSION', '1.0.0');

// Create factory container
$di = new CliDI();

// Set global configuration
$di->set('config', function () use ($config) {
    return (new \Phalcon\Config($config));
});

try {

    // Register autoloader

    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            APP_PATH . '/tasks'
        )
    );
    $loader->register();

    // Create console app

    $application = new ConsoleApp();
    $application->setDI($di);

    // Define arguments

    $arguments = array();
    $params = array();

    foreach($argv as $k => $arg) {
        if($k == 1) {
            $arguments['task'] = $arg;
        } elseif($k == 2) {
            $arguments['action'] = $arg;
        } elseif($k >= 3) {
            $params[] = $arg;
        }
    }
    if(count($params) > 0) {
        $arguments['params'] = $params;
    }

    // Define global constants for the current tasks and activities

    define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

    // Handle the request
    $application->handle($arguments);

} catch (\Exception $e) {
    echo $e->getMessage();
    exit(255);

}
