<?php
namespace Modules\Backend\Controllers;

use Phalcon\Mvc\Controller,
	Phalcon\Mvc\View,
	Phalcon\Breadcrumbs,
	Phalcon\Mvc\Url,
	Models\Users;
	//\ElasticSearch\Client;


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
		 * Logger service
		 * @var object Libraries\Breadcrumbs
		 */
		$_breadcrumbs	=	false,

		/**
		 * Global records limit per page
		 * @var int
		 */
		$_limitRecords	=	10,

		/**
		 * From `users` table auth data
		 * @var array
		 */
		$_user		=	[];

	/**
	 * beforeExecuteRoute($dispatcher) before init route
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
				'controller' 	=> 'auth',
				'action' 		=> 'index',
			]);
		}

		$this->_user	=	$auth;
	}

	/**
	 * After route executed event
	 * Setup actions json responsibility
	 *
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 * @access public
	 * @return null
	 */
	public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
	{
		// setup only layout to show before load ajax
		// disable action view as default
		$this->view->disableLevel([
			View::LEVEL_ACTION_VIEW	=>	true,
		]);

		if($this->request->isAjax() == true)
		{
			// disable layouts
			$this->view->disableLevel([
				View::LEVEL_LAYOUT		=>	true,
				View::LEVEL_MAIN_LAYOUT	=>	true,
			]);

			// return clean current template width variable
			return $this->view->getRender(
				$dispatcher->getControllerName(), 	//	render Controller
				$dispatcher->getActionName()		//	render Action
			);
		}
	}

	/**
	 * initialize() Initial all global objects
	 * @access public
	 * @return null
	 */
	public function initialize()
	{

		/**
		 * @TODO Global Search library
		 */
		$s = (new \Phalcon\Searcher\Searcher())->setSearchList([
			'\Models\Categories'	=>	['title', 'description', 'alias'],
			'\Models\Currency'		=>	['code', 'name'],
			'\Models\Engines'		=>	['host', 'name', 'description'],
			'\Models\Users'			=>	['login', 'name', 'surname'],
		])->setQuery('qqqq')->getResult();


		// load configurations
		$this->_config	=	$this->di->get('config');
		if($this->_config->logger->enable)
			$this->_logger	=	$this->di->get('logger');

		// setup breadcrumbs
		$this->_breadcrumbs	=	$this->di->get('breadcrumbs');

		// setup navigation

		$navigation = $this->di->get('navigation');

		$navigation->setActiveNode(
			$this->router->getActionName(),
			$this->router->getControllerName(),
			$this->router->getModuleName()
		);

		if(APPLICATION_ENV == 'development')
		{	// add toolbar to the layout
			$toolbar = new \Fabfuel\Prophiler\Toolbar($this->di->get('profiler'));
			$toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
			$this->view->setVar('toolbar', $toolbar);
		}

		// global view variables
		$this->view->setVars([
			'user'			=>	$this->_user,
			'breadcrumbs'	=>	$this->_breadcrumbs,
			'navigation'	=>	$navigation,
		]);
	}
}
