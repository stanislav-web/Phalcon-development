<?php
namespace Modules\Backend\Controllers;
use Phalcon\Mvc\Controller,
	Models\Users;

/**
 * Class AuthController
 * @package 	Backend
 * @subpackage 	Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/AuthController.php
 */
class AuthController extends Controller
{
	protected

		/**
		 * Config service
		 * @var object Phalcon\Config
		 */
		$_config = false,

		/**
		 * Logger service
		 * @var object Phalcon\Logger\Adapter\File
		 */
		$_logger	=	false;

	/**
	 * initialize() Initial all global objects
	 * @access public
	 * @return null
	 */
	public function initialize()
	{
		// load configures
		$this->_config	=	$this->di->get('config');

		if($this->_config->logger->enable)
			$this->_logger	=	$this->di->get('logger');

		// set default page title
		$this->tag->setTitle('Authenticate');
	}

	public function indexAction()
	{
		if($this->request->isPost())
		{
			if($this->security->checkToken())
			{
				// The token is ok, check authorization

				$login 		= $this->request->getPost('username');
				$password 	= $this->request->getPost('password');
				$remember 	= $this->request->getPost('remember');
				$users		=	new Users();
				$user = $users->findFirst([
					"login = ?0",
					"bind" => [$login]
				]);
				if($user)
				{
					if($this->security->checkHash($password, $user->getPassword()))
					{
						// Check if the "remember me" was selected
						if(isset($remember))
						{
							$this->cookies->set('remember', $user->getId(), time() + $this->_config->rememberKeep);
							$this->cookies->set('rememberToken',
								md5($user->getPassword() . $user->getSalt()),
								time() + $this->_config->rememberKeep);
						}

						// set authentication for logged user
						$this->session->set('auth', $user);

						// update auth params
						$user->setDateLastvisit(date('Y-m-d H:i:s'))
								->setIp($this->request->getClientAddress())
								->setUa($this->request->getUserAgent())
								->save();

						$referrer = parse_url($this->request->getHTTPReferer(), PHP_URL_PATH);

						if($this->_logger)
							$this->_logger->log('Authenticate success from '.$this->request->getClientAddress());

						// full http redirect to the referrer page
						if($referrer != $this->request->getURI())
							return $this->response->redirect($referrer);
						else
							return $this->response->redirect('dashboard');
					}
					else
					{
						// Wrong authenticate data (password or login)
						$this->flashSession->error("Wrong authenticate data");

						if($this->_logger)
						{
							$this->_logger->error('Authenticate failed from '.$this->request->getClientAddress().'. Wrong authenticate data');
						}

						$this->response->redirect('dashboard/auth');
						$this->view->disable();
					}
				}
				else
				{
					// user does not exist in database
					$this->flashSession->error("The user not found");


					if($this->_logger)
						$this->_logger->error('Authenticate failed from '.$this->request->getClientAddress().'. The user '.$login.' not found');

					$this->response->redirect('dashboard/auth');
					$this->view->disable();
				}
			}
			else
			{
				// CSRF protection

				if($this->_logger)
					$this->_logger->error('Authenticate failed from '.$this->request->getClientAddress().'. CSRF attack');

				$this->flashSession->error("Invalid access token");
				$this->response->redirect('dashboard/auth');
				$this->view->disable();
			}
		}
		$this->view->setMainView('non-auth-layout');
	}
}

