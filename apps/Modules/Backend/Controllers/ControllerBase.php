<?php
namespace Modules\Backend\Controllers;

use Phalcon\Mvc\Controller,
	Models\Users;


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
		$_logger	=	false,

		/**
		 * From `users` table auth data
		 * @var bool
		 *
		 */
		$_user		=	[];

	/**
	 * beforeExecuteRoute($dispatcher) Pre init application
	 *
	 * @param $dispatcher
	 * @return bool
	 */
	public function beforeExecuteRoute($dispatcher)
	{
		//auth token
		if($this->cookies->has('remember'))
		{

			// if user was remembered
			$userId			=	$this->cookies->get('remember')->getValue();
			$rememberToken 	= 	$this->cookies->get('rememberToken')->getValue();

			$users		=	new Users();
			$user = $users->findFirst([
				"id = ?0",
				"bind" => [$userId]
			]);

			// create user auth token
			$userToken 		=	md5($user->getPassword() . $user->getSalt());

			// set authentication for logged user

			if($rememberToken == $userToken)
				$this->session->set('auth', $user);
		}

		$auth = $this->session->get('auth');

		// if the user is logged in

		if(!$auth)
		{
			$this->flashSession->error("You don't have access");
			// dispatch to login page
			return $dispatcher->forward([
				'controller' 	=> 'login',
				'action' 		=> 'index',
			]);
		}

		$this->_user	=	$auth;
	}

	/**
	 * initialize() Initial all global objects
	 * @access public
	 * @return null
	 */
	public function initialize()
	{
		// load configurations

		$this->_config	=	$this->di->get('config');
		if($this->_config->logger->enable)
			$this->_logger	=	$this->di->get('logger');

		// view variables

		$this->view->setVars([
			'user'	=>	$this->_user,
		]);
	}
}
