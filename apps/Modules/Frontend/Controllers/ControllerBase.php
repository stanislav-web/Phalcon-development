<?php
namespace Modules\Frontend\Controllers;

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
        if (APPLICATION_ENV === 'development') {

            // add toolbar to the layout

            $toolbar = new \Fabfuel\Prophiler\Toolbar($this->di->get('profiler'));
            $toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
            $this->view->setVar('toolbar', $toolbar);
        }

        // load configurations
        $this->config = $this->di->get('config');

        $this->engine   =   $this->session->get('engine');
    }
}
