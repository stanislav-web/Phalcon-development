<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\UserRoles;
use Application\Modules\Backend\Forms;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * Class ControllerBase
 *
 * @package    Application\Modules\Backend
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Meta Service
     *
     * @var \Application\Services\Views\MetaService $metaService
     */
    protected $metaService;

    /**
     * Auth user service
     *
     * @uses \Application\Services\AuthService
     * @var \Phalcon\Di
     */
    protected $authService;

    /**
     * Auth user data
     *
     * @var array $user
     */
    protected $user = [];

    /**
     * beforeExecuteRoute($dispatcher) before init route
     *
     * @param $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute($dispatcher)
    {
        // load user data
        $this->authService = $this->getDI()->get("AuthService");

        if($this->authService->isAuth() === true
            && $this->authService->hasRole(UserRoles::ADMIN) === true) {

            // success! user is logged in the system
            $this->user = $this->authService->getUser();

            // define meta service
            $this->metaService = $this->di->get('MetaService');
            $this->metaService
                ->setHomeTitle(DashboardController::NAME)
                ->setTitle($this->dispatcher->getControllerName())
                ->setHomelink($this->url->get(['for' => 'dashboard']));
        }
        else {

            $this->flashSession->error("You don't have access");
            // dispatch to login page
            return $dispatcher->forward([
                'controller' => 'auth',
                'action' => 'index',
            ]);
        }
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
            View::LEVEL_ACTION_VIEW => true,
        ]);

        if ($this->request->isAjax() == true) {
            // disable layouts
            $this->view->disableLevel([
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]);

            // return clean current template width variable
            return $this->view->getRender(
                $dispatcher->getControllerName(),    //	render Controller
                $dispatcher->getActionName()        //	render Action
            );

        }
    }

    /**
     * initialize() Initial all global objects
     *
     * @access public
     * @return null
     */
    public function initialize()
    {
        // setup navigation

        $navigation = $this->getDI()->get('navigation');

        $navigation->setActiveNode(
            $this->router->getActionName(),
            $this->router->getControllerName(),
            $this->router->getModuleName()
        );

        if (APPLICATION_ENV === 'development') {
            // add toolbar to the layout
            $toolbar = new \Fabfuel\Prophiler\Toolbar($this->di->get('profiler'));
            $toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
            $this->view->setVar('toolbar', $toolbar);
        }

        // global view variables
        $this->view->setVars([
            'user' => $this->user,
            'breadcrumbs' => $this->metaService->getBreadcrumbs(),
            'navigation' => $navigation,
            'search' => new Forms\SearcherForm()
        ]);
    }

    /**
     * Setup bread crumbs path
     *
     * @return \Application\Plugins\Breadcrumbs\Breadcrumbs
     */
    protected function setBreadcrumbs() {
        return $this->metaService->getBreadcrumbs();
    }

    /**
     * Get global config
     *
     * @return \Phalcon\Config
     */
    protected function getConfig() {

        return $this->getDI()->get('config');

    }

    /**
     * Controller forward action
     *
     * @return null
     */
    protected function forward() {

        return $this->response->redirect([
            'for' => 'dashboard-full',
            'controller' => $this->router->getControllerName(),
        ]);
    }
}
