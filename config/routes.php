<?php
/**
 * BE CAREFUL!
 * This section contains the settings of application routes
 */

$router = new \Phalcon\Mvc\Router(true);

$router->removeExtraSlashes(true);

$router->mount(new Application\Modules\Backend\Routes\Dashboard());
$router->mount(new Application\Modules\Frontend\Routes\Pages());
$router->mount(new Application\Modules\Rest\Routes\Api());