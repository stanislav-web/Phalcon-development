<?php
namespace Application\Services\Mappers;

use Application\Modules\Rest\DTO\LogDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Database as LoggerDatabase;
use Application\Models\Logs;

/**
 * Class LogsMapper. Actions above logs
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/LogMapper.php
 */
class LogMapper extends LoggerDatabase {

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
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di;
     */
    protected $di;

    /**
     * Init logger connector
     *
     * @param \Phalcon\Db\Adapter\Pdo\Mysql $connection
     * @throws \Phalcon\Logger\Exception
     */
    public function __construct(\Phalcon\Db\Adapter\Pdo\Mysql $connection, \Phalcon\Mvc\Dispatcher $dispatcher) {

        if(empty($dispatcher->getModuleName()) === true) {
            $dispatcher->setModuleName('Global');
        }

        parent::__construct($dispatcher->getModuleName(), [
            'db'    => $connection,
            'table' => $this->getInstance()->getSource()
        ]);
    }


    /**
     * Get instance of polymorphic object
     *
     * @return Logs
     */
    public function getInstance() {
        return new Logs();
    }

    /**
     * Read logs
     *
     * @param array $credentials credentials
     * @return mixed
     */
    public function read(array $credentials = []) {

        $result = $this->getInstance()->find($credentials);

        if($result->count() > 0) {
            return (new LogDTO())->setLogs($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
     * Get model attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        $metaData = $this->getInstance()->getModelsMetaData();
        return $metaData->getAttributes($this->getInstance());
    }

    /**
     * Log save handler
     *
     * @param string $message
     * @param int $code
     */
    public function save($message, $code) {

        if(array_key_exists($code, $this->codes) === true) {

            $this->log($message, $code);
        }
        else {
            throw new NotFoundException([
                'LOG_CODE_NOT_FOUND' => 'Logger code not found'
            ]);
        }
    }
}