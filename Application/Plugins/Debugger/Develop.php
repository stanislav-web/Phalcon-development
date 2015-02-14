<?php
namespace Application\Plugins\Debugger;

use Phalcon\Db\Profiler as Profiler;
use Phalcon\Mvc\Url as URL;
use Phalcon\Mvc\View as View;

/**
 * Develop plugins for Phalcon (multimodule support)
 *
 * @package Phalcon
 * @subpackage Plugins
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Plugins/Debugger/Develop.php
 */
class Develop implements \Phalcon\DI\InjectionAwareInterface
{
    protected
        /**
         * Instance of DI
         * @var \Phalcon\DI\FactoryDefault
         */
        $_di = false,

        /**
         * Instance of Phalcon SQL Profiler
         * @var \Phalcon\Db\Profiler
         */
        $_profiler = false,

        /**
         * Required services to profiler even
         * @var array
         */
        $_serviceNames = ['db' => ['db'], 'dispatcher' => ['dispatcher'], 'view' => ['view']],

        /**
         * Set active developer's panels
         * @var array
         */
        $_panels = ['server', 'request', 'views', 'db', 'geoip', 'extensions', 'services'];

    private
        /**
         * Profiler start time
         * @var int
         */
        $startTime = 0,

        /**
         * Profiler finish time
         * @var int
         */
        $endTime,

        /**
         * \Phalcon\Db\Profiler() sql query counter
         * @var int
         */
        $queryCount = 0;


    /**
     * Initialize Informer
     *
     * @param \Phalcon\DI\FactoryDefault $di DI container with registered services
     * @param array $serviceNames
     * @access public
     * @return null
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di, array $serviceNames = [])
    {

        // init dependency container
        $this->_di = $di;

        // init current microtime to start
        $this->startTime = microtime(true);

        // init SQL profiler
        $this->_profiler = new Profiler();

        // get event manager
        $eventsManager = $di->get('eventsManager');

        // init incoming services
        if (!empty($serviceNames)) $this->_serviceNames = $serviceNames;

        // checking services if they are currently in use
        $diServices = $di->getServices();

        // parse all available services
        foreach ($diServices as $service) {
            $name = $service->getName();

            // find and shared available services
            if (isset($this->_serviceNames[$name])) {
                $service->setShared(true);
                $this->getDI()->get($name)->setEventsManager($eventsManager);
                // attach then to get
                $eventsManager->attach($name, $this);
            }
        }
    }

    /**
     * Implemented. Get DI container
     * @access public
     * @return \Phalcon\DI\FactoryDefault|\Phalcon\DiInterface
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * Implemented. Setup DI container
     *
     * @param \Phalcon\DiInterface $di
     * @access public
     * @return null
     */
    public function setDI($di)
    {
        $this->_di = $di;
    }

    /**
     * Get loaded service's name
     * @param string $event
     * @return mixed
     */
    public function getServices($event)
    {
        return $this->_serviceNames[$event];
    }

    /**
     * Gets/Saves information about views and stores truncated viewParams.
     * This event started automatically
     *
     * @param $event this event id
     * @param \Phalcon\Mvc\View $view
     * @access protected
     * @return null
     */
    public function beforeRenderView($event, $view)
    {
        $params = [];

        // collected all view params

        $toView = $view->getParamsToView();
        $toView = !$toView ? [] : $toView;

        if (!empty($toView)) {
            // parse view's params
            foreach ($toView as $k => $v) {
                if (is_object($v))
                    $params[$k] = get_class($v);
                elseif (is_array($v)) {
                    $array = array();
                    foreach ($v as $key => $value) {
                        if (is_object($value))
                            $array[$key] = 'Object[...]';
                        elseif (is_array($value))
                            $array[$key] = 'Array[...]';
                        else
                            $array[$key] = $value;
                    }
                } else
                    $params[$k] = (string)$v;
            }
        }

        // collected all params to array
        $this->_viewsRendered[] = [
            'path' => $view->getActiveRenderPath(),
            'params' => $params,
            'controller' => $view->getControllerName(),
            'action' => $view->getActionName(),
        ];
    }

    /**
     * Insert toolbar. This event started automatically
     *
     * @param $event this event id
     * @param \Phalcon\Mvc\View $view
     * @access protected
     * @return null
     */
    public function afterRender($event, $view, $viewFile)
    {
        $this->endTime = microtime(true);
        $content = $view->getContent();
        $rendered = $this->render();
        $rendered .= "</body>";
        $content = str_replace("</body>", $rendered, $content);

        // set vars
        $view->setContent($content);
    }

    /**
     * Render toolbar variable & views
     * @access public
     * @return \Phalcon\Mvc\View
     */
    public function render()
    {
        $view = new View();
        $viewDir = dirname(__FILE__) . '/views/';
        $view->setViewsDir($viewDir);
        // set vars
        $view->develop = $this;
        $content = $view->getRender('toolbar', 'index');
        return $content;
    }

    /**
     * Getter for panels array
     *
     * @access public
     * @return array
     */
    public function getPanels()
    {
        return $this->_panels;
    }

    /**
     * Getter for start time
     *
     * @access public
     * @return array
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Getter for end time
     *
     * @access public
     * @return array
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Getter for rendered views
     *
     * @access public
     * @return array
     */
    public function getRenderedViews()
    {
        return $this->_viewsRendered;
    }

    /**
     * Getter for sql queries counter
     *
     * @access public
     * @return array
     */
    public function getQueryCount()
    {
        return $this->queryCount;
    }

    /**
     * Getter for sql query profiler
     *
     * @access public
     * @return \Phalcon\Db\Profiler
     */
    public function getProfiler()
    {
        return $this->_profiler;
    }

    /**
     * Event is start before sql query execute.
     * Called by Phalcon automatically. Start profiler
     * Get sql statements
     *
     * @param $event this event id
     * @param $connection current database connection
     * @access protected
     * @return null
     */
    protected function beforeQuery($event, $connection)
    {
        $this->_profiler->startProfile(
            $connection->getRealSQLStatement(),
            $connection->getSQLVariables(),
            $connection->getSQLBindTypes()
        );
    }

    /**
     * Event is start after sql query execute.
     * Called by Phalcon automatically. Finish profiler,
     * incremented sql query counters
     *
     * @param $event this event id
     * @param $connection current database connection
     * @access protected
     * @return null
     */
    protected function afterQuery($event, $connection)
    {
        $this->_profiler->stopProfile();
        $this->queryCount++;
    }
}