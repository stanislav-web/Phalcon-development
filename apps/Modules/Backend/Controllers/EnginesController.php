<?php
namespace Modules\Backend\Controllers;
use Models\Engines,
	Models\Currency,
	Phalcon\Mvc\View,
	Modules\Backend\Forms;

/**
 * Class EnginesController
 * @package 	Backend
 * @subpackage 	Modules\Backend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Controllers/EnginesController.php
 */
class EnginesController extends ControllerBase
{
	/**
	 * Controller name
	 * @use for another Controllers to set views , paths
	 * @const
	 */
	const NAME	=	'Engines';

	/**
	 * Cache key
	 * @use for every action
	 * @access public
	 */
	public $cacheKey	=	false;

	/**
	 * initialize() Initialize constructor
	 * @access public
	 * @return null
	 */
	public function initialize()
	{
		parent::initialize();
		$this->tag->setTitle(' - '.DashboardController::NAME);

		// create cache key
		$this->cacheKey	=	md5(\Modules\Backend::MODULE.self::NAME.$this->router->getControllerName().$this->router->getActionName());

		$this->_breadcrumbs->add(DashboardController::NAME, $this->url->get(['for' => 'dashboard']));
	}

	/**
	 * Get list of all engines
	 * @return null
	 */
    public function indexAction()
    {
		$title = ucfirst(self::NAME);
		$this->tag->prependTitle($title);

		// add crumb to chain (name, link)

		$this->_breadcrumbs->add($title);

		// get all records

		$engines = (new Engines())->get();

		$this->view->setVars([
			'items'	=>	$engines,
			'title'	=>	$title,
		]);
	}

	/**
	 * Shows the view to create a "new" engine
	 */
	public function addAction()
	{
		try {
			// handling POST data
			if($this->request->isPost())
			{

				$engines	=
						(new Engines())
							->setName($this->request->getPost('name'))
							->setDescription($this->request->getPost('description'), null, '')
							->setHost($this->request->getPost('host'))
							->setCode($this->request->getPost('code'))
							->setCurrencyId($this->request->getPost('currency_id', null, 1))
							->setStatus($this->request->getPost('status', null, 0));

				if(!$engines->create())
				{
					// the store failed, the following message were produced
					foreach($engines->getMessages() as $message)
						$this->flashSession->error((string) $message);

					// forward does not working correctly with this  action type
					// by the way this handle need to remove in another action (
					return
						$this->response->redirect([
							'for' 			=>	'dashboard-full',
							'controller'	=>	$this->router->getControllerName(),
							'action'		=>	$this->router->getActionName()
						]);
				}
				else
				{
					// saved successfully
					$this->flashSession->success('The engine was successfully added!');

					// forward does not working correctly with this  action type
					// by the way this handle need to remove in another action (
					return
						$this->response->redirect([
							'for' 			=>	'dashboard-full',
							'controller'	=>	$this->router->getControllerName(),
						]);
				}
			}

			// build meta data
			$title = 'Add';
			$this->tag->prependTitle($title.' - '.self::NAME);

			// add crumb to chain (name, link)
			$this->_breadcrumbs->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))
				->add($title);
			$this->view->setVars([
				'title'	=>	$title,
				'form'	=>	(new Forms\AddEngineForm(null, Currency::find()))
			]);
		}
		catch(\Phalcon\Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Edit engine action
	 * @return null
	 */
	public function editAction()
	{
		try {
			$id = $this->dispatcher->getParams()[0];

			$engine = Engines::findFirst($id);

			if($engine)
			{
				// build meta data
				$title = $engine->getName();
				$this->tag->prependTitle($title);

				// add crumb to chain (name, link)
				$this->_breadcrumbs->add(self::NAME, $this->url->get(['for' => 'dashboard-controller', 'controller' => 'engines']))
									->add($title);

				$this->view->setVars([
					'item'	=>	$engine,
					'title'	=>	$title,
				]);
			}

		}
		catch(\Phalcon\Exception $e) {
			echo $e->getMessage();
		}
	}
}
