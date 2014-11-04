<?php
namespace Modules;

use Phalcon\Loader,
    Phalcon\Events\Manager,
    Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Frontend module
 * @package Phalcon
 * @subpackage Frontend
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Modules/Module.php
 */
class Frontend implements ModuleDefinitionInterface
{
    /**
     * Global config
     * @var bool | array
     */
    protected $_config = false;

    /**
     * Configuration init
     */
    public function __construct() {

        $this->_config = \Phalcon\DI::getDefault()->get('config');
    }

    /**
     * Register the autoloader specific to the current module
     * @access public
     * @return \Phalcon\Loader\Loader()
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces([
            'Modules\Frontend\Controllers' => APP_PATH.'/Modules/Frontend/Controllers/',
        ])
        ->registerDirs([
            $this->_config->application->libraryDir,
            $this->_config->application->modelsDir
        ]);

        if(isset($this->_config->database->profiler)) {

            $loader->registerNamespaces([
                array_merge(
                    $loader->getNamespaces(),
                    ['Libraries\\Debug\\PDW\\DebugWidget'   =>  $this->_config->application->libraryDir.'Debug/PDW/DebugWidget.php']
                )
            ]);
        }

        //Listen all the loader events
        $eventsManager = (new Manager())->attach('loader', function($event, $loader) {
            if($event->getType() == 'beforeCheckPath') {
                echo $loader->getCheckedPath();
            }
        });

        $loader->setEventsManager($eventsManager);
        $loader->register();

        // Stand up profiler
        if(isset($this->_config->database->profiler))
            (new \DebugWidget(\Phalcon\Di::getDefault()));

        var_dump($loader);
    }

    /**
     * Registration services for specific module
     * @param \Phalcon\DI $di
     * @access public
     * @return mixed
     */
    public function registerServices($di)
    {
        return require_once APP_PATH.'/Modules/Frontend/config/services.php';
    }

}