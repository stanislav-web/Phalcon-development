<?php
/**
 * BE CAREFUL!
 * This section contains the settings of application routes
 */

$router = new \Phalcon\Mvc\Router(true);
$router->removeExtraSlashes(true)
    ->setDefaults([
        'module' => 'Frontend',
        'controller' => 'index',
        'action' => 'index'
    ]);

$router->add('/', [
    'module' => "Frontend",
    'controller' => 'index',
    'action' => "index",
    'namespace' => 'Application\Modules\Frontend\Controllers',
])->setName('front');

$router->add("/contacts", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'contacts',
    'namespace' => 'Application\Modules\Frontend\Controllers',
])->setName("front-contacts");

$router->add("/help", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'help',
    'namespace' => 'Application\Modules\Frontend\Controllers',
])->setName("front-help");

$router->add("/agreement", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'agreement',
    'namespace' => 'Application\Modules\Frontend\Controllers',
])->setName("front-agreement");

$router->add("/about", [
    'module'        => "Frontend",
    'controller'    => 'index',
    'action'        => 'static',
    'page'         => 'about',
    'namespace' => 'Application\Modules\Frontend\Controllers',
])->setName("front-about");

$router->add('/:controller/:action/:params', [
    'module' => "Frontend",
    'controller' => 1,
    'action' => 2,
    'params' => 3,
    'namespace' => 'Application\Modules\Frontend\Controllers',
])->setName('front-full');
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