<?php

namespace Application\Modules\Rest\Routes;

use \Phalcon\Mvc\Router\Group;

/**
 * Api. Api router component
 *
 * @package Application\Modules\Rest
 * @subpackage Routes
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Frontend/Routes/Pages.php
 */
class Api extends Group {

    /**
     * Initialize routes for dynamic pages
     */
    public function initialize()
    {
        // Default parameters

        $this->setPaths([
            'module'    => 'Rest',
        ]);

        // Like a start prefix
        $this->setPrefix('/api');

        // Add route
        $this->add('/:controller/:action/:params', [
            'namespace' => 'Application\Modules\Rest\Controllers',
            'controller' => 1,
            'action'    => 2,
            'params'    => 3,
        ])->via(['GET', 'POST', 'PUT', 'DELETE']);
    }
}