<?php
/**
 * BE CAREFUL!
 * This section contains the settings of application routes
 */
use \Phalcon\Mvc\Router;
use \Application\Helpers\OpcodeCache;

if(OpcodeCache::isEnabled() === true && $config['cache']['code'] === true) {

    if(OpcodeCache::exists('routes') === true) {
        $router = OpcodeCache::fetch('routes');
    }
    else {
        $router = new Router(true);
        $router->removeExtraSlashes(true);
        $router->mount(new Application\Modules\Rest\Routes());
        OpcodeCache::store('routes', $router, $config['cache']['lifetime']);
    }
}
else {

    $router = new Router(true);
    $router->removeExtraSlashes(true);
    $router->mount(new Application\Modules\Rest\Routes());
}
