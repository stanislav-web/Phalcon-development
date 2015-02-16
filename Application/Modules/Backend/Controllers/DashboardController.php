<?php
namespace Application\Modules\Backend\Controllers;

use Phalcon\Mvc\View;

/**
 * Class DashboardController
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/DashboardController.php
 */
class DashboardController extends ControllerBase
{
    /**
     * Controller name
     *
     * @use for another Controllers to set views , paths
     * @const
     */
    const NAME = 'Dashboard';

    /**
     * Cache key
     * @use for every action
     * @access public
     */
    public $cacheKey = false;

    /**
     * initialize() Initialize constructor
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        $this->tag->setTitle(self::NAME);

        // create cache key
        $this->cacheKey = md5(
            $this->router->getModuleName()
            . $this->router->getControllerName()
            . $this->router->getActionName()
        );
    }

    public function indexAction()
    {

        //if($this->view->getCache()->exists($this->cacheKey))
        //{
        // add crumb to chain
        $this->breadcrumbs->add(self::NAME);

        //}
        //$this->view->cache(['key' => $this->cacheKey]);
    }

    public function profileAction()
    {
        //if($this->view->getCache()->exists($this->cacheKey))
        //{
        // add crumb to chain
        $this->breadcrumbs->add(self::NAME);
        //}
        //$this->view->cache(['key' => $this->cacheKey]);
    }
}

