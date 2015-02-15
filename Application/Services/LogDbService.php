<?php
namespace Application\Services;

use \Phalcon\DI\InjectionAwareInterface;
use \Phalcon\Logger;
use Phalcon\Logger\Adapter\Database as LoggerDatabase;

/**
 * Class LogDbService. Save logs into database
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/LogDbService.php
 */
class LogDbService extends LoggerDatabase
    implements InjectionAwareInterface {

    /**
     * Available log code
     *
     * @var array $codes
     */
    private $codes = [
        Logger::ALERT,
        Logger::CRITICAL,
        Logger::DEBUG,
        Logger::ERROR,
        Logger::INFO,
        Logger::NOTICE,
        Logger::WARNING
    ];

    /**
     * Logging name
     *
     * @var string $name
     */
    protected $name = 'app';

    /**
     * Table
     *
     * @var string $table
     */
    private $table = 'logs';

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
     * Init log service
     *
     * @param \Phalcon\Db\Adapter\Pdo\Mysql $connection
     * @throws Logger\Exception
     */
    public function __construct(\Phalcon\Db\Adapter\Pdo\Mysql $connection) {
        parent::__construct($this->name, [
            'db'    => $connection,
            'table' => $this->table
        ]);
    }

    /**
     * Log save handler
     *
     * @param string $message
     */
    public function save($message, $code) {

        if(array_key_exists($code, $this->codes) === true) {

            $this->log($message, $code);
        }
        else {
            throw new \Exception('Log code not found');
        }

    }
}