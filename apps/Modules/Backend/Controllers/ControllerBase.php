<?php
namespace Modules\Backend\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 * @package 	Backend
 * @subpackage 	Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
	/**
	 * From `users` table auth data
	 * @var bool
	 */
	protected $_user = [];

	/**
	 * beforeExecuteRoute($dispatcher) Pre init application
	 *
	 * @param $dispatcher
	 * @return bool
	 */
	public function beforeExecuteRoute($dispatcher)
	{
		//auth token
		$auth = $this->session->get('auth');

		//if the user is logged in
		if(!$auth)
		{
			$this->flash->error("You don't have access");

			// dispatch to login page
			$dispatcher->forward([
				'controller' 	=> 'login',
				'action' 		=> 'index',
				"params" 		=> ['refer' => $this->request->getHTTPReferer()]
			]);

			//Returning false means that execute the action must be aborted
			return false;
		}
	}
}
