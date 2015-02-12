<?php
namespace Services;

use \Phalcon\DI\InjectionAwareInterface;
use Models\Engines;
use \Phalcon\Mvc\Model\Exception;

/**
 * Class EngineService
 * @package    Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps//Services/EngineService.php
 */
class EngineService implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Current host
     *
     * @var string $host;
     */
    protected $host;

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
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Set current hostname
     *
     * @param string $host
     */
    public function __construct($host) {

        $this->host = $host;
    }

    /**
     * Define used engine
     *
     * @return \Models\Engines $engine
     */
    public function define() {

        $session = $this->di->getShared('session');
        // find current engine
        if($session->has('engine') === false) {

            $engine   =   Engines::findFirst("host = '".$this->host."'");

            if($engine === null) {
                throw new Exception('Not found used host');
            }

            // collect to the session
            $session->set('engine', $engine);
        }
        else {
            // get current engine
            $engine  =   $session->get('engine');
        }

        return $engine;
    }

}