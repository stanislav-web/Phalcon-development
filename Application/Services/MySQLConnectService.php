<?php
namespace Application\Services;
use Phalcon\Db\Adapter\Pdo\Mysql as AdapterGateway;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Events\Manager as EventsManager;

/**
 * Class MySQLConnectService. Connection to Database service
 *
 * @package Application
 * @subpackage Services
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/MySQLConnectService.php
 */
class MySQLConnectService extends AdapterGateway {

    /**
     * Init MySQL Connect
     *
     * @param array $dbConfig
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function __construct(array $dbConfig) {

        try {
            parent::__construct([
                "host"          => $dbConfig['host'],
                "username"      => $dbConfig['username'],
                "password"      => $dbConfig['password'],
                "dbname"        => $dbConfig['dbname'],
                "persistent"    => $dbConfig['persistent'],
                "options" => [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$dbConfig['charset']}'",
                    \PDO::ATTR_CASE => \PDO::CASE_LOWER,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]
            ]);
        }
        catch(\PDOException $e) {
            throw new \Phalcon\Db\Exception($e->getMessage());
        }
    }
}