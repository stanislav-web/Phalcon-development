<?php
namespace Modules\Backend\Controllers;
use Phalcon\Mvc\Controller;

/**
 * Class LoginController
 * @package 	Backend
 * @subpackage 	Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/LoginController.php
 */
class LoginController extends Controller
{
	/**
	 * From `users` table auth data
	 * @var bool
	 */
	protected $_user = [];
	
	public function indexAction()
	{
		$login = $this->request->getPost('login');
		$password = $this->request->getPost('password');

		//$user = Users::findFirstByLogin($login);
		//if ($user) {
		//	if ($this->security->checkHash($password, $user->password)) {
				//The password is valid
		//	}
		//}
		//The validation has failed
		$this->view->setMainView('non-auth-layout');
	}
}

