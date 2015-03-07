<?php

namespace Application\Routes;

use \Phalcon\Mvc\Router\Group;

/**
 * Pages. Static pages route component
 *
 * @package Application
 * @subpackage Routes
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Routes/Pages.php
 */
class Pages extends Group {

    /**
     * Initialize routes for dynamic pages
     */
    public function initialize()
    {
        // Default parameters

        $this->setPaths([
            'module'    => 'Frontend',
            'namespace' => 'Application\Modules\Frontend\Controllers'
        ]);

        // Like a start prefix
        $this->setPrefix('/page');

        // Add route
        $this->add('/:params', array(
            'controller' => 'page',
            'action' => 'resolve',
            'params' => 1
        ));
    }
}