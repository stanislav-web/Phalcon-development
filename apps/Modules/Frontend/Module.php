<?php
namespace Modules;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

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
     * Current module name
     * @var const
     */
    const MODULE = 'Frontend';

    /**
     * Global config
     * @var bool | array
     */
    protected $_config = false;

    /**
     * Configuration init
     */
    public function __construct()
    {
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
            'Modules\Frontend\Controllers' => $this->_config['application']['controllersFront'],
            'Models' => $this->_config['application']['modelsDir'],
            'Helpers' => $this->_config['application']['helpersDir'],
            'Libraries' => $this->_config['application']['libraryDir'],
            'Plugins' => $this->_config['application']['pluginsDir'],
        ]);

        $loader->register();
    }

    /**
     * Registration services for specific module
     * @param \Phalcon\DI $di
     * @access public
     * @return mixed
     */
    public function registerServices($di)
    {
        // Dispatch register
        $di->set('dispatcher', function () use ($di) {

            $eventsManager = $di->getShared('eventsManager');

            $eventsManager->attach('dispatch:beforeException', new \Plugins\Dispatcher\NotFoundPlugin());

            $dispatcher = new \Phalcon\Mvc\Dispatcher();

            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Modules\\' . self::MODULE . '\Controllers');

            return $dispatcher;
        }, true);

        // Database connection is created based in the parameters defined in the configuration file

        $di->set('db', function () {

            try {
                $connect = new \Phalcon\Db\Adapter\Pdo\Mysql([
                    "host" => $this->_config->database->host,
                    "username" => $this->_config->database->username,
                    "password" => $this->_config->database->password,
                    "dbname" => $this->_config->database->dbname,
                    "persistent" => $this->_config->database->persistent,
                    "options" => [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$this->_config->database->charset}'",
                        \PDO::ATTR_CASE => \PDO::CASE_LOWER,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                    ]
                ]);
                return $connect;
            }
            catch (\PDOException $e) {
                echo $e->getMessage();
            }

        }, true);

        // Registration of component representations (Views)

        $di->set('view', function () {
            $view = new View();
            return $view;
        });

        require_once APP_PATH . '/Modules/' . self::MODULE . '/config/services.php';

        return;
    }

}