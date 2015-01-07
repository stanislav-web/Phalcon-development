<?php
namespace Modules\Frontend\Controllers;

/**
 * Class ControllerBase
 * @package    Frontend
 * @subpackage    Modules\Frontend\Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Controllers/ControllerBase.php
 */
class ControllerBase extends \Phalcon\Mvc\Controller
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
     * After detected router setup parameters
     *
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     *
     * @return null
     */
    public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
    {

        // find current engine
        if($this->session->has('engine') === false) {
            $this->engine   =   \Models\Engines::findFirst("host = '".$this->request->getHttpHost()."'");
        }

        if($this->engine !== false) {

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

            // collect to the session
            $this->session->set('engine', $this->engine);

        }
    }

    /**
     * initialize() Initial all global objects
     * @access public
     * @return null
     */
    public function initialize()
    {
        // get current engine

        $this->engine   =   $this->session->get('engine');

        // add styles minified

        $css = $this->assets->collection('header-css')
            ->addCss('assets/plugins/bootstrap/bootstrap.min.css')
            ->addCss('assets/frontend/'.strtolower($this->engine->getCode()).'/style.css')
            ->join(true);

        $css->addFilter(new \Phalcon\Assets\Filters\Cssmin());
        $css->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/style.min.css');
        $css->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/style.min.css');

        // add java scripts minified

        $js = $this->assets->collection('header-js')
            ->addJs('assets/plugins/angular/angular.min.js')
            ->addJs('assets/plugins/angular/angular-route.min.js')
            ->addJs('assets/plugins/jquery/jquery.min.js')
            //->addJs('assets/plugins/bootstrap/bootstrap.min.js')
            ->addJs('assets/frontend/'.strtolower($this->engine->getCode()).'/app.js')
            ->join(true);

        $js->addFilter(new \Phalcon\Assets\Filters\Jsmin());
        $js->setTargetPath('assets/frontend/'.strtolower($this->engine->getCode()).'/js.min.js');
        $js->setTargetUri('assets/frontend/'.strtolower($this->engine->getCode()).'/js.min.js');

        // load configurations
        $this->config = $this->di->get('config');
    }
}
