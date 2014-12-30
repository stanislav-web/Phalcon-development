<?php
namespace Modules\Frontend\Controllers;

class ControllerBase extends \Phalcon\Mvc\Controller
{
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
