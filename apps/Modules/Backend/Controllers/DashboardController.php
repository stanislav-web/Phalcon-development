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

    public function indexAction()
    {
		exit('sdsd');
    }

	public function loginAction()
	{

		$login = $this->request->getPost('login');
		$password = $this->request->getPost('password');

		$user = Users::findFirstByLogin($login);
		if ($user) {
			if ($this->security->checkHash($password, $user->password)) {
				//The password is valid
			}
		}

		//The validation has failed
	}

}

