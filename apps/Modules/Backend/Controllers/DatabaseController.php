<?php
namespace Modules\Backend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class DatabaseController
 * @package    Backend
 * @subpackage    Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/system/DatabaseController.php
 */
class DatabaseController extends ControllerBase
{
    /**
     * Controller name
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Database';

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle(' - ' . DashboardController::NAME);
        $this->_breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));
    }

    public function indexAction()
    {
        $this->tag->prependTitle(self::NAME);

        // add crumb to chain (name, link)
        $this->_breadcrumbs->add(self::NAME);
    }
}