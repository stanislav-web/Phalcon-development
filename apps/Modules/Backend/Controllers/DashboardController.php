<?php
namespace Modules\Backend\Controllers;

/**
 * Class DashboardController
 * @package 	Backend
 * @subpackage 	Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/DashboardController.php
 */
class DashboardController extends ControllerBase
{
	/**
	 * initialize() Initialize constructor
	 * @access public
	 * @return null
	 */
	public function initialize()
	{
		parent::initialize();
		$this->tag->setTitle('Dashboard');
	}

    public function indexAction()
    {

    }
}

