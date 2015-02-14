<?php
namespace Application\Modules\Backend\Controllers;

use Application\Models\Users;
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
     * Config service
     *
     * @var \Phalcon\Config $config
     */
    protected $config;

    /**
     * Logger service
     *
     * @var \Phalcon\Logger\Adapter\File $logger
     */
    protected $logger;

    /**
     * Logger service
     * @var \Application\Plugins\Breadcrumbs\Breadcrumbs $breadcrumbs
     */
    protected $breadcrumbs;

    /**
     * From `users` table auth data
     *
     * @var array
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

        //auth token
        if ($this->cookies->has('remember')) {

            // if user was remembered
            $userId = $this->cookies->get('remember')->getValue();
            $rememberToken = $this->cookies->get('rememberToken')->getValue();

            $users = new Users();
            $user = $users->findFirst([
                "id = ?0",
                "bind" => [$userId]
            ]);

            // create user auth token
            $userToken = md5($user->getPassword() . $user->getToken());

            // set authentication for logged user

            if ($rememberToken == $userToken)
                $this->session->set('auth', $user);
        }

        $auth = $this->session->get('auth');

        // if the user is logged in

        if ($auth === null) {

            $this->flashSession->error("You don't have access");
            // dispatch to login page
            return $dispatcher->forward([
                'controller' => 'auth',
                'action' => 'index',
            ]);
        }

        $this->user = $auth;
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
        // load configurations
        $this->config = $this->di->get('config');
        if ($this->di->has('logger')) {
            $this->logger = $this->di->get('logger');
        }

        // setup breadcrumbs
        $this->breadcrumbs = $this->di->get('breadcrumbs');

        // setup navigation

        $navigation = $this->di->get('navigation');

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
            'breadcrumbs' => $this->breadcrumbs,
            'navigation' => $navigation,
            'search' => new Forms\SearcherForm()
        ]);
    }
}
