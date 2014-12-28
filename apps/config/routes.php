<?php
/**
 * Setup router
 */

// Frontend routes

$router->add('/', [
    'module' => "Frontend",
    'controller' => "index",
    'action' => "index",
    'namespace' => 'Modules\Frontend\Controllers',
])->setName('front-index');

$router->add('/:controller', [
    'module' => "Frontend",
    'controller' => 1,
    'action' => "index",
    'namespace' => 'Modules\Frontend\Controllers',
])->setName('front-controller');

$router->add('/:controller/:action/:params', [
    'module' => "Frontend",
    'controller' => 1,
    'action' => 2,
    'params' => 3,
    'namespace' => 'Modules\Frontend\Controllers',
])->setName('front-full');

// Backend routes

$router->add('/dashboard', [
    'module' => "Backend",
    'controller' => "dashboard",
    'action' => "index",
    'namespace' => 'Modules\Backend\Controllers',
])->setName('dashboard');

$router->add('/dashboard/:controller', [
    'module' => "Backend",
    'controller' => 1,
    'action' => "index",
    'namespace' => 'Modules\Backend\Controllers',
])->setName('dashboard-controller');

$router->add('/dashboard/:controller/:action/:params', [
    'module' => "Backend",
    'controller' => 1,
    'action' => 2,
    'params' => 3,
    'namespace' => 'Modules\Backend\Controllers',
])->setName('dashboard-full');



