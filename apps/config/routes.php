<?php
/**
 * Setup router
 */

// Frontend routes

$router->add('/', [
    'module' => "Frontend",
    'controller' => 'index',
    'action' => "index",
    'namespace' => 'Modules\Frontend\Controllers',
])->setName('front');

$router->add("/contacts", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'contacts',
    'namespace' => 'Modules\Frontend\Controllers',
])->setName("front-contacts");

$router->add("/help", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'help',
    'namespace' => 'Modules\Frontend\Controllers',
])->setName("front-help");

$router->add("/sign", [
    'module'        => "Frontend",
    'controller'    => 'sign',
    'action'        => 'index',
    'namespace' => 'Modules\Frontend\Controllers',
])->setName("front-sign");

$router->add("/agreement", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'agreement',
    'namespace' => 'Modules\Frontend\Controllers',
])->setName("front-agreement");

$router->add("/about", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'about',
    'namespace' => 'Modules\Frontend\Controllers',
])->setName("front-about");

$router->add('/logout', [
    'module' => "Frontend",
    'controller' => "sign",
    'action' => "logout",
    'namespace' => 'Modules\Frontend\Controllers',
])->setName('logout');

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