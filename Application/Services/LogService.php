<?php
namespace Application\Services;

use Application\Libraries\CacheManagement\CacheExceptions;
use \Phalcon\DI\InjectionAwareInterface;
use \Phalcon\Logger;
/**
 * Class LogService. Log Service
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/LogService.php
 */
class LogService implements InjectionAwareInterface {

    /**
     * Available log code
     *
     * @var array $codes
     */
    private $codes = [
        Logger::ALERT       =>  'alert',
        Logger::CRITICAL    =>  'critical',
        Logger::DEBUG       =>  'debug',
        Logger::ERROR       =>  'error',
        Logger::INFO        =>  'info',
        Logger::NOTICE      =>  'notice',
        Logger::WARNING     =>  'warning'
    ];

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

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
     * Log save handler
     *
     * @param string $message
     */
    public function save($message, $code) {

        if(array_key_exists($code, $this->codes) === true) {
            if ($this->getDi()->has('logger') === true) {

                $this->getDi()->get('logger')->{$this->codes[$code]}($message);
            }
        }
        else {
            throw new \Exception('Log code not found');
        }

    }
}