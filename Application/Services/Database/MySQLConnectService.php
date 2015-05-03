<?php
namespace Application\Services\Database;
use Phalcon\Db\Adapter\Pdo\Mysql as AdapterGateway;
use Phalcon\Db\Exception as DbException;

/**
 * Class MySQLConnectService. Connection to Database service
 *
 * @package Application\Services
 * @subpackage Database
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Database/MySQLConnectService.php
 */
class MySQLConnectService extends AdapterGateway {

    /**
     * Init MySQL Connect
     *
     * @param \Phalcon\Config $dbConfig
     */
    public function __construct(\Phalcon\Config $dbConfig) {

        try {

            $setup = [
                "host"          => $dbConfig->host,
                "username"      => $dbConfig->username,
                "password"      => $dbConfig->password,
                "dbname"        => $dbConfig->dbname,
                "persistent"    => $dbConfig->persistent,
                "options" => [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".$dbConfig->charset."'",
                    \PDO::ATTR_CASE => \PDO::CASE_LOWER,
                    \PDO::ATTR_ERRMODE => $dbConfig->debug,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            ];

            parent::__construct($setup);
        }
        catch(\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}