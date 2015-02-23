<?php
namespace Application\Services;

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
class LogDbService extends LoggerDatabase {

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
     * Init log service
     *
     * @param \Phalcon\Db\Adapter\Pdo\Mysql $connection
     * @throws Logger\Exception
     */
    public function __construct(\Phalcon\Db\Adapter\Pdo\Mysql $connection) {

        $dispatcher = \Phalcon\DI\FactoryDefault::getDefault()->get('dispatcher');

        parent::__construct($dispatcher->getModuleName(), [
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
            throw new \Exception('Logger code not found');
        }

    }
}