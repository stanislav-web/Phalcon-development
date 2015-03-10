<?php
namespace Application\Modules\Backend\Routes;

use \Phalcon\Mvc\Router\Group;

/**
 * Pages. Static pages route component
 *
 * @package Application\Modules\Backend
 * @subpackage Routes
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Backend/Routes/Dashboard.php
 */
class Dashboard extends Group {

    /**
     * Initialize routes for dynamic pages
     */
    public function initialize()
    {
        // Default parameters

        $this->setPaths([
            'module'    => 'Backend',
            'namespace' => 'Application\Modules\Backend\Controllers'
        ]);

        // Like a start prefix
        $this->setPrefix('/dashboard');

        $this->add('', [
            'controller' => 'dashboard',
            'action'    => "index",
        ])->setName('dashboard');

        $this->add('/:controller', [
            'controller' => 1,
            'action' => "index",
        ])->setName('dashboard-controller');

        $this->add('/:controller/:action/:params', [
            'controller' => 1,
            'action' => 2,
            'params' => 3,
        ])->setName('dashboard-full');
    }
}