<?php
namespace Modules\Backend\Controllers;
use Models\Engines,
	\Phalcon\Mvc\View;
use Modules\Backend;
use Phalcon\Exception;

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
		$this->cacheKey	=	md5(Backend::MODULE.self::NAME.$this->router->getControllerName().$this->router->getActionName());

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
	public function newAction()
	{
		//...
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
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}

