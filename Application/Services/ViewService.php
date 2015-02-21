<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;

/**
 * Class ViewService. Actions above application views
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/ViewService.php
 */
class ViewService implements InjectionAwareInterface
{
    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Engine model
     *
     * @var \Application\Models\Engines $engine;
     */
    protected $engine;

    /**
     * Init Engine params
     *
     * @param \Application\Models\Engines $engine
     */
    public function __construct(\Application\Models\Engines $engine) {
        $this->setEngine($engine);
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get View service
     *
     * @return \Phalcon\Mvc\View
     */
    public function getView()
    {
        return $this->getDi()->getShared('view');
    }

    /**
     * Get Engine object
     *
     * @return \Application\Models\Engines
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set engine object
     *
     * @param \Application\Models\Engines $engine
     * @return ViewService
     */
    public function setEngine(\Application\Models\Engines $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * Get configuration
     *
     * @return \Phalcon\Config
     */
    public function getConfig()
    {
        return $this->getDi()->get('config')->application;
    }

    /**
     * Define view as default
     *
     * @param string $layout default layout
     * @param string $partials default partials
     */
    public function define($layout = 'layout', $partials = 'partials') {

        $config =  $this->getConfig()->toArray();

        // setup special view directory for this engine
        $this->getView()->setViewsDir($config['viewsFront'].strtolower($this->getEngine()->getCode()))
            ->setMainView($layout)
            ->setPartialsDir($partials)
            ->setVar('engine', $this->engine->toArray());

        return $this->getView();
    }
}