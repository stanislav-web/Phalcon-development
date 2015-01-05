<?php
namespace Modules\Frontend\Controllers;

class ControllerBase extends \Phalcon\Mvc\Controller
{
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

        $this->engine   =   \Models\Engines::findFirst("host = '".$this->request->getHttpHost()."'");

        if($this->engine !== false) {

            // setup app title
            $this->tag->setTitle($this->engine->getName());
        }
    }

    /**
     * initialize() Initial all global objects
     * @access public
     * @return null
     */
    public function initialize()
    {

        // load configurations
        $this->_config = $this->di->get('config');

        if (APPLICATION_ENV === 'development') {

            // add toolbar to the layout

            $toolbar = new \Fabfuel\Prophiler\Toolbar($this->di->get('profiler'));
            $toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
            $this->view->setVar('toolbar', $toolbar);
        }
    }
}
