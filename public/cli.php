<?php
/**
 * @define Document root
 * @define Application path
 * @define Staging development environment
 */

use Phalcon\CLI\Console as Console;

// Require definitions
defined('DOCUMENT_ROOT') || define('DOCUMENT_ROOT', __DIR__.'/../');
defined('APP_PATH') || define('APP_PATH', DOCUMENT_ROOT . 'Application');
defined('APPLICATION_ENV') || define('APPLICATION_ENV','production');

// Require composite libraries
require_once DOCUMENT_ROOT . 'vendor/autoload.php';

// Require global configurations
require_once DOCUMENT_ROOT . 'config/application.php';

// Require cli services
require_once DOCUMENT_ROOT . 'config/cli.php';
error_reporting(7);
ini_set('display_errors', 'On');
// Register console tasks
$di->get('ConsoleTasks')->register();

// Create a console application
$console = new Console();
$console->setDI($di);

// Determine the console case
$arguments = [];
$params = [];

foreach($argv as $k => $arg) {
    if($k == 1)
        $arguments['task'] = $arg;
    elseif($k == 2)
        $arguments['action'] = $arg;
    elseif($k >= 3)
        $params[] = $arg;
}
if(count($params) > 0) {
    $arguments['params'] = $params;
}

// Adding support console service
$di->setShared('console', $console);

// Define current task point
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));

try {
    // Handle the console request
    $console->handle($arguments);
}
catch (\Phalcon\Exception $e) {

    echo $di->get('color')->error($e->getMessage());
}