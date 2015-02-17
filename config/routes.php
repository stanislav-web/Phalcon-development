<?php
/**
 * BE CAREFUL!
 * This section contains the settings of application routes
 */

$router = new \Phalcon\Mvc\Router(false);
$router->removeExtraSlashes(true)
    ->setDefaults([
        'module' => 'Frontend',
        'controller' => 'index',
        'action' => 'index'
    ]);

$router->add('/:controller/:action/:params', [
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
    'module' => "Frontend",
    'namespace' => 'Application\Modules\Frontend\Controllers',
]);

// Backend routes

$router->add('/dashboard', [
    'module' => "Backend",
    'controller' => "dashboard",
    'action' => "index",
    'namespace' => 'Application\Modules\Backend\Controllers',
])->setName('dashboard');

$router->add('/dashboard/:controller', [
    'module' => "Backend",
    'controller' => 1,
    'action' => "index",
    'namespace' => 'Application\Modules\Backend\Controllers',
])->setName('dashboard-controller');

$router->add('/dashboard/:controller/:action/:params', [
    'module' => "Backend",
    'controller' => 1,
    'action' => 2,
    'params' => 3,
    'namespace' => 'Application\Modules\Backend\Controllers',
])->setName('dashboard-full');