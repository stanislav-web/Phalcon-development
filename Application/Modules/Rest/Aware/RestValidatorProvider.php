<?php
namespace Application\Modules\Rest\Aware;

/**
 * RestValidatorProvider. Rest API Provide validation services
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestValidatorProvider.php
 */
abstract class RestValidatorProvider {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DI\FactoryDefault $di;
     */
    private $di;

    /**
     * Set dependency container
     *
     * @param \Phalcon\DI\FactoryDefault $di
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
     * Get api config
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->getDi()->get('RestConfig')->api;
    }

    /**
     * Get session
     *
     * @return \Phalcon\Session\Adapter\Memcache
     */
    public function getSession() {
        return $this->getDi()->getShared('session');
    }

    /**
     * Get request plugin
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest() {
        return $this->getDi()->getShared('request');
    }

    /**
     * Get shared dispatcher
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher() {
        return $this->getDi()->getShared('dispatcher');
    }

    /**
     * Run validator
     *
     * @param \Phalcon\DI\FactoryDefault $di
     * @param \StdClass $rules
     * @return boolean
     */
    abstract protected function run(\Phalcon\DI\FactoryDefault $di, \StdClass $rules);
}