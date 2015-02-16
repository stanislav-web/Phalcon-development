<?php
namespace Application\Modules\Backend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class UsersController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/system/UsersController.php
 */
class UsersController extends ControllerBase
{
    /**
     * Controller name
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Users';

    /**
     * initialize() Initialize constructor
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle(' - ' . DashboardController::NAME);
        $this->breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));

    }

    public function indexAction()
    {
        $this->tag->prependTitle(self::NAME);

        // add crumb to chain (name, link)
        $this->breadcrumbs->add(self::NAME);
    }

    public function rolesAction()
    {
        $this->tag->prependTitle(self::NAME);

        // add crumb to chain (name, link)
        $this->breadcrumbs->add(self::NAME);
    }
}