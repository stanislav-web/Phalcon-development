<?php
/**
 * BE CAREFUL!
 * This section contains the settings of application routes
 */
use \Phalcon\Mvc\Router;

$router = new Router(true);
$router->removeExtraSlashes(true);
$router->mount(new Application\Modules\Rest\Routes());
