<?php
namespace Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * Class ControllerBase
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Config service
     * @var object Phalcon\Config
     */
    protected $config = false;

    /**
     * Auth user
     * @var object Models\Users
     */
    protected $user = null;

    /**
     * Logger service
     * @var object Phalcon\Logger\Adapter\File
     */
    protected $logger = false;

    /**
     * @var \Models\Engines
     */
    protected $engine;

    /**
     * Ping response as Json
     * @var array
     */
    protected $responseMsg = [];

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

        if($this->user === null) {
            $this->user = $this->session->get('user');
        }

        // load logger
        if ($this->config->logger->enable === true) {
            $this->logger = $this->di->get('logger');
        }

        // find current engine
        if($this->session->has('engine') === false) {

            $this->engine   =   \Models\Engines::findFirst("host = '".$this->request->getHttpHost()."'");

            // collect to the session
            $this->session->set('engine', $this->engine);
        }
        else {
            // get current engine

            $this->engine   =   $this->session->get('engine');
        }

        if($this->engine !== null) {

            // setup app title
            $this->tag->setTitle($this->engine->getName());

            // setup special view directory for this engine
            $this->view->setViewsDir($this->config['application']['viewsFront'].strtolower($this->engine->getCode()))
                ->setMainView('layout')
                ->setPartialsDir('partials');

            // setup to all templates
            $this->view->setVar('engine', $this->engine->toArray());

            // add scripts & stylesheets
            $this->addAssetsContent();
        }

        // check user data
        if($this->user !== null) {

            // verify cookie salt
            $salt = md5($this->user->getLogin().$this->request->getUserAgent().$this->user->getSalt());

            if($this->cookies->has($salt) === true) {

                // success! user is logged in the system
                // $this->user - get all user data

                $this->responseMsg = [
                    'user' =>   $this->user->toArray(),
                ];

                $this->view->setVar('user', $this->user->toArray());
            }
        }

        // load configurations

        if (APPLICATION_ENV === 'development') {

            // add toolbar to the layout
            $toolbar = new \Fabfuel\Prophiler\Toolbar($this->di->get('profiler'));
            $toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
            $this->view->setVar('toolbar', $toolbar);

        }
    }


    /**
     * Add assets content
     *
     * @access protected
     * @return null
     */
    private function addAssetsContent() {

        // add styles minified
        $css = $this->assets->collection('header-css')
            ->addCss('assets/plugins/bootstrap/bootstrap.min.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/css/style.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/css/menu.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/css/splash.css')
            ->setAttributes(['media' => 'all']);

        // add java scripts minified

        $jsh = $this->assets->collection('header-js')
            ->addJs('assets/plugins/store/store.min.js')
            ->addJs('assets/plugins/angular/angular.min.js')
            ->addJs('assets/plugins/angular/angular-route.min.js')
            ->addJs('assets/plugins/angular/angular-animate.min.js')
            ->addJs('assets/plugins/angular/angular-sanitize.min.js')
            ->addJs('assets/plugins/angular/angular-translate.min.js')
            ->addJs('assets/plugins/angular/angular-translate-loader-partial.min.js')
            ->addJs('assets/plugins/angular/angular-cookies.min.js')
            ->addJs('assets/plugins/angular/angular-spinner.min.js')
            ->addJs('assets/plugins/jquery/jquery.min.js')
            ->addJs('assets/plugins/bootstrap/bootstrap.min.js')
            ->addJs('assets/plugins/angular/ui-bootstrap-tpls-0.12.0.min.js');

        if (APPLICATION_ENV === 'production') {

            // glue and minimize scripts header

            $jsh->join(true);
            $jsh->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            $jsh->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js-hover.min.js');
            $jsh->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js-hover.min.js');

        }

        $jsf = $this->assets->collection('footer-js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/app.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/config.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/directives/spinner.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/services/splash.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/authenticate/services/auth.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/controllers/menu.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/controllers/language.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/common/controllers/index.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/authenticate/controllers/sign.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/menu.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/move-top.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/easing.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/rules.js')
            ->addJs('assets/plugins/spinner/spin.min.js');

        if (APPLICATION_ENV === 'production') {

            // glue and minimize scripts footer

            $jsf->join(true);
            $jsf->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            $jsf->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js-footer.min.js');
            $jsf->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js-footer.min.js');

        }

        return;
    }

    /**
     * Clear all auth user data
     *
     * @access protected
     * @return null
     */
    protected function clearUserData() {


        if(isset($this->user) && $this->user !== null) {
            $cookieSalt =  md5($this->user->getLogin().$this->request->getUserAgent().$this->user->getSalt());
        }

        // destroy session data
        if($this->session->has('user')) {

            $this->session->remove('user');
            $this->user = null;
        }

        // destroy cookies
        if(isset($cookieSalt) === true) {

            $this->cookies->get($cookieSalt)->delete();

        }
    }
}
