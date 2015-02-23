<?php
namespace Application\Modules\Backend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class DashboardController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/DashboardController.php
 */
class DashboardController extends ControllerBase
{

    /**
     * @const Basic virtual dir name
     */
    const NAME = 'Dashboard';

    /**
     * initialize() Initialize constructor
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {

    }
}

