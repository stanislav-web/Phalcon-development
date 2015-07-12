<?php
namespace Application\Services\Mappers;

use Phalcon\Logger;
use Phalcon\Http\Request;
use Phalcon\Di;
use Phalcon\Logger\Adapter\Database as LoggerDatabase;
use Application\Models\Logs;
use Application\Modules\Rest\DTO\LogDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class LogsMapper. Actions above logs
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/LogMapper.php
 */
class LogMapper {

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
     * @var \Phalcon\Logger\Adapter\Database $loggerDatabase;
     */
    protected $loggerDatabase;

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

        $this->loggerDatabase = new LoggerDatabase($dispatcher->getModuleName(), [
            'db'    => $connection,
            'table' => $this->getInstance()->getSource()
        ]);
    }

    /**
     * Get Dependency injection container
     *
     * @return \Phalcon\Di
     */
    public function getDi() {
        return (new Di())->getDefault();
    }

    /**
     * Get Translate service
     *
     * @return \Translate\Translator|null
     */
    private function getTranslator() {

        if($this->getDi()->has('TranslateService') === true) {
            return $this->getDi()->get('TranslateService')->assign('errors');
        }

        return null;
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
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
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
     * Create record
     *
     * @param array $params
     *
     * @throws \Application\Modules\Rest\Exceptions\NotFoundException
     */
    public function create(array $params) {

        $model = $this->getInstance();
        $request = new Request();
        $params['ip'] = $request->getClientAddress();
        $params['refer'] = (isset($params['refer'])) ? $params['refer'] : $request->getHTTPReferer();
        $params['method'] = $request->getMethod();

        $data = [];
        foreach(array_flip(array_diff($model::CONTENT_DEFINITION_PARAMS, $params)) as $k => $v) {
            if(isset($params[$k]) === true) {
                $data[$k] = $params[$k];
            }
        }

        $this->save($data, (int)$params['code']);
    }

    /**
     * Log save handler
     *
     * @param string $message
     * @param int $code
     */
    public function save($message, $code) {

        if(array_key_exists($code, $this->codes) === true) {

            $message = (is_array($message) === true) ? json_encode($message) : $message;
            $this->loggerDatabase->log($message, $code);
        }
        else {

            throw new NotFoundException([
                'LOG_CODE_NOT_FOUND' => sprintf($this->getTranslator()->translate('LOG_CODE_NOT_FOUND'), $code)
            ]);
        }
    }
}