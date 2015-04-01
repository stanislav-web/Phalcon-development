<?php

namespace Application\Modules\Rest\Routes;

use \Phalcon\Mvc\Router\Group;

/**
 * V1. Api router component
 *
 * @package Application\Modules\Rest
 * @subpackage Routes
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Frontend/Routes/V1.php
 */
class V1 extends Group {

    /**
     * Initialize routes Rest V1
     */
    public function initialize()
    {
        $this->setPaths([
            'module'    => 'Rest',
        ]);

        $this->setPrefix('/api');

        $this->addGet('/v1/:controller/:params', [
            'namespace' => 'Application\Modules\Rest\V1\Controllers',
            'controller'    => 1,
            'action'        => 'get',
            'params'        => 2,
        ]);

        $this->addPost('/v1/:controller/:params', [
            'namespace' => 'Application\Modules\Rest\V1\Controllers',
            'controller'    => 1,
            'action'        => 'post',
            'params'        => 2,
        ]);

        $this->addPut('/v1/:controller/:params', [
            'namespace' => 'Application\Modules\Rest\V1\Controllers',
            'controller'    => 1,
            'action'        => 'put',
            'params'        => 2,
        ]);

        $this->addDelete('/v1/:controller/:params', [
            'namespace' => 'Application\Modules\Rest\V1\Controllers',
            'controller'    => 1,
            'action'        => 'delete',
            'params'        => 2,
        ]);
    }
}