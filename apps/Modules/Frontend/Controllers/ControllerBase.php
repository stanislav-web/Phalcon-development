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
     * @var \Phalcon\Di > Config
     */
    protected $config;

    /**
     * @var \Models\Engines
     */
    protected $engine;

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
     * @access public
     * @return null
     */
    public function initialize()
    {
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

            // get config
            $this->config = $this->di->get('config');

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

        // load configurations
        $this->config = $this->di->get('config');

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
            ->addJs('assets/plugins/angular/ui-bootstrap-tpls-0.12.0.min.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/spinner.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/app.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/config.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/splash.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/controllers/menu.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/controllers/language.js');

        if (APPLICATION_ENV === 'production') {

            // glue and minimize scripts header

            $jsh->join(true);
            $jsh->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            $jsh->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js-hover.min.js');
            $jsh->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js-hover.min.js');

        }

        $jsf = $this->assets->collection('footer-js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/menu.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/move-top.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/easing.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/js/rules.js')
            ->addJs('assets/plugins/spinner/spin.min.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app/controllers/index.js');

        if (APPLICATION_ENV === 'production') {

            // glue and minimize scripts footer

            $jsf->join(true);
            $jsf->addFilter(new \Phalcon\Assets\Filters\Jsmin());
            $jsf->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js-footer.min.js');
            $jsf->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js-footer.min.js');

        }

        return;
    }
}
